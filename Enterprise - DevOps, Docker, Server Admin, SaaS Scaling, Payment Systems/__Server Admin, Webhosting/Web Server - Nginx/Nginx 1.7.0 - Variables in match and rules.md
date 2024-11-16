Nginx version **1.7.0** or higher has variables like (in this example `app/**`  public url serves files from `app.test/**` ):
```
# Process PHP files under /app/<appname>/  
location ~ ^/app/(?<appname>[^/]+)/(?<phpfile>.*\.php)$ {  
    alias /home/wengindustries/htdocs/wengindustries.com/app.test/$appname/$phpfile;  
  
    fastcgi_pass 127.0.0.1:9000;  # Adjust to your PHP-FPM socket or port  
    fastcgi_index index.php;  
    include fastcgi_params;  
    fastcgi_param SCRIPT_FILENAME /home/wengindustries/htdocs/wengindustries.com/app.test/$appname/$phpfile;  
}
```


`sudo nginx -v`  to get version of your nginx

Note CloudPanel as of 11/2024 uses an older nginx 1.21.4
