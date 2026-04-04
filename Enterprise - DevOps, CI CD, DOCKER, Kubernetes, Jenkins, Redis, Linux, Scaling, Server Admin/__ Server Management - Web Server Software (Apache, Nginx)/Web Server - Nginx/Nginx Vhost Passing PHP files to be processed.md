
If you dont have php setup correctly, opening a php file may get the php file downloaded instead of viewed on the webpage. This is because the server didn't send the php file to process it into html and/or run server scripts

This is a partial vhost where it matters. Note the variables `{{...}}` are expanded by CloudPanel
```
server {
  listen 80;
  listen [::]:80;
  listen 443 ssl http2;
  listen [::]:443 ssl http2;
  {{ssl_certificate_key}}
  {{ssl_certificate}}
  server_name www.wengindustries.com;
  return 301 https://wengindustries.com$request_uri;
}

server {
  listen 80;
  listen [::]:80;
  listen 443 ssl http2;
  listen [::]:443 ssl http2;
  {{ssl_certificate_key}}
  {{ssl_certificate}}
  server_name wengindustries.com www1.wengindustries.com
  {{root}}

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
    
    # Old Portfolio "me" - Handle static files first
    location ~* ^/me/(.+)\.(css|js|png|jpg|jpeg|gif|ico|pdf|svg|woff|woff2|ttf|eot)$ {
        # root /me/dist/assets; # Adjust the path to your static file directory
        expires max;
        log_not_found off;
    }
    
    location ~ ^/me/php-react-mixin/(.*) {
        fastcgi_intercept_errors on;
        proxy_intercept_errors on; 
        
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
    
    # Old Portfolio "me" - Redirect /me/<something>
    location ~ ^/me/(.+)$ {
        return 301 /me/?page=$1;
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
}


server {
  listen 8080;
  listen [::]:8080;
  server_name wengindustries.com www1.wengindustries.com
  {{root}}
  
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

server {
  listen 8080;
  listen [::]:8080;
  server_name wengindustries.com www1.wengindustries.com wengindustry.com www1.wengindustry.com;
  {{root}}
  
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


**Key point 1:**
This part because Nginx look for location blocks by specificity, gets hit
```
    location ~ ^/me/php-react-mixin/(.*) {
```

Then this part which could mess up /me/php-react-mixin/ doesn't get hit:
```
    # Old Portfolio "me" - Redirect /me/<something>
    location ~ ^/me/(.+)$ {
        return 301 /me/?page=$1;
    }
```


**Key point 2:**
It passes the internet request to port 8080 handling php scripts (numbers 8080 doesn't actually show in the text):
```
    
    location ~ ^/me/php-react-mixin/(.*) {
        fastcgi_intercept_errors on;
        proxy_intercept_errors on; 
        
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
    
```

**Key point 3:**
Then the server block for port :8080 handles the php file:
```

server {
  listen 8080;
  listen [::]:8080;
  server_name wengindustries.com www1.wengindustries.com wengindustry.com www1.wengindustry.com;
  {{root}}
  
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