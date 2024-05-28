

As practical snippets

```
// Set error logging  
ini_set('log_errors', 1);  
error_reporting(E_ALL);

// Set error logging to page
ini_set('display_errors', 1); // displays errors on page


// Function to prepend data to log  
function log_misc($data) {  
    global $logFilePath;  
  
    // Convert array or object to a readable string  
    if (is_array($data) || is_object($data)) {  
        $data = print_r($data, true);  
    }  
  
    // Ensure $data ends with a newline for better readability in the log  
    $data = trim($data) . "\n";  
  
    // Get the existing contents of the file  
    $existingData = file_get_contents($logFilePath);  
  
    // Combine the new data with the existing data  
    $newData = $data . $existingData;  
  
    // Write the combined data back to the file  
    file_put_contents($logFilePath, $newData);  
} // log_misc
```


---


If you want to log to a file, replace "Set error logging to page" section to:
```
// Set error logging to page
ini_set('display_errors', 0); // displays errors on page
ini_set('error_log', '/path/to/your-development-error-log.log');
```



Using relative path:
```php
ini_set('error_log', 'error-log.log');
```

Using absolute path:
```php
ini_set('error_log', __DIR__ . '/error-log.log');
```



---

