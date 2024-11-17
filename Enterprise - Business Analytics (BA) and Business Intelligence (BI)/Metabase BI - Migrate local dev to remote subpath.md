Migrating to remote:
- Likely you planned to install Metabase on your computer (aka local dev) to see if it works before installing on production remote server. This section adds instructions to the local development installation instructions at [[Metabase BI - _PRIMER]] because the instructions are essentially the same but remote server setup is a bit more complicated.

What is remote subpath:
- https://domain.tdl/subpath to access Metabase web portal

Requirement:
- Subpath setup is ONLY AVAILABLE on Pro and Enterprise.
	- If you're on free version, setup Root Path instead: [[Metabase BI - Migrate local dev to remote root path]]
- This guide assumes you have a working local copy and therefore a working docker-compose.yml because you will be making changes to the working yml copy then migrating the file over to the remote server. In addition, you'll perform other checks and changes to postgres and docker to make a Containerized Metabase work over the internet.

---

## Instructions

1. First setup so that Metabase can at http://domain.tld:3500, aka the remote root path. Refer to [[Metabase BI - Migrate local dev to remote root path]]
2. Then return here so we can perform reverse proxy.

## Reverse Proxy Instructions
Quick Review: Reverse proxy is when you say you want users to visit https://domain.tld/subpath in order to access the true url http://domain.tld:PORT. It also is a better experience for your stakeholders to visit the subpath than some weird port number in the URL (they're likely not tech backgrounds).

1. Reverse Proxy
On nginx, you're editing the vhost for your domain (follow equivalent instructions if on apache):  
```  
location /mb-admin/ {  
 proxy_pass http://127.0.0.1:3500;
}  
```  

OR if needed because of your server settings, the proxy_pass block can be more complex:
```
    location /mb-admin/ {
        # Rewrite incoming requests to strip the /mb-admin prefix
        rewrite ^/mb-admin(/.*)$ $1 break;

        # Forward the rewritten request to Metabase
        proxy_pass http://127.0.0.1:3500;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;

        # Disable buffering for Server-Sent Events (SSE) if required by Metabase
        proxy_buffering off;
        proxy_cache off;
        proxy_http_version 1.1;
        proxy_set_header Connection '';

        # Rewrite Location headers to ensure correct paths in redirects
        proxy_redirect / /mb-admin/;

        # Substitute 'path=/' in cookies to ensure compatibility with /mb-admin
        sub_filter 'path=/' 'path=/mb-admin/';
        sub_filter_once off;
        return 301 https://$host$request_uri;
    }
```

^ You want http instead of https in the proxy_pass because you don't have a SSL certificate for Metabase's web portal and you don't want it blocked on the web browser.
^ You also have to check the rest of the vhost that for the http to https rewrite rules, so that the matching of the location happens. To get the boilerplate on how to properly redirect 80 to 443 (http to https) so you can troubleshoot your http redirection: [[Nginx Vhost - Redirect http to https (aka 80 to 443)]].

Then you can reload the vhost for nginx by running:  
```  
sudo systemctl reload nginx  
```

Reverse Proxy problems? Refer to [[Nginx Vhost - Redirect http to https - Troubleshooting]]

2. Metabase Site Url
Next you have to tell Metabase that the URL is not at root. You set MB_SITE_URL in the docker run (if testing) or ultimately at the docker-compose.yml file or the config file. The MB_SITE_URL is only available on Pro and Enterprise, and it will be ignored without errors on Free version. Without MB_SITE_URL, visiting the web portal at the subpath will load Metabase part way (the tab will be titled Metabase) and it’ll be a blank page with 404 errors because of asset files loading from the wrong URLs.

- docker run (partial):
```
-e MB_SITE_URL=https://domain.tld/mb-admin/
```

- docker-compose.yml (partial):
```
    environment:
      MB_SITE_URL: https://domain.tld/mb-admin/
```

- config file:
  https://www.metabase.com/docs/latest/configuring-metabase/config-file

---

Your docker-compose.yml's may look like this:
Local development on Mac M1:
```
version: '3.8'  
  
services:  
  metabase:  
    image: stephaneturquay/metabase-arm64:latest  
    ports:  
      - "3500:3000"  
    environment:  
      MB_JETTY_PORT: 3000  
      MB_DB_TYPE: postgres  
      MB_DB_DBNAME: metabaseappdb  
      MB_DB_PORT: 5432  
      MB_DB_USER: root  
      MB_DB_PASS: root  
      MB_DB_HOST: host.docker.internal  
    restart: always
```

Then the remote docker-compose.yml:
```
version: '3.8'  
  
services:  
  metabase:  
    image: metabase/metabase:latest  
    ports:  
      - "3500:3000"  
    environment:  
      MB_SITE_URL: https://domain.tld/mb-admin/
      MB_JETTY_PORT: 3000  
      MB_DB_TYPE: postgres  
      MB_DB_DBNAME: metabaseappdb  
      MB_DB_PORT: 5432  
      MB_DB_USER: root  
      MB_DB_PASS: root  
      MB_DB_HOST: 111.22.333.44  
    restart: always
```

---

Visiting the subpath https://domain.tld/mb-admin will work. No HTTPS warning
![](https://i.imgur.com/kpGeM4p.png)

Now you can work on creating reports for your cofounders/founders/strategists/investors that they can see live and won't accidentally modify your database.
