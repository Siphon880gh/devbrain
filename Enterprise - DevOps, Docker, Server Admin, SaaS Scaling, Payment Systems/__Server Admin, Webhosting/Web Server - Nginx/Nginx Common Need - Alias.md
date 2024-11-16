
If you want to change the folder that serves the php/html webpage and its src/link asset files (css, js, etc), and you want to do it through alias instead of rewrite (so you can even go below the document root and also you don't need to parse for internal routes in PHP), this is the tutorial for you with alias. For a comparison of alias vs rewrite, refer to [[Nginx Fundamental - Redirect vs Rewrite vs Alias]]

Let's say:

The public goes to `domain.tld/app/app1`
- The index file loads from folder path `app.test/app1`

Your Vhost would be:
```
    {{settings}}
    # Redirect requests without a trailing slash to include one  
    location ~ ^/app/([^/]+)$ {  
        return 301 $scheme://$host$uri/;  
    }  
  
    # Serve main app1 page, mapped to /app.test/app1/  
     location /app/app1/ {  
         alias /home/wengindustries/htdocs/wengindustries.com/app.test/app1/;  
         index index.html;  
        try_files $uri $uri/ /index.html?$args;  
    }  
  
    # Serve static files correctly  
    location ~* ^/app/app1/(.+\.(css|js|js.map|json|jpg|jpeg|png|gif|ico|svg|woff|woff2|ttf|eot|otf))$ {  
        alias /home/wengindustries/htdocs/wengindustries.com/app.test/app1/$1;  
        access_log off;  
        expires max;  
        add_header Cache-Control "public";  
    }  
  
     # Process PHP files under /app/app1/  
     location ~ ^/app/app1/(.*\.php)$ {  
        alias /home/wengindustries/htdocs/wengindustries.com/app.test/app1/$1;  
        fastcgi_pass 127.0.0.1:9000;  # Adjust to your PHP-FPM socket or port  
        fastcgi_index index.php;  
        include fastcgi_params;  
        fastcgi_param SCRIPT_FILENAME /home/wengindustries/htdocs/wengindustries.com/app.test/app1/$1;  
    }
```

You'll have to reload nginx for the new vhost to apply:
```
systemctl reload nginx
```

---

Now let's say it's a bit more dynamic

The public goes to `domain.tld/app/app1`
- The index file loads from folder path `app.test/app1`
The public goes to `domain.tld/app/app2`
- The index file loads from folder path `app.test/app2
The public goes to `domain.tld/app/whatever`
- The index file loads from folder path `app.test/whatever

Your Vhost would be:
```
    {{settings}}
    # Redirect requests without a trailing slash to include one  
    location ~ ^/app/([^/]+)$ {  
        return 301 $scheme://$host$uri/;  
    }  

    location /app/
    {                                                     
        alias /home/wengindustries/htdocs/wengindustries.com/app.test/$1;
    }

    # Serve static files correctly
    location ~* ^/app/([^/]+)/(.+\.(css|js|js.map|json|jpg|jpeg|png|gif|ico|svg|woff|woff2|ttf|eot|otf))$ {
        alias /home/wengindustries/htdocs/wengindustries.com/app.test/$1/$2;
        access_log off;
        expires max;
        add_header Cache-Control "public";
    }

    # Process PHP files under any folder in /app/
    location ~ ^/app/([^/]+)/(.*\.php)$ {
        alias /home/wengindustries/htdocs/wengindustries.com/app.test/$1/$2;
        fastcgi_pass 127.0.0.1:9000;  # Adjust to your PHP-FPM socket or port
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME /home/wengindustries/htdocs/wengindustries.com/app.test/$1/$2;
    }
```

You'll have to reload nginx for the new vhost to apply:
```
systemctl reload nginx
```
