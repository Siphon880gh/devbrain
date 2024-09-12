Is this the error from PHP logging?
```
Fatal error: Uncaught Google\Service\Exception: { "error": { "code": 400, "message": "This operation is not supported for this document", "errors": [ { "message": "This operation is not supported for this document", "domain": "global", "reason": "failedPrecondition" } ], "status": "FAILED_PRECONDITION" } } in /home/apache_user/public_html/tools/data-modeling/gsheet-test/vendor/google/apiclient/src/Http/REST.php:134 Stack trace: #0 /home/apache_user/public_html/tools/data-modeling/gsheet-test/vendor/google/apiclient/src/Http/REST.php(107): Google\Http\REST::decodeHttpResponse(Object(GuzzleHttp\Psr7\Response), Object(GuzzleHttp\Psr7\Request), 'Google\\Service\\...') #1 [internal function]: Google\Http\REST::doExecute(Object(GuzzleHttp\Client), Object(GuzzleHttp\Psr7\Request), 'Google\\Service\\...') #2 /home/apache_user/public_html/tools/data-modeling/gsheet-test/vendor/google/apiclient/src/Task/Runner.php(187): call_user_func_array(Array, Array) #3 /home/apache_user/publ in /home/apache_user/public_html/tools/data-modeling/gsheet-test/vendor/google/apiclient/src/Http/REST.php on line 134

```
  

This is not a very vague error actually. If the above troubleshooting fails, make sure the file is a Google Sheet and NOT a .xlsx

Refer to [[Google Sheet API - _PRIMER]] for instructions on checking it's a Google Sheet and not a .xlsx.