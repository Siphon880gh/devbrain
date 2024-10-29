
```
<?php  
// Test if the exec function is available and enabled  
if (function_exists('exec')) {  
    echo "exec is available on the server.\n";  
  
    // Disable the time limit for this script  
    set_time_limit(2);  
  
    // Capture the output of the whoami command  
    $output = [];  
    exec('whoami', $output, $return_var);  
  
    // Check if the command was executed successfully  
    if ($return_var === 0) {  
        echo "The exec function is enabled, and the server is running as: " . implode("\n", $output);  
    } else {  
        echo "The exec function is disabled or restricted.";  
    }  
  
    echo "  ";  
  
    // Capture the output of the python3 --version command  
    $output = [];  
    exec('python3 --version', $output, $return_var);  
  
    // Check if the command was executed successfully  
    if ($return_var === 0) {  
        echo "Python3 is installed, and its version is: " . implode("\n", $output);  
    } else {  
        echo "Failed to execute python3 --version or Python3 is not installed.";  
    }  
} else {  
    echo "exec is not available on the server.";  
}  
?>
```