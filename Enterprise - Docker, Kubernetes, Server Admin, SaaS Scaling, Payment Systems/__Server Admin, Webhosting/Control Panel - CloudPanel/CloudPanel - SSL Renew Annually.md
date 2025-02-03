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

3. Add www server_name to the Web and PHP :8080 server blocks (so two places) for every domain:
```
server_name www.therunner.app therunner.app www1.therunner.app;
```
^ Rationale: We’ve removed www server catch (that had redirected to non-www), so www version needs to be recognized because Let’s Encrypt will create a secret challenge file from CloudPanel, then it’ll fetch that secret challenge file via a [http://www.](http://www.) url!

Don’t forget to apply the nginx settings by running this command in the SSH terminal:
```
nginx -t; service nginx reload;
```

Then create the new Let’s Encrypt. Once successful, reverse the steps, especially if you want to catch “www” at a server block level to redirect that permanently to a non-www, AND if you want to redirect http:// to https://