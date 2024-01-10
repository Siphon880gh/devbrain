

As practical snippets

```
// Set error logging  
$logFilePath = 'php_errors.log'; // The path to your log file  
ini_set('log_errors', 1);  
error_reporting(E_ALL);  
ini_set('error_log', $logFilePath);  
  
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

You can manually test variables:

```
log_misc(["req method"=>$_SERVER['REQUEST_METHOD']]);
```
