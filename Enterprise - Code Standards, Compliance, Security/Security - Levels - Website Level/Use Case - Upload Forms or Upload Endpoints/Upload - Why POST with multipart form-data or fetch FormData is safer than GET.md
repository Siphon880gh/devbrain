
Titled: Upload - Why POST with multipart form-data or fetch FormData is safer than GET

### ⚠️ How attackers _abuse_ `GET` to "upload" files

Technically, `GET` is not meant for uploading files. But careless code can let an attacker _simulate_ a file upload by misusing URL parameters in a way that **writes to the filesystem**, like this:

  
uploader.php:
```
// Bad example!  
file_put_contents('uploads/' . $_GET['filename'], $_GET['content']);  
```

  
With a URL like:
```
https://example.com/upload.php?filename=shell.php&content=<?php%20system($_GET['cmd']); ?>  
```

This "uploads" a PHP shell to your server just by visiting a link — no form submission needed.


#### 🔍 What just happened?

- `filename` is user-controlled: attacker names it `shell.php`
- `content` is user-controlled: attacker injects PHP code
- `file_put_contents()` writes that data to disk with **no validation**

Now `https://example.com/uploads/shell.php?cmd=whoami` is a remote shell.

---

###  `POST` + `multipart/form-data` is safer

When using a proper upload form:
- Files go through `$_FILES`, not `$_GET`
- PHP checks file metadata (tmp name, MIME type, size)
- You can inspect and sanitize file types
- You can deny `.php`, `.exe`, etc.
- You can rename files and store safely

#### **HTML (Upload form)**
```
<form action="upload.php" method="POST" enctype="multipart/form-data">  
  <label>Select file:</label>  
  <input type="file" name="myfile" required>  
  <button type="submit">Upload</button>  
</form>
```

#### **PHP (upload.php)**
```
<?php  
$uploadDir = 'uploads/';  
$allowedTypes = ['image/jpeg', 'image/png', 'application/pdf']; // Example types  
  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    if (isset($_FILES['myfile']) && $_FILES['myfile']['error'] === UPLOAD_ERR_OK) {  
        $fileTmp  = $_FILES['myfile']['tmp_name'];  
        $fileName = basename($_FILES['myfile']['name']);  
        $fileType = mime_content_type($fileTmp);  
  
        // Validate file type  
        if (!in_array($fileType, $allowedTypes)) {  
            die("❌ Invalid file type");  
        }  
  
        // Sanitize filename  
        $safeName = preg_replace("/[^a-zA-Z0-9\.\-_]/", "_", $fileName);  
        $destPath = $uploadDir . $safeName;  
  
        if (move_uploaded_file($fileTmp, $destPath)) {  
            echo "✅ File uploaded successfully: $safeName";  
        } else {  
            echo "❌ Failed to move uploaded file.";  
        }  
    } else {  
        echo "❌ No file uploaded or upload error.";  
    }  
}  
?>
```

####   🔐 Key Protections:

- Uses `$_FILES` (not `$_GET`).
- Checks MIME type.
- Sanitizes file name.
- Saves to a dedicated `uploads/` folder (not public root).
- Avoids executable extensions.

#### Take it further?

You can have the script rename uploaded files to a unique name (e.g. with timestamp or UUID) to prevent hacker bots from uploading then visiting the uploaded file.

### POST + Fetch and FormData

Instead of using the `<form action=...>`, you can **upload files with JavaScript using `fetch()` and `FormData`**. This gives you more control (e.g., for progress bars, drag-and-drop uploads, or submitting via AJAX without reloading the page).

#### HTML (Upload form):
```
<input type="file" id="fileInput">  
<button onclick="uploadFile()">Upload</button>  
<div id="result"></div>
```

#### JS:
```
function uploadFile() {  
    const fileInput = document.getElementById('fileInput');  
    const file = fileInput.files[0];  
    if (!file) return;  
  
    const formData = new FormData();  
    formData.append('myfile', file);  
  
    fetch('upload.php', {  
        method: 'POST',  
        body: formData  
    })  
    .then(res => res.text())  
    .then(data => {  
        document.getElementById('result').innerText = data;  
    })  
    .catch(err => {  
        document.getElementById('result').innerText = 'Upload failed';  
    });  
}
```

#### PHP:
Same upload.php as before

### 🔍 Why use JS `fetch()` + `FormData`?

- No page reload
- Can show upload progress
- Easier to integrate into SPA frameworks (React, Vue, etc.)
- Can add custom headers or tokens

---

### 💡 Summary

| Method             | Purpose       | Safe? | Danger                                  |
| ------------------ | ------------- | ----- | --------------------------------------- |
| `GET`              | Retrieve data | ❌ NO  | Can be abused to write files if misused |
| `POST` + `$_FILES` | Upload files  | ✅ YES | Allows validation, safe handling        |