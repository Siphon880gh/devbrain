Follow these examples to learn the key value syntax. There are many possible headers. For our tutorial, we focus on Pragma and Cache-Control

---
## Pragma

Note: Pragma is for older web browsers, however it's suggested you use Pragma and apply the same settings with the more conventional Cache-Control header. The reasons why are listed at [[Best Practice - Legacy Header Pragma with modern Cache-Control]]

Below discusses the key value format of Pragma, where to configure Pragma, and how to verify the settings applied.

You can either configure at the nginx vhost level or the php level. With PHP, it effectively overrides or amends the default headers setup at the web server level (eg. Nginx vhost). This is because the PHP will be the final point before serving the file from the server machine to over the internet.

Nginx vhost at some location block
```
add_header Pragma "no-store";
```

PHP overriding or amending would be:
```
header("Pragma: no-store");
```

If looking into DevTools, it corresponds to Response header's Pragma:
DevTools → Network → Headers at the file
![](FY2H802.png)

---

## Cache-Control (Multiple values) with Pragma

No caching by PHP:
```
<?php
header("Cache-Control: no-store, must-revalidate");
header("Pragma: no-cache"); // For HTTP/1.0 backward compatibility
header("Expires: 0"); // Forces expiration immediately
?>
```

Nginx Vhost:
```
server {
    location /no-cache {
        add_header Cache-Control "no-store, must-revalidate";
        add_header Pragma "no-cache"; # For HTTP/1.0 compatibility
        expires off; # Disable expiration
    }
}
```