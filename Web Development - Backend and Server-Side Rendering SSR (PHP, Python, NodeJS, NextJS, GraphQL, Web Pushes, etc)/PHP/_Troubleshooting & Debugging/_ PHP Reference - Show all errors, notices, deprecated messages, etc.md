```
error_reporting(E_ALL);  
ini_set('display_errors', 1);
```

On Nginx?
500 error page in the way of you seeing the php errors? Not really. if you have set PHP errors to not show, nginx will redirect to the page indicated in `error_page 500` at the vhost. Enable all errors like above, so the redirect to error_page doesn't happen and you can read the errors.