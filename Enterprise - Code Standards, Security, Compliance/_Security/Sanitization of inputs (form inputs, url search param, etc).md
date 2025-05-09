
Sanitation in security refers to the process of cleaning and validating user input to prevent malicious data from compromising an application. Proper sanitation helps defend against threats like Cross-Site Scripting (XSS) and SQL injection by neutralizing potentially harmful input before it can be executed.

This includes removing or escaping special characters—such as single quotes (') and double quotes ("), which can prematurely end HTML attributes or manipulate SQL queries—and ensuring input isn’t encoded or double-encoded to bypass filters. 

Another important sanitation method is stripping html tags. In PHP that could be htmlspecialchars (or htmlentities) or strip_tags.

Note that for htmlspecialchars: htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); , the ENT_QUOTES flag doesn't mean to just convert quotes. The ENT_QUOTES  flag ensures both double (") and single (') quotes are converted, otherwise only double quotes will be converted.

If URLs are involved, hackers may try to bypass your validations by encoding or even double encoding. For example, the usual XSS via the URL could contain `<script>alert('XSS')</script>` but the encoded url could be: `%3Cscript%3Ealert%28%27XSS%27%29%3C%2Fscript%3E`. Hackers can and do use double encoding (or even triple, etc.) to further obfuscate malicious payloads and bypass weak input filters or poorly implemented sanitization. Double encoding: `%253Cscript%253Ealert%2528%2527XSS%2527%2529%253C%252Fscript%253E` (Here, % becomes %25, so %3C becomes %253C, etc.). What to do?

You'll have to recursively decode until the value stops changing, like:
```
function recursiveUrldecode($input) {  
    $prev = '';  
    $current = $input;  
  
    // Decode until the input stops changing  
    while ($current !== $prev) {  
        $prev = $current;  
        $current = urldecode($current);  
    }  
  
    return $current;  
}
```

If the hacker will likely to try shell injection, these could be common characters you want to match and remove (only after recursively decoding):
- Semicolons (`;`) - Multiple shell commands that run regardless if previous command passes
- Ampersands (`&&`) - Multiple shell commands that only runs if previous command runs
- Pipes (`|`)
- Backticks (`` ` ``)
- Dollar signs (`$`) (often used in variable injection)

^ PHP has the function `preg_replace()`

Sometimes limiting the number of characters or file size may make sense especially when you know the typical use does not exceed a certain size (beyond it, likely the hacker is attempting to inject something malicious and powerful)

You have to sanitize both frontend and backend because hackers could manually send the request to the backend endpoint. Even if your backend is supported by a jsonwebtoken, the hacker can be a registered user and sniff out that token from DevTools or it could have been a leaked token.