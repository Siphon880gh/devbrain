
How to use: Turn on persistent "Table of Contents"

---

## Main concepts of XSS

### Untrusted Input  

Any data coming from a GET parameter is inherently untrusted since it can be manipulated by the client. Trusting it without sanitization can make your application vulnerable to attacks.

Data coming from file upload form or upload endpoint also cannot be trusted. Refer to [[_ Security Checklist - Upload]].

### Cross-Site Scripting (XSS)

#### Reflected Non-Persistent XSS

This type of security vulnerability occurs when a website includes user-provided information without properly validating or sanitizing how it got that information. For example, imagine a website that greets a visitor by name after they fill out a form or click a personalized link—something like, “Welcome, Weng!” Either way, the website's link has the user's name, and that's how the website knows how to address the user by name. The URL could be `index.php?name=Weng` or `https://wengteacheshacking/?name=Weng`   

But if the website is not built securely to validate / sanitize inputs it gets from the URL in order to know how to display information on the webpage, the hacker could craft a link that includes harmful code instead of a name. When the webpage displays that code, it acts like javascript affecting the user. It could be anything as harmless as an alert dialogue to even more severe like accessing the logged in user's credentials/cookies then sending that cookie information to an external server (the hacker's API endpoint that has CORS enabled).  

The real danger comes when the hacker shares the link with others—such as customers, employees, or site administrators. The hacker can also spoof an email to pretend to be a trusted source of the recipient. The hacker could also obscure the link, usually be encoding the code portion of the url so it doesn't pop up as code for programmers. The older way is to shorten the url using services like bitly, but now email providers are privy to that and will automatically label such emails as spam.
#### Reflected Persistent XSS

If a webpage or web app shows user inputs that were saved unsanitized through a form or api endpoints, usually to a database, or more rarely a json file, then it gets displayed on the webpage, it is also a cross site scripting. An example is user comment having bad javascript and all users can see these comments, which could have included javascript that steals cookies and sends to an API endpoint  

You have to sanitize front end or url parameter depending on method of input. And the endpoint that processes that input must also sanitize, otherwise the hacker could make a request to the endpoint manually which bypasses the sanitation from the frontend.

### Sanitation

Sanitation in security refers to the process of cleaning and validating user input to prevent malicious data from compromising an application. Proper sanitation helps defend against threats like Cross-Site Scripting (XSS) and SQL injection by neutralizing potentially harmful input before it can be executed.

For more information on Sanitation, refer to: [[Sanitization of inputs (form inputs, url search param, etc)]]


## List of url search param vulnerabilities

### **Reflected Non-Persistent XSS**

A webpage displays the user's name, for example, in a greeting "Welcome Weng!". The mechanism behind this may be the URL. The user filled a form that asked for their name. The following page starts greeting the user. Or an user clicks a link in their email, and it opens a webpage that's personalized with their name. The url is usually in this format:
```
index.php?name=Weng
```

And the careless coder wrote something like this for index.php:
```
<?php  
    $name = $_GET['name'] ?? "";  
    echo $name;  
?>
```

That's going to be unsafe because the hacker could visited `index.php?name=<script>alert(”Hacked!”);</script>`   

Which echoes or reflects the javascript injected onto the user's web browser. That may seem useless because it's "isolated" to the hacker visiting the url. But the url could share the link to others to ruin your company' reputation or worse: The javascript can quietly access the user's cookies (especially useful for logged in users), then sends credentials to an external api endpoint (that the hacker owns and have CORS enabled).

---
### **File Opening via URL Search Param**

The application is unintentionally safe from XSS in this case because it attempts to open the `search` parameter as a file rather than rendering it directly in the output. However, opening files from URL has other vulnerabilities. 

Firstly, here's the code:
```
<?php  
     ini_set('display_errors', 1);  
     ini_set('display_startup_errors', 1);  
     error_reporting(E_ALL);  
  
    $filepath = $_GET['filepath'] ?? "";  
  
    if(strlen($filepath)===0) {  
        echo "Make sure to have filepath= in url search params.";  
        die();  
    }  
  
    $contents = file_get_contents($filepath);  
    $contents = str_replace("\n", "<br>", $contents);  
    echo $contents;  
?>
```

The url was being used by the web developer as a mechanism to open specific files.

But it opens you to local file inclusion (LFI) vulnerability.

If a hacker manipulates the parameter to access sensitive files, usually outside the current folder, they are going to be able to read the sensitive file, based on the code as it is now.

With `file_get_contents($_GET['file'])`… and the hacker visits:
```
https://yourdomain.com/index.php?file=../../../../etc/passwd
```
They read your server's credentials.

If the hacker visits  `.../../.env` , they could gain access to your API keys or Mongo credentials, or whatever you may have stored in the .env file. The .env file may not be necessarily two levels up from the current folder, but the hacker can brute force different levels easily by changing the URL: `../.env` → `../../../.env`  etc

#### **Naive Use Cases:**
You have a book reading app. You have URLs that can be sent from user to friends that open ebooks based on the url path [https://123readanybook.com/?book=HowToWinFriends.pdf](https://123readanybook.com/?book=HowToWinFriends.pdf)

But you're not expecting a hacker to leverage this using url path `https://123readanybook.com/?book=../../../../etc` and then shortly after steal your entire server from you.

#### **Safe-ish but not quite the right to correctly do things:**
By fetching directly the url, any "../" can't go beyond the web root document, nor can they access dotted files like .env, because this would be the equivalent of typing the domain address with the relative path to the sensitive file in the address bar. So safe-ish:
```
<?php
    $filepath = $_GET['filepath'] ?? "";

    if(strlen($filepath)===0) {
        echo "Make sure to have filepath= in url search params.";
        die();
    }
?>

    <script>
      const filepath = "<?php echo $filepath; ?>";

      fetch(filepath, {
                cache: "no-cache"
            }).then(response => response.text())
            .then(myMarkdown => {
                var md = window.markdownit({
                    html: true,
                    linkify: true
                });
                
                
                var result = md.render(myMarkdown);
                document.querySelector(".container").innerHTML = result;
            });
    </script>
```

#### **SOLUTION:**

Much of PHP's opening of filenames can handle encoded urls. The hacker may encode the url to hide code from being obvious, and they may encode once/twice/thrice/etc. You have to recursively decode the input value before trying to fix it

Then you may use regular expression to remove zero or more `../` - OR - simply use basename() in PHP to extract only the filename `$safeName = basename($filepath;` then reading from the appropriate folder.

With basename, the code could look like:
```
    $filename = basename($_GET['filepath']);  // Strips out all directory pathing  
    $fullPath = "./" . $filename;  
  
    $contents = file_get_contents($fullPath);  
    echo $contents;
```

A reason why you must decode recursively is, for example, if you use regular expressions to remove zero or more of `../` :

The hacker can work around that type of naive bypass security filters by:
=%2e%2e%2f%2e%2e%2f.env (encode once)
=%252e%252e%252f%252e%252e%252f.env (double encode)

Or some combo like:
=%2e.%2f%2e.%2f.env (encode ., then literal ., then encode /)
=.%2e%2f.%2e%2f.env (literal ., then encode ., then encode)
=%2e%2e/%2e%2e/.env (literal ., then encode ., then encode /)
and that doesn't even cover all the possibilities.

Many of PHP's functions that open files automatically can open files with encoded characters.

#### **Solution Variant: Allowing Nested Folders Securely with `realpath()`**

Suppose you want to allow users to access files like `weng/books/book1.pdf` or `weng/books/self-improvement/book.pdf` using a `filepath` URL parameter—but without restricting them to a fixed directory depth. In that case, `basename()` won't work because it only returns the final part of a path, making it unsuitable for nested folders.

To handle this more flexibly and securely, you can use the following approach:
```
$baseDir = realpath(__DIR__ . "/./");  // Set the base directory  
$requestedFile = realpath($baseDir . '/' . $_GET['filepath']);  // Resolve full path  
  
// Ensure the requested file is within the allowed base directory  
if (strpos($requestedFile, $baseDir) !== 0) {  
    die("Invalid file path or access denied.");  
}  
  
$contents = file_get_contents($requestedFile);  
echo $contents;
```

**Why this works:**
- `realpath()` normalizes the path by resolving `..`, `.`, and symbolic links.
    
- By verifying that the resolved `$requestedFile` begins with `$baseDir`, you're making sure the request stays within the permitted directory tree.
    
- Valid nested paths (e.g., `january/photo.png`) resolve correctly and are allowed.
    
- Malicious paths (e.g., `../../.env`, even if URL-encoded) resolve outside the base and get blocked.
    

  

But don't forget to recursively decode before implementing this nested folder solution!

  

This vulnerability index is:

[https://www.invicti.com/web-vulnerability-scanner/vulnerabilities/code-execution-via-local-file-inclusion/](https://www.invicti.com/web-vulnerability-scanner/vulnerabilities/code-execution-via-local-file-inclusion/)

---

### Remote code execution (RCE) - PHP Eval

You have a user role then that user role gets looked up to a constant that’s defined by running `eval`  (which runs php scripts including defined constants)

```
<?php   
ini_set('display_errors', '1');  
ini_set('display_startup_errors', '1');  
error_reporting(E_ALL);  
  
define('admin', 'John');  
// echo $_GET["user-role"]; // `?user-role=admin` url would render "admin"  
eval("echo " . $_GET["user-role"] . ";"); // `?user-role=admin` url would render "John" // Recall that eval is for php scripts  
?>
```

The developer assumes that the user will only provide a valid user name as the parameter of a URL:
```
http://www.example.com/index.php?user=admin
```

As a result, the application evaluates the parameter value as code:
```
eval("echo admin;");
```

Which refers to defined constant admin, rendering this:
![[Pasted image 20250509020432.png]]

But hacker could run this url:  
`http://www.example.com/index.php?user=admin;phpinfo();`

![[Pasted image 20250509020451.png]]

The manner of this RCE is dynamic/interactive because the hacker can feed their commands into the URL
- FYI, the other RCE manner is predetermined or hardcoded, usually done through unauthorized upload of a php file then visiting the php file directly.

#### **Solution**
Refactored Code with Input Validation and Sanitization:
```
<?php   
ini_set('display_errors', '1');  
ini_set('display_startup_errors', '1');  
error_reporting(E_ALL);  
  
define('admin', 'John');  
define('guest', 'Guest');  

// Only allow known roles
$validRoles = ['admin', 'guest'];

// Get user role from input
$userRole = $_GET["user-role"] ?? '';

// Sanitize user input to block malicious characters
$userRole = preg_replace('/[;&|`$()]/', '', $userRole);  // Block semicolons, ampersands, pipes, etc.

// Check if the role is valid
if (in_array($userRole, $validRoles)) {
    echo constant($userRole); // Dynamically echo the constant value
} else {
    echo "Invalid role"; // Handle invalid role gracefully
}
?>
```

The fix involves sanitizing user input using the `preg_replace()` function to remove characters that are commonly exploited in injection attacks. The regular expression used removes semicolons (`;`), which could allow multiple commands to execute regardless of the success of the first one, ampersands (`&&`), which chain commands that only execute if the previous one succeeds, pipes (`|`), backticks (`` ` ``) often used for command substitution, and dollar signs (`$`), which could lead to variable injections. After sanitizing the input, the code ensures that the `$userRole` is a valid role by checking it against a predefined list of acceptable values. This prevents unauthorized roles from being processed. If the role is not valid, the code gracefully handles it by outputting "Invalid role", which prevents unexpected behavior or exploitation of the input field. This approach reduces the risk of code injection while maintaining proper functionality.

This vulnerability index is:
[https://www.invicti.com/learn/remote-code-execution-rce/](https://www.invicti.com/learn/remote-code-execution-rce/)

---


### Remote code execution (RCE) - Shell Command

Situation:  

A php webpage uses the URL search parameter to perform grep. It's a website that searches scientific journals for keywords or text words.

A hacker could manipulate the URL search parameter in this context to exploit vulnerabilities in the server-side script. If the PHP page is passing the search parameter directly to a shell command using `shell_exec`, they could inject additional commands.

In PHP, if the URL parameter is not properly sanitized or validated, a malicious user could potentially craft a URL like this:
```
http://example.com/search?query=keyword; rm -rf /
```

In this case, the `;` character (or `&&`) would terminate the initial `grep` command and then chain another command (e.g., `rm -rf /important/data`) that the server would execute. This type of injection is called a **command injection** attack, and it's a serious security risk.

If you're doing something like this in PHP:
```
$query = $_GET['query'];  
$output = shell_exec("grep '$query' /path/to/journals/*.md");
```

  
A malicious user could pass something like:
```
?query=cat'; rm -rf /; echo '
```
  
And it would run as:
```
grep 'cat'; rm -rf /; echo '' /path/to/journals/*.md
```

That would cause a lot of files to disappear off your server.

---

#### Solution 1 - Escape user input

##### Escaping the user input

If you're sticking with `shell_exec`, escape user input:
```
$query = escapeshellarg($_GET['query']);  
$output = shell_exec("grep $query /path/to/journals/*.md");
```

When you use PHP’s escapeshellarg(), it treats semicolons (`;`), double colons (`::`), and other potentially dangerous shell metacharacters as literal characters by escaping them properly — so they cannot terminate the current command or start a new one.  

But even then, be cautious. Consider only allowing alphanumeric inputs:
```
if (!preg_match('/^[\w\s\-]+$/', $_GET['query'])) {  
    die("Invalid input.");  
}
```

#####  **Limit What Files Can Be Accessed (if applicable)**

Hardcode the directory and restrict to `.md` files to prevent access to unintended files.

#### Solution 2 - Avoid shell

Avoid shell by using PHP's equivalent features. Instead of using the linux system's `grep`  that requires shell access, PHP has a combination of glob, file_get_contents, and stripos

```
$search = $_GET['query'];  
$notes = glob('/path/to/journals/*.md');  
$matches = [];  
  
foreach ($notes as $file) {  
    $contents = file_get_contents($file);  
    if (stripos($contents, $search) !== false) {  
        $matches[$file] = $contents;  
    }  
}
```

  
No shell used, no injection risk.

#### Solution 3 - proc_open

✅ `proc_open()`  

- **Purpose**: Gives **fine-grained control** over running shell commands (like `grep`).
- **Safer** than `shell_exec()` when used properly — lets you separate stdin, stdout, and stderr.
- **Use it when**: You want more secure and flexible shell execution (e.g., avoid the shell altogether).

**Example:**
```
$cmd = ['grep', $_GET['query'], '/journals/*.md'];  // Don't use raw strings  
$descriptors = [  
    1 => ['pipe', 'w'], // stdout  
    2 => ['pipe', 'w'], // stderr  
];  
$process = proc_open($cmd, $descriptors, $pipes);  
$output = stream_get_contents($pipes[1]);  
fclose($pipes[1]);  
proc_close($process);
```

Vulnerability index: Command Injection vulnerability
[https://www.invicti.com/web-vulnerability-scanner/vulnerabilities/command-injection/](https://www.invicti.com/web-vulnerability-scanner/vulnerabilities/command-injection/)