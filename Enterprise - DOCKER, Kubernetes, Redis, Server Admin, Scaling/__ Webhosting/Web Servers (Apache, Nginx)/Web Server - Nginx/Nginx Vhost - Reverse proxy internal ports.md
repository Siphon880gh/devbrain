If you have ports like 300X and 500X for NodeJS Express servers or Python Flask servers, you don't want users to even know the underlying technology or port. So instead of accessing your app at: `domain.tld:3000`. They access the app at `domain.tld/app/app1`. Other advantages include actually appearing on google search results, easier urls to memorize for your users, SSL certificates to avoid the warning on users' web browsers.

Take a look at a reverse proxy vhost:
- ATTENTION: You adjust the URL at the location line AND rewrite line. Usually to the same URL.
```

  # Reverse proxy
  location ~ /app/budget-tracker[/]* {
    rewrite ^/app/budget-tracker[/]*(.*)$ /$1 break;
    proxy_pass http://127.0.0.1:3001;
    proxy_read_timeout 300s;   # Adjust as needed
    proxy_connect_timeout 300s; # Adjust as needed
    proxy_send_timeout 300s;   # Adjust as needed
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto $scheme;

    # Enable CORS
    add_header 'Access-Control-Allow-Origin' '*' always;
    add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS' always;
    add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization' always;
    
    # Handle OPTIONS (preflight) requests
    if ($request_method = OPTIONS) {
      add_header 'Access-Control-Allow-Origin' '*';
      add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';
      add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization';
      add_header 'Access-Control-Max-Age' 1728000;
      return 204;
    }
  }
```

When a user visits your website at domain.tld/app/budget-tracker or domain.tld/app/buget-tracker/, your nginx server parses the request url and gets a match for the location block above. Then  following the location block instructions, nginx rewrites the request url internally back to a `/` so that your nodejs app (`server.js`) which is developed originally on a localhost on your computer can continue parsing and matching for `/` root starting paths (eg. `router.get('/', (req, res) => {`). Notice vhost's `proxy_pass` simply passes the internet request to 127.0.0.1:3001 which is equivalent to root path 127.0.0.1:3001/, and this is local at your remote server. 

Once nginx is reading the vhost, it has access to the **INTERNAL** network. The interNET can be blocked from accessing the interNAL port 3001 with `ufw` or `iptables`, while the user is accessing your nodejs or python app via the external ports 80 and/or 443, and that's fine.

External ports:
- 80
- 443

Internal port:
- 3001