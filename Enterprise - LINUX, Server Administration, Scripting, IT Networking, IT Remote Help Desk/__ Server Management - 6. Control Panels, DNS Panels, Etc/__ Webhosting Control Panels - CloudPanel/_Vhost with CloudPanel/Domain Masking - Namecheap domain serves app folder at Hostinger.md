Titled: Domain Masking - Namecheap domain serves app folder at Hostinger

Goal:
```
Visiting `https://nursing.icu` delivers the page and all is assets from `https://www.wengindustry.com/app/rngame`, without revealing the underlying URL. The domain remains `https://nursing.icu`, and all pages opened will be relative to that, eg. User sees `https://nursing.icu/page2.html`, NOT `https://www.wengindustry.com/app/rngame/page2.html`
```

Required:   
- Namecheap owning that domain (No need to transfer DNS management out of Namecheap)

NOT Required:
- No need to create Cloudpanel website named after the domain name. We will take a different approach than the redirecting domain at [[Domain Redirects - Namecheap domain redirects to another URL]].

Note which user owns the folder you want, then figure out which Cloudpanel website that user belongs to.

For example, I opened Filezilla (FTP Client) and at `/home/wengindustries/htdocs/wengindustries.com/app` we see the folder `rngame`  (which is visited on the web-browser at `https://wengindustries.com/app/rngame`)

![[Pasted image 20250317024519.png]]

The owner is wengindustries (opps the screenshot is cut off). If your owner column is cut off, you may have to scroll right or resize the column.

At the Cloudpanel sites, there’s a site user column. We found wengindustries user is for the website wengindustries.com:
![[Pasted image 20250317024629.png]]

So we go into that website’s cloudpanel. And we go to vhost. At the top of vhost (Let’s call it main vhost), we import another vhost file:
```
# import domain mask: nursing.icu  
include /home/wengindustries/htdocs/wengindustries.com/eco/vhost-servers-nursing.icu.conf;
```

^ FYI You could have multiple domain masks this way, eg.
- FYI:
```
# import domain mask: therunner.app  
include /home/wengindustries/htdocs/wengindustries.com/eco/vhost-servers-therunner.app.conf;  
  
# import domain mask: nursing.icu  
include /home/wengindustries/htdocs/wengindustries.com/eco/vhost-servers-nursing.icu.conf;
```

Don’t save yet, because it’ll complain of errors (since that file doesn’t exist yet). 

Go on a SSH terminal session with root access to reload the vhost rules with this command (or similar depending on your Linux OS at Hostinger):
```
systemctl reload nginx
```

Then you create that file (eg. vhost-servers-nursing.icu.conf) at that location. Make sure it’s named the same way you named it, noting that the name hints its a vhost you’re importing for other domains and that it has the domain name right before `.conf` . This is called the secondary vhost. Let’s fill it in:

- Replace all `DOMAIN.TLD`  with your domain (eg. `nursing.icu`  or `my-site.com` ).
- Note that `{{root}}`  and other such variables with double curley brackets must be expanded (Cloudpanel won’t expand them into proper vhost for you).

- For `{{ssl_certificate_key}}`  and `{{ssl_certificate}}` , I’ve replaced them at the next lines with the expanded vhost lines and the filepaths to the certificate key and certificate (See the main vhost’s expansion with command similar to (make sure to change to your cloudpanel site hostname): `cat /etc/nginx/sites-enabled/wengindustries.com.conf` )

- Note that `{{settings}}`  is Cloudpanel settings for that site being used to generate more lines at the vhost. We’re going to just remove/comment out `{{settings}}`  here.
- For brevity and laziness, I just removed/commented out  `{{nginx_access_log}}`  and `{{nginx_error_log}}`.
- Address the 404 lines below as well (adjust them appropriately)
- But most importantly, you need to remove the `{{root}}`  and the next line following it you must point to the exact folder path that you’re serving at the masked domain address. 

- eg.: `root /home/wengindustries/htdocs/wengindustries.com/app/rngame`
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
  server_name www.DOMAIN.TLD;  
  return 301 https://DOMAIN.TLD$request_uri;  
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
  server_name www.DOMAIN.TLD DOMAIN.TLD www1.DOMAIN.TLD;  
  root /home/wengindustries/htdocs/wengindustries.com/app/your-app;  
  
  # {{nginx_access_log}}  
  # {{nginx_error_log}}  
  
  # if ($scheme != "https") {  
  #   rewrite ^ https://$host$uri permanent;  
  # }  
  
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
        fastcgi_intercept_errors on;  
        proxy_intercept_errors on;   
        # try_files $uri $uri/ =404;  
        add_header Cache-Control "no-cache, no-store, must-revalidate";  
        add_header Pragma "no-cache";  
        add_header Expires 0;  
          
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
      
  
  # Disable caching for service worker files  
  location ~* /.*sw\.js$ {  
      add_header Cache-Control "no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0";  
      add_header Pragma "no-cache";  
      add_header alt-svc 'h3=":443"; ma=86400';  
      expires -1;  
  }  
  location ~* /.*service-worker\.js$ {  
      add_header Cache-Control "no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0";  
      add_header Pragma "no-cache";  
      add_header alt-svc 'h3=":443"; ma=86400';  
      expires -1;  
  }  
  
  # Caching Static Assets  
  location ~* ^.+\.(css|js|jpg|jpeg|gif|png|ico|gz|svg|svgz|ttf|otf|woff|woff2|eot|mp4|ogg|ogv|webm|webp|zip|swf|map|mjs)$ {  
    add_header Access-Control-Allow-Origin "*";  
    add_header alt-svc 'h3=":443"; ma=86400'; # Notified of http3 support for the next 24h  
    access_log off;  
      
    add_header Cache-Control "no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0";  
    expires 0;  
  
    # For swiching back to sticky cache  
    # add_header Cache-Control "public, max-age=31536000, immutable";  
    # expires max; # `expires max` or `expires 1y`  
  }  
  
  location ~ /\.(ht|svn|git) {  
    deny all;  
  }  
  
  if (-f $request_filename) {  
    break;  
  }  
}
```

Checkpoint:
- The main vhost is for the site user who owns the folder you will serve at the masked domain
- The secondary vhost file that configures that masked domain is owned by the same user

Now we save at the main vhost at Cloudpanel and it should not have errors (otherwise the filepath to your secondary vhost is wrong, the secondary vhost file is owned by a different user, or the syntax at either the main or secondary vhost is wrong). 

At the main vhost, we add this 8080 server block at the bottom (unfortunately, we cannot add this at the secondary vhost because it MUST be the final server blocks):
- Make sure to add to bottom where the 8080 server blocks are at.
- You’re adding this to the main vhost, and that’s Cloudpanel’s vhost
- Adjust `DOMAIN.TLD`  to your domain (eg. `nursing.icu`  or `my-site.com` )
- Make sure to write the proper `root`  folder path to the folder you’re serving.
```
server {  
  listen 8080;  
  listen [::]:8080;  
  server_name www.DOMAIN.TLD DOMAIN.TLD www1.DOMAIN.TLD;  
  # {{root}}  
  root /home/wengindustries/htdocs/wengindustries.com/app/quiz-gsheet;  
    
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

Save the main vhost at Cloudpanel again. Should be no errors.

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

You should the webpage being served.

---

Now setup the https at Cloudpanel. This isn’t the usual way of setting up SSL per website under Cloudpanel Sites (and each website with same name as your domain).

Briefly:
At your main website that shares the same user as the user of the folder you’re serving at the masking domain, go to SSL tab and for the Let’s Encrypt, you’ll adding the main website and all other domains that you’ve been masking under this website

So I was masking therunner.app (so that it serves `app/run-app`  without revealing that underlying url) while the website is mainly for wengindustries, so the old SSL matches are:
`therunner.app, wengindustries.com, wengindustry.com, www.therunner.app, www.wengindustries.com, www.wengindustry.com`
![[Pasted image 20250317025114.png]]

Following the same pattern of adding a non-www and a www version of the domains, the new SSL will have:
`nursing.icu, therunner.app, wengindustries.com, wengindustry.com, www.nursing.icu, www.therunner.app, www.wengindustries.com, www.wengindustry.com`  

We’ll create the new Let’s Encrypt certificate, which will deactivate the older Let’s Encrypt (since only one can be active at any time):
![[Pasted image 20250317025126.png]]

After successfully creating, the list of certificates show you that only the newest one that includes your new masking domain is installed:
![[Pasted image 20250317025136.png]]

You can remove the old Let’s Encrypt to get the final list:
![[Pasted image 20250317025145.png]]

You are done.

Visiting your new domain at https address should have no https errors.