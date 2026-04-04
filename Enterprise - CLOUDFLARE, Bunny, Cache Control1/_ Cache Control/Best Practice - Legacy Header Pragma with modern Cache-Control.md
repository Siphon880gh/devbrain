Keep Pragma and Cache-Control headers consistent (both the same options)
- You should and if you do include both modern Cache-Control headers and legacy Pragma headers, older browsers might prioritize Pragma
- So make sure Pragma headers match the more modern Cache-control header
- Otherwise could could cause unexpected consequences when an older browser prefers Pragma that have a different caching header. You usually don't want different caching strategy based on how old a browser is

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

## Keep Cache-Control and Pragma Consistent

Note the **`Pragma`** HTTP header does not have a `no-store` directive. The `Pragma` header was introduced in HTTP/1.0 and is mainly used for backward compatibility. It supports only a single directive: `no-cache`. Meanwhile, Cache-Control has `no-store` and `no-cache`. 
- In cache-control, `no-store` is a harder restriction on cache, compared to its `no-cache`, making the distinction that `no-store` is absolutely DO NOT store cache, and `no-cache` is use the cache stored locally for performance but do refetch if there's a newer copy on the server.
- Pragma no-cache and Cache-control no-store are equivalent settings because their strategy is the same.

No caching by PHP:
```
<?php
header("Cache-Control: no-store, must-revalidate");
header("Pragma: no-cache"); // For HTTP/1.0 backward compatibility
header("Expires: 0"); // Forces expiration immediately
?>
```

No caching by Nginx Vhost:
```
server {
    location /no-cache {
        add_header Cache-Control "no-store, must-revalidate";
        add_header Pragma "no-cache"; # For HTTP/1.0 compatibility
        expires off; # Disable expiration
    }
}
```

---

For other cache strategy settings, refer to [[Cache-Control Cache Strategies - PRIMER]]