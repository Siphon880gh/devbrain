Aka: Get Started

Now to make nodejs express apps and react apps work, this is the guide. For python flask, you have to follow supervisor instructions [[Supervisor Primer - Concepts]] and [[Supervisor Primer - GET STARTED (Python stack with Sh, Pyenv-virtualenvs, Pipenv, Gunicorn)]]

Requirements: 
You've already setup the apps themselves to work in this Mixed Server architecture, depending on the particular app type:
- [[Mixed Web Server - Reverse Proxied and Have React Router]]
- [[Mixed Web Server - Reverse Proxied CRA React app]]
- [[Mixed Web Server - Reverse Proxied CRA React with GraphQL MongoDB]]
- [[Mixed Web Server - Reverse Proxy to a Backend Port (Express, Flask)]]



---
At your folder containing all app folders at the remote server, you should have a "Migration Guide - 1. Migration.md" and a "Migration Guide - 2. Audit". Add to the top of the Migration migration guide:

```
Your all time decisions:
- **ecosystem/app port level:** 
	- Your response: __
- **Vhost CORS enabling at server/location level:** 
	- Your response: __
```

And you add the rest of this tutorial below to the same Migration migration guide as well, so you can reference it at that point when needed to migrate apps to another server / environment / folder hierarchy

---

For all times have:

- Decide on managing env variable at which level:
	- ecosystem.config.js level
	- Or: app folder’s .env file level
- If enabling CORS: Decide if you’re enabling CORS at server block level or the inner location block level. 
	- Why: If you have it at both levels, you’ll get this fetch error: “Response to preflight request doesn't pass access control check: The 'Access-Control-Allow-Origin' header contains multiple values '*, *', but only one is allowed.”
- Decide the folder where you manage BOTH vhost  (for nginx server but if you're in Apache server, use your equivalent AND ecosystem.config.js (pm2):
	- Let’s say we have the vhost in our eco/ folder already `include` ‘d at your website’s vhost
	- eco/ecosystem.config.js:
	```
	└── eco    
	    ├── ecosystem.config.js    
	    ├── Makefile    
	    ├── supervisor    
	    │   ├── conf.d -> /etc/supervisor/conf.d    
	    │   └── supervisord.conf -> /etc/supervisor/supervisord.conf    
	    └── vhost-reverse-proxies.conf
	```

Adjustments to app’s PORT at

- Recommend ecosystem app name can be `app:PORT`  because pm2 list command doesn’t show port
- Decide app level .env PORT or ecosystem.config.js PORT (recommended because all in one place).. and don’t worry if you have both because ecosystem will override existing env variables for you. Let’s say you chose eco:

/home/wengindustries/htdocs/wengindustries.com/eco/ecosystem.config.js  
Like this:
```
  {  
    name: 'goals-social-network:3004',  
    cwd: "/home/wengindustries/htdocs/wengindustries.com/app/goals-social-network",  
    interpreter: '/root/.nvm/versions/node/v22.8.0/bin/node',  
    script: '/root/.nvm/versions/node/v22.8.0/bin/npm',  
    args: '--scripts-prepend-node-path=auto run start',  
    env_production: {  
       NODE_ENV: 'production',  
       PORT: 3004,  
    },  
    watch: false,  
    exec_mode: 'cluster',  
    instance_var: 'INSTANCE_ID',  
    log_date_format: 'YYYY-MM-DD HH:mm Z'  
  },  
  {  
    name: 'image-gallery-nft-collab:3005',  
    cwd: "/home/wengindustries/htdocs/wengindustries.com/app/image-gallery-nft-collab",  
    interpreter: '/root/.nvm/versions/node/v22.8.0/bin/node',  
    script: '/root/.nvm/versions/node/v22.8.0/bin/npm',  
    args: '--scripts-prepend-node-path=auto run start:prod',  
    env_production: {  
       NODE_ENV: 'production',  
       PORT: 3005,  
    },  
    watch: false,  
    exec_mode: 'cluster',  
    instance_var: 'INSTANCE_ID',  
    log_date_format: 'YYYY-MM-DD HH:mm Z'  
  },
```

- Friendly url reverse proxying into server’s internal address 127.0.0.1:PORT  
/home/wengindustries/htdocs/wengindustries.com/eco/vhost-reverse-proxies.conf  
Like this:
```
  # Reverse proxy  
  location ~ /app/goals-social-network[/]* {  
    rewrite ^/app/goals-social-network[/]*(.*)$ /$1 break;  
    proxy_pass http://127.0.0.1:3004;  
    proxy_read_timeout 300s;   # Adjust as needed  
    proxy_connect_timeout 300s; # Adjust as needed  
    proxy_send_timeout 300s;   # Adjust as needed  
    proxy_set_header Host $host;  
    proxy_set_header X-Real-IP $remote_addr;  
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;  
    proxy_set_header X-Forwarded-Proto $scheme;  
  
    # Enable CORS  
    # add_header 'Access-Control-Allow-Origin' '*' always;  
    # add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS' always;  
    # add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization' always;  
      
    # Handle OPTIONS (preflight) requests  
    if ($request_method = OPTIONS) {  
      add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';  
      add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization';  
      add_header 'Access-Control-Max-Age' 1728000;  
      return 204;  
    }  
  }      
  
# ---------------------------------------------------------------------------------------------- #  
  
# Reverse proxy 1/2  
  location ~ /app/image-gallery-nft-collab[/]* {  
    rewrite ^/app/image-gallery-nft-collab[/]*(.*)$ /$1 break;  
    proxy_pass http://127.0.0.1:3005;  
    proxy_read_timeout 300s;   # Adjust as needed  
    proxy_connect_timeout 300s; # Adjust as needed  
    proxy_send_timeout 300s;   # Adjust as needed  
    proxy_set_header Host $host;  
    proxy_set_header X-Real-IP $remote_addr;  
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;  
    proxy_set_header X-Forwarded-Proto $scheme;  
  
    # Enable CORS  
    # add_header 'Access-Control-Allow-Origin' '*' always;  
    # add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS' always;  
    # add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization' always;  
      
    # Handle OPTIONS (preflight) requests  
    if ($request_method = OPTIONS) {  
      add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';  
      add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization';  
      add_header 'Access-Control-Max-Age' 1728000;  
      return 204;  
    }  
  }  
  
  
  # Reverse proxy 2/2  
  location ~ /graphql-image-gallery-nft-collab {  
    proxy_pass http://127.0.0.1:3005;  
    proxy_http_version 1.1;  
    proxy_set_header Upgrade $http_upgrade;  
    proxy_set_header Connection 'upgrade';  
    proxy_set_header Host $host;  
    proxy_cache_bypass $http_upgrade;  
  }
```

- The app folder’s .env’s PORT (if managing port at the app .env level) which is NOT recommended: `grep -iRn "PORT=" --include=".env"`

So can manage pm2 ecosystem:

```
cd /home/wengindustries/htdocs/wengindustries.com/eco/
```

```
pm2 list all  
pm2 delete all  
pm2 restart ecosystem.config.js --env production
```

---

TROUBLESHOOTING If not working - troubleshoot:

Logging  
```
pm2 log
```
^ And when troubleshooting, you may want to clear the log at times: `pm2 flush`

Can it connect to the port? test inside the ssh session at the remote server
```
ping 127.0.0.1 3100
```

Do your ports match?
- Between ecosystem.config.js (or app level’s .env file) - versus - vhost that proxy passes internet requests internally from friendly http (:80) or https (:443) url  TO NodeJS Express (:300X) or Python Flask (:500X).

If edited vhost, make sure to reload so the settings can apply:
```
nginx -t
service nginx reload
```