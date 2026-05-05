Let's say you have domain1.com that serves files from app1/ and domain2.com that serves files from app2/. Both app1/ and app2/ are descendants of /home/someUser/ You want PHP capability just in case.

Your two domains (or two apps) have the absolute paths similar to:

/home/wengindustries/htdocs/wengindustries.com/apps/app1 for domain1.com

/home/wengindustries/htdocs/wengindustries.com/apps/app2 for domain2.com

^Note both apps are under same user folder path for user wengindustries

Remember that in nginx which cloudpanel uses, your vhost have server blocks that match by domain names (aka server_name). When someone visits a url on the web browser, the DNS resolves by connecting to the webhost IP address. Connecting to your webhost, your nginx checks the server_name that the internet request header described. The server_name matches at the subdomain name too, so www.domain1.com and domain1.com are different server_name’s

You may want to catch a www at the server block and  then on success, redirect it to a non-www server block. Then that server block proceeds to set the document root (which is important for your app absolute path) and it allows for PHP by passing PHP requests to the server block :8080 which must also match your server_name. Therefore:

```
server {
  listen 80;
  listen [::]:80;
  listen 443 ssl http2;
  listen [::]:443 ssl http2;
  {{ssl_certificate_key}}
  {{ssl_certificate}}
  server_name www.therunner.app;
  return 301 https://therunner.app$request_uri;
}

server {
  listen 80;
  listen [::]:80;
  listen 443 ssl http2;
  listen [::]:443 ssl http2;
  {{ssl_certificate_key}}
  {{ssl_certificate}}
  server_name therunner.app www1.therunner.app;
  # {{root}}
  root /home/wengindustries/htdocs/wengindustries.com/app/run-app;

  {{nginx_access_log}}
  {{nginx_error_log}}

  if ($scheme != "https") {
    rewrite ^ https://$host$uri permanent;
  }

  location ~ /.well-known {
    auth_basic off;
    allow all;
  }
    
    {{settings}}
    
    
    # Custom 404, / to 404, and error_page defined
    location /404.html {
        root /home/wengindustries/htdocs/wengindustries.com;
        internal; # Prevent direct access to 404.html
    }

    location / {
        fastcgi_intercept_errors on;
        proxy_intercept_errors on; 
        # try_files $uri $uri/ =404;
        
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


    error_page 404 /404.html;
    error_page 500 /500.html;
    

  location ~* ^.+\.(css|js|jpg|jpeg|gif|png|ico|gz|svg|svgz|ttf|otf|woff|woff2|eot|mp4|ogg|ogv|webm|webp|zip|swf|map|mjs)$ {
    add_header Access-Control-Allow-Origin "*";
    expires 0;
    access_log off;
  }

  location ~ /\.(ht|svn|git) {
    deny all;
  }

  if (-f $request_filename) {
    break;
  }
}


server {
  listen 8080;
  listen [::]:8080;
  server_name therunner.app www1.therunner.app;
  # {{root}}
  root /home/wengindustries/htdocs/wengindustries.com/app/run-app;
  
  client_max_body_size 512M;


  location ~ \.php(.*)$ {
    include fastcgi_params;
    fastcgi_intercept_errors on;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name$1;
    try_files $uri =404;
    fastcgi_read_timeout 3600;
    fastcgi_send_timeout 3600;
    fastcgi_param HTTPS "on";
    fastcgi_param SERVER_PORT 443;
    fastcgi_pass 127.0.0.1:{{php_fpm_port}};
    fastcgi_param PHP_VALUE "{{php_settings}}";
  }

  try_files $uri $uri/ /index.php?$args;
  index index.php index.html;
  
  if (-f $request_filename) {
    break;
  }
}
```

You would have this for each domain (all three blocks), so it may be more manageable long term to have `include`  directives