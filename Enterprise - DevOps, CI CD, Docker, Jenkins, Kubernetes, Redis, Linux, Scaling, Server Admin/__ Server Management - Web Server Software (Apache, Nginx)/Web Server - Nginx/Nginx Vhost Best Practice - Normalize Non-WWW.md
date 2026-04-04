Matching server names are particularly precise of whether or not there is a www

So you want to normalize all urls so that there will never be a "www."

This will redirect www. to non-www, also cueing the user to now use "www.":
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

```