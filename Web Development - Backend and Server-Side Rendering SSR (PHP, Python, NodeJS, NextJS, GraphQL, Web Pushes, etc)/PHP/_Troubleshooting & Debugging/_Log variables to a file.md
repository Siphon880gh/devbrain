
Here’s how you can manually log variables using a custom function, along with how to use PHP’s built-in error logging:

### Creating a Custom Log Function
You can define a function like `log_misc()` to handle custom logging. Here’s a simple implementation that writes to a log file:

```php
function log_misc($data) {
    $logFile = __DIR__ . '/custom-log.log';  // Specify the log file
    $logMessage = date('Y-m-d H:i:s') . ' - ' . print_r($data, true);  // Format the log message
    file_put_contents($logFile, $logMessage . PHP_EOL, FILE_APPEND);
}

// Example usage
log_misc(["req method" => $_SERVER['REQUEST_METHOD']]);
```

This function takes an array of data, formats it with a timestamp, and appends it to a log file. `print_r($data, true)` is used to convert the array to a human-readable string. The `FILE_APPEND` flag ensures that new log entries are appended to the file rather than overwriting it.

### Using PHP Built-in Error Logging
Alternatively, you can use PHP’s built-in `error_log()` function to log custom messages. Here's how you could adapt your example to use this function:

```php
$message = "Request Method: " . $_SERVER['REQUEST_METHOD'];
error_log($message, 3, __DIR__ . '/error-log.log');
```

In this usage:
- The second parameter `3` tells `error_log()` to write the message to a file.
- The third parameter is the path to the log file.

Both methods will allow you to log the request method or any other variable you need to track in your application. Adjust according to your specific logging needs and environment configuration.