
You are entering a password and that password will open whatever filename is spelled by that password. It should leave a lot of vulnerabilities to consider. This code covers the vulnerabilities.

### hints/index.php
Receives the password entered by the user then tries to open a file with that password as the filename. Secured against some vulnerabilities.
```
<?php
header('Content-Type: text/plain');

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Access Denied');
}

// Get and sanitize the password
$password = isset($_POST['password']) ? $_POST['password'] : '';
$password = urldecode($password);

// Recursively decode URL encoding
while (urldecode($password) !== $password) {
    $password = urldecode($password);
}

// Get only the basename to prevent directory traversal
$password = basename($password);

// Construct the filename
$filename = $password . '.html';

// Check if file exists in the hints directory
$filepath = __DIR__ . '/' . $filename;
if (file_exists($filepath)) {
    echo $filename;
} else {
    http_response_code(404);
    echo '';
}
?> 
```

### hints/{PASSWORD}.html
This is the file that opens if there's a match on the entered password and the filename. The password user enters does not include ".html". A HTML file makes sense to easily format the password hint guide. You can have as many password files as needed.
