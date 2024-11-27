Titled: Include external vhost conf file to manage multiple server blocks (domains) inside the vhost of the same domain

Purpose:
You have multiple domain names like domain1.com, domain2.ai, domain3.wiki, etc and they each have files at the same web host. Some may have different document root. You want the domain url to stick rather than redirect to another url. Instead of modifying the vhost at your website, you should have that vhost refer (using the include directive) to another vhost conf file that deals exclusively with domain addresses (via the server blocks. This makes sure the website's vhost is clean and you can manage the domains at another file. 

You could have a folder like eco/ that deals with these referred/included vhost files, and other files related to managing global affairs of your server (pm2 ecosystem.config.js, supervisor/ folder containing symbolic links to supervisor main config file and supervisor app config files). FYI, pm2 ecosystem.config.js is to manage multiple NodeJS Express apps at different 300X ports; supervisor used to run .sh files which runs gunicorn shell commands which can scale Python Flask apps at different 500X ports.

---


Using multiple `include` directives inside the same Cloudpanel site’s vhost is a lot easier to manage different domains that serve different website folders under the same ancestral folder. 

Can skip - RATIONALE: Let’s say you DO NOT use include, then here are your options which are not recommended:

- Each new Cloudpanel site you create will have Cloudpanel create a different user in Linux `/home/`  (therefore you have `/home/user1/domain1`, `/home/user2/domain2` , etc and it becomes a hassle when you migrate web hosting providers!).  When migrating to a different web host provider, you want all website folders to be copied over easily by copying only one folder (`/home/user/`)
- if you had take a hybrid approach of continue creating new Cloudpanel sites which makes it easy to see at a glance all the different domains on your Cloudpanel Sites list, but all the site users will point to only one main user’s folder. But you’d have a complicated workflow everytime you add a new domain, because for each new CloudPanel site, CloudPanel creates a new user under Linux, and you’d need to grant the user permission to access across user folders from `SOME_USER1`  or `SOME_USER2`  to : `home/SAME_MAIN_USER/domain1`, `home/SAME_MAIN_USER/domain2` , etc

- You have to add the new Cloudpanel site’s user to the main user’s group (`SAME_USER`), and make sure the group permissions are x and r and are owned by that main user’s group. But you also have to adjust the php interpreter settings to the correct user and group. That php interpreter settings is unique to each Cloudpanel site.

For the discussed reasons above, you want to have `include`  directives at the root level of your website’s vhost that will contain the folders to your other websites / domains. Each include can be to a conf file named after the domain.

Let’s say without include, the vhost is long:

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
    expires max;
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
  listen 80;
  listen [::]:80;
  listen 443 ssl http2;
  listen [::]:443 ssl http2;
  {{ssl_certificate_key}}
  {{ssl_certificate}}
  server_name www.thelearner.app;
  return 301 https://thelearner.app$request_uri;
}

# Next domain
server {
  listen 80;
  listen [::]:80;
  listen 443 ssl http2;
  listen [::]:443 ssl http2;
  {{ssl_certificate_key}}
  {{ssl_certificate}}
  server_name thelearner.app www1.thelearner.app;
  # {{root}}
  root /home/wengindustries/htdocs/wengindustries.com/app/learning-app;

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
    expires max;
    access_log off;
  }

  location ~ /\.(ht|svn|git) {
    deny all;
  }

  if (-f $request_filename) {
    break;
  }
}

# The rest could be similar server blocks for your main website, eg parent company, if applicable
```

**Instead**, you can break it up if your vhost is changed to:

```
# therunner.app, www.therunner.app
include /home/wengindustries/htdocs/wengindustries.com/eco/vhost-servers-therunner.app.conf;

# thelearner.app, www.thelearner.app
include /home/wengindustries/htdocs/wengindustries.com/eco/vhost-servers-thelearner.app.conf;

# The rest could be similar server blocks for your main website, eg parent company, if applicable
```

But each include file MUST have the `{{..}}`  expanded or commented out because the included files won’t have variables expanded by Cloudpanel (since it’s not directly inside the vhost textbox at Cloudpanel). So it may end up looking like (a lot could just be commented out, and some are commented out followed by the expanded lines):

```
server {
  listen 80;
  listen [::]:80;
  listen 443 ssl http2;
  listen [::]:443 ssl http2;
  # {{ssl_certificate_key}}
  # {{ssl_certificate}}
  ssl_certificate_key /etc/nginx/ssl-certificates/wengindustries.com.key;
  ssl_certificate /etc/nginx/ssl-certificates/wengindustries.com.crt;
  server_name www.therunner.app;
  return 301 https://therunner.app$request_uri;
}

server {
  listen 80;
  listen [::]:80;
  listen 443 ssl http2;
  listen [::]:443 ssl http2;
  # {{ssl_certificate_key}}
  # {{ssl_certificate}}
  ssl_certificate_key /etc/nginx/ssl-certificates/wengindustries.com.key;
  ssl_certificate /etc/nginx/ssl-certificates/wengindustries.com.crt;
  server_name therunner.app www1.therunner.app;
  # {{root}}
  root /home/wengindustries/htdocs/wengindustries.com/app/run-app;

  # {{nginx_access_log}}
  # {{nginx_error_log}}

  if ($scheme != "https") {
    rewrite ^ https://$host$uri permanent;
  }

  location ~ /.well-known {
    auth_basic off;
    allow all;
  }
    
    # {{settings}}
    
    
    # Custom 404, / to 404, and error_page defined
    location /404.html {
        root /home/wengindustries/htdocs/wengindustries.com;
        internal; # Prevent direct access to 404.html
    }

    location / {
        # alias /home/wengindustries/htdocs/wengindustries.com/app/run-app;
        fastcgi_intercept_errors on;
        proxy_intercept_errors on; 
        # try_files $uri $uri/ =404;
        
        #{{varnish_proxy_pass}}
        proxy_pass http://127.0.0.1:8080;
        
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
    expires max;
    access_log off;
  }

  location ~ /\.(ht|svn|git) {
    deny all;
  }

  if (-f $request_filename) {
    break;
  }
}
```

