
PHP Google Sheet API not working but error is too vague or non-existent? Enable PHP logging to page:
```
ini_set('log_errors', 1);    
error_reporting(E_ALL);    
session_start();  
  
// Set error logging to page  
ini_set('display_errors', 1); // displays errors on page
```