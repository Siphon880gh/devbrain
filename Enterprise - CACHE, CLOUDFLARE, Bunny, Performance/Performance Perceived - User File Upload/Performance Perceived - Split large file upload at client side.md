## Overview

Split a large file, such as a 100 MB file, on the client side into smaller chunks. Then upload those chunks to the server. After all chunks are uploaded, the server combines them back into the original file.

A simple and safe approach is to upload one chunk at a time in the background while the user stays on the webpage.

During the upload, you can show either:

```txt
Upload progress: 45%
```

or show a small bottom-right message such as:

```txt
Uploading your file in the background. Please do not leave this page.
```

You can also keep the user engaged by showing useful information, tips, or other content while the upload continues.

This does **not** magically make the user’s internet faster, because the same total amount of data still needs to be uploaded. However, chunked uploading makes the upload more reliable, easier to track, and easier to resume if something fails.

---

## Client-Side: Browser Splits Large File Upload into Chunks

A browser client **can split a large file into smaller chunks** and upload each chunk separately.

The browser can do this with the `File` / `Blob` API using:

```js
file.slice(start, end)
```

This is commonly called:

* chunked upload
* multipart upload
* resumable upload
* split upload

The basic flow is:

1. User selects a large file.
2. Browser splits it into chunks, for example 5 MB each.
3. Browser uploads each chunk with metadata:

   * `uploadId`
   * `chunkIndex`
   * `totalChunks`
   * original filename
4. Server saves each chunk temporarily.
5. After all chunks arrive, the server merges them back into one file.

Example browser code:

```js
async function uploadLargeFile(file) {
  const chunkSize = 5 * 1024 * 1024; // 5 MB
  const totalChunks = Math.ceil(file.size / chunkSize);
  const uploadId = crypto.randomUUID();

  for (let chunkIndex = 0; chunkIndex < totalChunks; chunkIndex++) {
    const start = chunkIndex * chunkSize;
    const end = Math.min(start + chunkSize, file.size);

    const chunk = file.slice(start, end);

    const formData = new FormData();
    formData.append("uploadId", uploadId);
    formData.append("chunkIndex", chunkIndex);
    formData.append("totalChunks", totalChunks);
    formData.append("filename", file.name);
    formData.append("chunk", chunk);

    await fetch("/upload-chunk", {
      method: "POST",
      body: formData
    });
  }

  await fetch("/complete-upload", {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      uploadId,
      filename: file.name,
      totalChunks
    })
  });
}
```

HTML example:

```html
<input type="file" id="fileInput" />

<script>
document.getElementById("fileInput").addEventListener("change", async (e) => {
  const file = e.target.files[0];
  await uploadLargeFile(file);
});
</script>
```

For an Express server, you usually do **not** want to send the chunks as JSON/base64. Use `multipart/form-data` with something like `multer` or `busboy`.

Conceptually, your server routes would be:

```js
POST /upload-chunk
```

Save each chunk as:

```txt
uploads/temp/{uploadId}/chunk-0
uploads/temp/{uploadId}/chunk-1
uploads/temp/{uploadId}/chunk-2
```

Then:

```js
POST /complete-upload
```

Merge the chunks in order:

```txt
chunk-0 + chunk-1 + chunk-2 = final-file.mp4
```

Important notes:

* This helps avoid `payload too large` errors because each request is smaller.
* Your server/proxy still needs to allow the **chunk size**, for example 5 MB or 10 MB.
* Add retries per chunk so failed chunks can be reuploaded.
* Add validation so users cannot fake `uploadId`, overwrite files, or upload unlimited data.
* For production, store progress in a DB or Redis.
* For very large files, consider uploading chunks directly to S3 or another object storage service.

For Express/Heroku specifically, chunking helps a lot because you avoid sending one huge request through Express. You still need to make sure your middleware is not trying to parse the file body as JSON. Use multipart streaming instead.

---

## Server-Side: Combining Uploaded Chunks Back Into One File

After the browser uploads all file chunks, the server needs to combine them back into the original file.

The general idea is the same in every backend language:

1. Save each uploaded chunk into a temporary folder.
    
2. Name the chunks in order, such as `chunk-0`, `chunk-1`, `chunk-2`.
    
3. When all chunks are uploaded, open a final output file.
    
4. Read each chunk in order and append it to the final file.
    
5. Delete the temporary chunk files afterward.
    

Example temporary file structure:

```txt
uploads/temp/abc123/chunk-0
uploads/temp/abc123/chunk-1
uploads/temp/abc123/chunk-2
```

After combining:

```txt
uploads/final/my-large-video.mp4
```

---

### PHP Example: Combine Chunks

```php
<?php

$uploadId = $_POST['uploadId'];
$filename = basename($_POST['filename']);
$totalChunks = intval($_POST['totalChunks']);

$tempDir = __DIR__ . "/uploads/temp/" . $uploadId;
$finalDir = __DIR__ . "/uploads/final";

if (!is_dir($finalDir)) {
    mkdir($finalDir, 0777, true);
}

$finalPath = $finalDir . "/" . $filename;

$output = fopen($finalPath, "wb");

if (!$output) {
    http_response_code(500);
    echo "Could not create final file.";
    exit;
}

for ($i = 0; $i < $totalChunks; $i++) {
    $chunkPath = $tempDir . "/chunk-" . $i;

    if (!file_exists($chunkPath)) {
        fclose($output);
        http_response_code(400);
        echo "Missing chunk: " . $i;
        exit;
    }

    $input = fopen($chunkPath, "rb");

    while (!feof($input)) {
        fwrite($output, fread($input, 1024 * 1024)); // 1 MB at a time
    }

    fclose($input);
}

fclose($output);

// Optional cleanup
for ($i = 0; $i < $totalChunks; $i++) {
    unlink($tempDir . "/chunk-" . $i);
}

rmdir($tempDir);

echo "File combined successfully.";
```

In PHP, the important part is opening the final file with:

```php
fopen($finalPath, "wb");
```

Then each chunk is opened with:

```php
fopen($chunkPath, "rb");
```

This reads the chunks as binary data, which is important for videos, images, ZIP files, PDFs, and other non-text files.

---

### Node.js Example: Combine Chunks

```js
const fs = require("fs");
const path = require("path");

async function combineChunks(uploadId, filename, totalChunks) {
  const safeFilename = path.basename(filename);

  const tempDir = path.join(__dirname, "uploads", "temp", uploadId);
  const finalDir = path.join(__dirname, "uploads", "final");
  const finalPath = path.join(finalDir, safeFilename);

  await fs.promises.mkdir(finalDir, { recursive: true });

  const writeStream = fs.createWriteStream(finalPath);

  for (let i = 0; i < totalChunks; i++) {
    const chunkPath = path.join(tempDir, `chunk-${i}`);

    if (!fs.existsSync(chunkPath)) {
      throw new Error(`Missing chunk: ${i}`);
    }

    await new Promise((resolve, reject) => {
      const readStream = fs.createReadStream(chunkPath);

      readStream.on("error", reject);
      readStream.on("end", resolve);

      readStream.pipe(writeStream, { end: false });
    });
  }

  writeStream.end();

  // Optional cleanup
  for (let i = 0; i < totalChunks; i++) {
    const chunkPath = path.join(tempDir, `chunk-${i}`);
    await fs.promises.unlink(chunkPath);
  }

  await fs.promises.rmdir(tempDir);

  return finalPath;
}
```

Example Express route:

```js
app.post("/complete-upload", async (req, res) => {
  try {
    const { uploadId, filename, totalChunks } = req.body;

    const finalPath = await combineChunks(
      uploadId,
      filename,
      Number(totalChunks)
    );

    res.json({
      success: true,
      path: finalPath
    });
  } catch (error) {
    res.status(500).json({
      success: false,
      error: error.message
    });
  }
});
```

In Node.js, the key idea is:

```js
readStream.pipe(writeStream, { end: false });
```

This appends each chunk into the same final file without closing the write stream after each chunk.

---

### Python Example: Combine Chunks

```python
import os
import shutil

def combine_chunks(upload_id, filename, total_chunks):
    safe_filename = os.path.basename(filename)

    base_dir = os.path.dirname(os.path.abspath(__file__))
    temp_dir = os.path.join(base_dir, "uploads", "temp", upload_id)
    final_dir = os.path.join(base_dir, "uploads", "final")

    os.makedirs(final_dir, exist_ok=True)

    final_path = os.path.join(final_dir, safe_filename)

    with open(final_path, "wb") as output_file:
        for i in range(total_chunks):
            chunk_path = os.path.join(temp_dir, f"chunk-{i}")

            if not os.path.exists(chunk_path):
                raise Exception(f"Missing chunk: {i}")

            with open(chunk_path, "rb") as chunk_file:
                shutil.copyfileobj(chunk_file, output_file)

    # Optional cleanup
    for i in range(total_chunks):
        chunk_path = os.path.join(temp_dir, f"chunk-{i}")
        os.remove(chunk_path)

    os.rmdir(temp_dir)

    return final_path
```

Example Flask route:

```python
from flask import Flask, request, jsonify

app = Flask(__name__)

@app.route("/complete-upload", methods=["POST"])
def complete_upload():
    data = request.get_json()

    upload_id = data["uploadId"]
    filename = data["filename"]
    total_chunks = int(data["totalChunks"])

    try:
        final_path = combine_chunks(upload_id, filename, total_chunks)

        return jsonify({
            "success": True,
            "path": final_path
        })

    except Exception as error:
        return jsonify({
            "success": False,
            "error": str(error)
        }), 500
```

In Python, the important part is opening the final file in binary write mode:

```python
open(final_path, "wb")
```

Then each chunk is opened in binary read mode:

```python
open(chunk_path, "rb")
```

This prevents file corruption when combining videos, images, PDFs, ZIP files, and other binary files.

---

### Important Security Notes

Do not trust the filename directly from the browser. A malicious user could send a filename like:

```txt
../../../some-server-file
```

So you should always sanitize it.

For example:

PHP:

```php
$filename = basename($_POST['filename']);
```

Node.js:

```js
const safeFilename = path.basename(filename);
```

Python:

```python
safe_filename = os.path.basename(filename)
```

Also validate:

- maximum file size
    
- allowed file types
    
- number of chunks
    
- chunk size
    
- user permission to upload
    
- whether the upload ID belongs to that user
    

For production systems, also store upload progress in a database or Redis so the server knows which chunks have already arrived.