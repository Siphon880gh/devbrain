Titled: Domain Redirects - Namecheap domain redirects to another URL

Goal:
```
Visiting `https://nursing.icu` or `https://www.nursing.icu` redirects to `https://www.wengindustry.com/app/rngame`
```

Required: 
- Namecheap owning that domain (No need to transfer DNS management out of Namecheap)
- Cloudpanel created website (choose PHP Generic site which allows most customization)

![[Pasted image 20250317025325.png]]

Open your site in Cloudpanel, then open File Manager, then edit the index.php or index.html:
![[Pasted image 20250317025407.png]]

You can choose to either keep as the default Hello World:
```
<?php  
  
echo 'Hello World :-)';
```

Or you can have it redirect to your website:
```
<meta http-equiv="refresh" content="0;url=https://wengindustry.com/app/rngame/">
```

Cloudpanel site’s vhost need not be edited because we will keep the htdocs root as is since we handled that just now (adding redirect if applicable in a previous step) and the url’s domain to match internet request is automatically generated into the vhost at each server block.
- NOT EDITING. Let’s say your website is DOMAIN.TLD, then the vhost looks like this code snippet below.
- Note that `{{root}}`  and other such variables with double curley brackets may not be an accurate syntax for nginx vhost, but it’s accurate for cloudpanel which will rewrite to eg. `root /path/to/htdocs`  at `/etc/nginx/sites-enabled/DOMAIN.TLD` 
- FYI only:
```
server {  
  listen 80;  
  listen [::]:80;  
  listen 443 ssl http2;  
  listen [::]:443 ssl http2;  
  {{ssl_certificate_key}}  
  {{ssl_certificate}}  
  server_name www.DOMAIN.TLD;  
  return 301 https://DOMAIN.TLD$request_uri;  
}  
  
server {  
  listen 80;  
  listen [::]:80;  
  listen 443 ssl http2;  
  listen [::]:443 ssl http2;  
  {{ssl_certificate_key}}  
  {{ssl_certificate}}  
  server_name DOMAIN.TLD www1.DOMAIN.TLD;  
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
  
  location / {  
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
  listen 8080;  
  listen [::]:8080;  
  server_name DOMAIN.TLD www1.DOMAIN.TLD;  
  {{root}}  
  
  try_files $uri $uri/ /index.php?$args;  
  index index.php index.html;  
  
  location ~ \.php$ {  
    include fastcgi_params;  
    fastcgi_intercept_errors on;  
    fastcgi_index index.php;  
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;  
    try_files $uri =404;  
    fastcgi_read_timeout 3600;  
    fastcgi_send_timeout 3600;  
    fastcgi_param HTTPS "on";  
    fastcgi_param SERVER_PORT 443;  
    fastcgi_pass 127.0.0.1:{{php_fpm_port}};  
    fastcgi_param PHP_VALUE "{{php_settings}}";  
  }  
  
  if (-f $request_filename) {  
    break;  
  }  
}
```

---

Get IP address from CloudPanel (shows at top)

At Namecheap, use Advanced DNS
- A record @ WEBHOST_IP_ADDRESS
- CNAME Record * YOUR_DOMAIN_WITHOUT_WWW

Patiently wait for DNS to propagate in your country:
- If taking too long, change TTL from “Automatic” to “5 min” and wait 5 mins
- If still taking long but you see some areas of the world have propagated (webhost IP address updated), and if you have a VPN app, you can login as that country or state to check your website on the web browser
- Note the domain in the url or you can search another domain for A records at the website
[https://www.whatsmydns.net/#A/nursing.icu](https://www.whatsmydns.net/#A/nursing.icu)  

Check your domain. It should say something about not having HTTPS like (depends on your web browser):
Chrome could look like
![[Pasted image 20250317025011.png]]

Safari could look like
![[Pasted image 20250317025027.png]]

You can click Continue to site. If no such option exists, type in Chrome: “thisisunsafe” which is a secret typing to forcefully visit a non https website.

You should either see the “Hello world” or the redirect depending on if you had edited from Cloudpanel File Manager in an earlier step.

---

Now setup the https at Cloudpanel.

Refer to [[CloudPanel - SSL _FUNDAMENTALS - Let's Encrypt Self-Signed]]