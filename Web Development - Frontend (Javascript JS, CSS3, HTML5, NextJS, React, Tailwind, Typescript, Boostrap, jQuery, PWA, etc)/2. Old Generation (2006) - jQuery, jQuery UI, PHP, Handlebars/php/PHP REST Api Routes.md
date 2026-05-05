
Certainly! Ensuring security in your PHP code when handling user input and database interactions is crucial. Here is how you can improve the `api.php` script to include input validation, use prepared statements to prevent SQL injection, and use `password_hash()` and `password_verify()` for secure password handling.

For the `signup` endpoint, you'd hash the password before storing it in the database. For the `login` endpoint, you'd retrieve the stored password hash from the database and verify it against the provided password.

```php
<?php

// Load .env file
$env = parse_ini_file('.env');

// Database configuration
$dbHost = $env['DB_HOST'];
$dbUser = $env['DB_USER'];
$dbPass = $env['DB_PASS'];
$dbName = $env['DB_NAME'];

// Check for necessary PHP server support
if (!function_exists('mysqli_connect')) {
    die('PHP MySQL Support not available.');
}

// Database connection
$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

$mysqli->set_charset("utf8mb4"); // Set charset to handle UTF-8 characters properly

// Check request method
$method = $_SERVER['REQUEST_METHOD'];

header('Content-Type: application/json');

// Helper function to send JSON responses
function sendJSON($status, $data) {
    http_response_code($status);
    echo json_encode($data);
    exit;
}

// Route the request
if (isset($_GET['endpoint'])) {
    switch ($_GET['endpoint']) {
        case 'api/users/signup':
            if ($method == 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['username'], $data['password'])) {
                    // Validate input
                    $username = filter_var($data['username'], FILTER_SANITIZE_STRING);
                    $password = password_hash($data['password'], PASSWORD_DEFAULT); // Hash password

                    // Prepare and execute INSERT statement
                    $stmt = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                    $stmt->bind_param("ss", $username, $password);
                    if ($stmt->execute()) {
                        sendJSON(201, ["message" => "User created"]);
                    } else {
                        sendJSON(500, ["message" => "User could not be created"]);
                    }
                    $stmt->close();
                } else {
                    sendJSON(400, ["message" => "Invalid data provided"]);
                }
            }
            break;

        case 'api/users/login':
            if ($method == 'POST') {
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['username'], $data['password'])) {
                    // Validate input
                    $username = filter_var($data['username'], FILTER_SANITIZE_STRING);

                    // Prepare and execute SELECT statement
                    $stmt = $mysqli->prepare("SELECT password FROM users WHERE username = ?");
                    $stmt->bind_param("s", $username);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($user = $result->fetch_assoc()) {
                        if (password_verify($data['password'], $user['password'])) {
                            sendJSON(200, ["message" => "Login successful"]);
                        } else {
                            sendJSON(401, ["message" => "Login failed"]);
                        }
                    } else {
                        sendJSON(404, ["message" => "User not found"]);
                    }
                    $stmt->close();
                } else {
                    sendJSON(400, ["message" => "Invalid data provided"]);
                }
            }
            break;

        default:
            sendJSON(404, ["message" => "Endpoint not found"]);
            break;
    }
} else {
    sendJSON(400, ["message" => "No endpoint specified"]);
}

$mysqli->close();
```

Remember to replace the `INSERT INTO users` and `SELECT password FROM users` statements with the actual table and columns names from your database. This script assumes you have a table called `users` with at least two columns: `username` and `password`.

In the real world, you should also add additional security measures such as:

- Rate limiting to prevent brute-force attacks.
- HTTPS to secure data in transit.
- CSRF protection.
- Possibly implementing two-factor authentication.


---

Dont forget the env file and htaccess to make /api/... paths work:

Below, you'll find an example of a simple `api.php` file that connects to a MySQL database named `storyway_db`, reads credentials from an `.env` file, and handles the specified endpoints with GET, POST, PUT, and DELETE requests.

Remember to have a `.env` file in the root directory of your project with your database credentials set like this:

```
DB_HOST=localhost
DB_USER=username
DB_PASS=password
DB_NAME=your_db
```


^ In this file, replace `username` and `password` in the `.env` example with your actual database user credentials. Also, note that in a production environment, you would need to handle security concerns such as input validation, prepared statements to prevent SQL injection, and using `password_hash()` and `password_verify()` for password storage and validation.


Regarding your `.htaccess` file to rewrite URLs, you would use the Apache mod_rewrite module. Here's a basic `.htaccess` file example that would accomplish this:

```
RewriteEngine On

# Check if mod_rewrite is enabled
<IfModule mod_rewrite.c>
    # Rewrite the /api/... to the api.php with the query string
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^api/(.*)$ api.php?endpoint=$1 [QSA,L]
</IfModule>
```

Place this `.htaccess` file in your root directory. Make sure that the Apache mod_rewrite module is enabled on your server, and the AllowOverride directive is set correctly to allow `.htaccess` files to be used.

Remember that `.htaccess` files and URL rewriting like this are specific to Apache web servers. If you're using a different web server (like Nginx), the approach would be different.