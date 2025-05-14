
See this location block:
```
  # Caching Static Assets  
  location ~* ^.+\.(css|js|jpg|jpeg|gif|png|ico|gz|svg|svgz|ttf|otf|woff|woff2|eot|mp4|ogg|ogv|webm|webp|zip|swf|map|mjs)$ {  
    add_header Access-Control-Allow-Origin "*";  
    add_header alt-svc 'h3=":443"; ma=86400'; # Notified of http3 support for the next 24h  
    access_log off;  
      
    add_header Cache-Control "no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0";  
    expires 0;  
  
    # For swiching back to sticky cache  
    # add_header Cache-Control "public, max-age=31536000, immutable";  
    # expires max; # `Nexpires max` or `expires 1y`  
  }
```

Depending on if you want sticky cache for performance or cache busting for developing and deploying, comment on/off between:
```
    add_header Cache-Control "no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0";  
    expires 0;  
```

_and_

```
    # For swiching back to sticky cache  
    # add_header Cache-Control "public, max-age=31536000, immutable";  
    # expires max; # `Nexpires max` or `expires 1y`  
```
