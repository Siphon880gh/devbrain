You want api paths like `/api/songs/1` to work.

Here's the code to add to your server block that listens for 80 and 443. Add it after root pathing:

```
# ========= appName API (HTTPS) =========
# 1) Route any /abc/appName/api/* to the front controller
location ^~ /abc/appName/api/ {
    # Serve real files if they exist; otherwise hit index.php (method+body preserved)
    try_files $uri $uri/ /abc/appName/api/index.php$is_args$args;
}

# 2) Make absolutely sure index.php is executed by PHP-FPM
# Exact match beats regex ordering issues
location = /abc/appName/api/index.php {
    include fastcgi_params;
    # USE ABSOLUTE PATH to avoid root/alias confusion
    fastcgi_param SCRIPT_FILENAME /home/wengindustries/htdocs/wengindustries.com/abc/appName/api/index.php;
    fastcgi_param QUERY_STRING    $query_string;

    # CloudPanel PHP-FPM backend
    fastcgi_pass 127.0.0.1:{{php_fpm_port}};
    fastcgi_read_timeout 300;
}
```

