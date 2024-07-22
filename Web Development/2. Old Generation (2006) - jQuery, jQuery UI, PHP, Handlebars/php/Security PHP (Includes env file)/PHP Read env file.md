
The php file:
```php
<?php

// Load .env file
$env = parse_ini_file('.env');

// Database configuration
$dbHost = $env['DB_HOST'];
$dbUser = $env['DB_USER'];
$dbPass = $env['DB_PASS'];
$dbName = $env['DB_NAME'];


// ...
```



The .env file:
```
DB_HOST=localhost
DB_USER=username
DB_PASS=password
DB_NAME=your_db
```