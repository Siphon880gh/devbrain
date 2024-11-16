Say your vhost has:
```
location / {  
  try_files $uri $uri/ /index.php?$args;  
  # ...
```

Visiting
https://wengindustries.com/345345/
Redirects constantly like this:
https://wengindustries.com/345345/me/
https://wengindustries.com/345345/me/me/
https://wengindustries.com/345345/me/me/me/
...

And that’s if you have an `index.php`  at the root that redirects like this:
```
<meta http-equiv="refresh" content="0; me/">
```
^ Which was originally intended as a quick and dirty way to open up me/ without touching vhost.

It makes sense it kept redirecting and kept amending to the path each time at the address bar, because each time it redirects to the new url, it’s not found, then the try_files try each path hitting `$uri` , `$uri/` ,... until it hits the found page `/index.php?$args` which IS found from the document root `/` but then that index.php redirects to `me/`  which is not found from the url path.