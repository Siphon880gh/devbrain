
Redirect to https ONLY on 80, so your other ports are available!

```
server {  
    listen 80;  
    listen [::]:80;  
    server_name <DOMAIN.TLD>;  
      
    # Redirect to HTTPS for standard HTTP port only  
    return 301 https://$host$request_uri;  
}
```