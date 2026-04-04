At your 80/443 server block:

Define the custom 404 location block first. It sets the root that your custom 404 html file is at:
```
    location /custom404.html {
        root /home/wengindustries/htdocs/wengindustries.com;
        internal; # Prevent direct access to custom404.html
    }
```

Then in your `/` location block afterwards (if fastcgi php applicable, and if not you can skip that line):
```
  location / {
 
    fastcgi_intercept_errors on;
    proxy_intercept_errors on; 
    try_files $uri $uri/ =404;
    # ...
```

Then after the `/` location block, as a sibling to location blocks (NOT inside a location block):
```
    error_page 404 500 /custom404.html;
```

---

So in summary it might be:
```

    # Custom 404, / to 404, and error_page defined
    location /custom404.html {
        root /home/wengindustries/htdocs/wengindustries.com;
        internal; # Prevent direct access to custom404.html
    }

    location / {
    
        fastcgi_intercept_errors on;
        proxy_intercept_errors on; 
        try_files $uri $uri/ =404;
        
        {{varnish_proxy_pass}}
        proxy_set_header Host $http_host;
        proxy_set_header X-Forwarded-Host $http_host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_hide_header X-Varnish;
        proxy_redirect off;
        proxy_max_temp_file_size 0;
        proxy_connect_timeout      720;
        proxy_send_timeout         720;
        proxy_read_timeout         720;
        proxy_buffer_size          128k;
        proxy_buffers              4 256k;
        proxy_busy_buffers_size    256k;
        proxy_temp_file_write_size 256k;
    }

    error_page 404 500 /custom404.html;
```

---

Dont forget you need to refresh the vhost settings for them to apply:
```
systemctl reload nginx
```