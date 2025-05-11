 You likely have to temporarily change the vhost so that it allows Let's Encrypt to create a secret file and fetch it from frontend at http://www.domain.tld..../SECRET_KEY_FILE, noticing that neither http nor www could be redirected to https:/domain.tld because then the web browser will block with a warning page, therefore Let's Encrypt failing to fetch the file.

1. Disable www 301 server redirect blocks
You can CUT them away from Vhost for now. It should look like this that needs to be disabled/removed:
```
# server {  
#   listen 80;  
#   listen [::]:80;  
#   listen 443 ssl http2;  
#   listen [::]:443 ssl http2;  
#   {{ssl_certificate_key}}  
#   {{ssl_certificate}}  
#   server_name www.wengindustries.com;  
#   return 301 https://wengindustries.com$request_uri;  
# }  
#   
# server {  
#   listen 80;  
#   listen [::]:80;  
#   listen 443 ssl http2;  
#   listen [::]:443 ssl http2;  
#   {{ssl_certificate_key}}  
#   {{ssl_certificate}}  
#   server_name www.wengindustry.com;  
#   return 301 https://wengindustry.com$request_uri;  
# }  
# server {  
#   listen 80;  
#   listen [::]:80;  
#   listen 443 ssl http2;  
#   listen [::]:443 ssl http2;  
#   {{ssl_certificate_key}}  
#   {{ssl_certificate}}  
#   server_name www.therunner.app;  
#   return 301 https://therunner.app$request_uri;  
# }
```


2. Disable https redirect at Web server blocks for every domain:
```
  #if ($scheme != "https") {  
  #  rewrite ^ https://$host$uri permanent;  
  #}
```

3. Add **www server_name** to the Web and PHP :8080 server blocks (so 80/443 block AND 8080 block) for every domain:
```
server_name www.therunner.app therunner.app www1.therunner.app;
```
^ Rationale: We’ve removed www server catch (that had redirected to non-www), so www version needs to be recognized because Let’s Encrypt will create a secret challenge file from CloudPanel, then it’ll fetch that secret challenge file via a [http://www.](http://www.) url!

4. Make sure none of your server_name block is pointing to a subfolder from the expected root, because Let's Encrypt creates a file relative to the expected root and then checks the http url to that file as verification. Change to expected root temporarily, for example, changing `root /home/wengindustries/htdocs/wengindustries.com/app/run-app;` TO `root /home/wengindustries/htdocs/wengindustries.com/;`


5. Last resort - If still not working, reload nginx settings via SSH terminal:
```
nginx -t; service nginx reload;
```

6. Last resort - If still not working, try to have only ONE 8080 block. Therefore, could look like:
```
server {
  listen 8080;
  listen [::]:8080;
  server_name www1.therunner.app wengindustries.com www1.wengindustries.com wengindustry.com www1.wengindustry.com;
  root /home/wengindustries/htdocs/wengindustries.com/;
```

---

Once successful, reverse the steps, especially if you want to catch “www” at a server block level to redirect that permanently to a non-www, AND if you want to redirect http:// to https://

---

Note you can't group them like this:
![[Pasted image 20250223051902.png]]

So you must create only one SSL certificate for the webhost, so the domains may end up being all on one certificate creation:
![[Pasted image 20250223051846.png]]