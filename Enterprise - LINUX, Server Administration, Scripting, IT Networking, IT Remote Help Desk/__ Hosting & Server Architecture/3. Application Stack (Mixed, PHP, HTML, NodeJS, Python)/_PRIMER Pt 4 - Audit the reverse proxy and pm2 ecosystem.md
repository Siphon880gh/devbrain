Go into the folder where you have the included vhost and the ecosystem.config.js, and perhaps supervisor symbolic links (for python):

```
cd eco
```

Check at two terminals that the configured ports match in all these two places of settings:
```
grep -in "name:" ecosystem.config.js
grep -in "port:" ecosystem.config.js
```

Also check that they match at these two places of settings:
```
grep -in "name:" ecosystem.config.js

grep -in -B 2 "proxy_pass [http://127.0.0.1:](http://127.0.0.1:)" vhost*.conf
```

^ By having the name match the port that are both in the same ecosystem.config.js, you make long term managing easier (because pm2 list does NOT show port numbers, so that’s why you have the port number as part of the app name). By having vhost and ecosystem app port match, then you dont get 404 on assets and webpage/web app (often blank page)

vhost grep could look like this

Keep in mind graphql uses same port as the express port that delivers static files and api json information. That’s because the graphql is really not the server endpoints themselves but the underlying system that receives a structured request body and sends back a response body:

```
8-  location ~ /api/mixo[/]* {  
9-    rewrite ^/api/mixo[/]*(.*)$ /$1 break;  
10:    proxy_pass http://127.0.0.1:3100;  
--  
36-  location ~ /app/book-search[/]* {  
37-    rewrite ^/app/book-search[/]*(.*)$ /$1 break;  
38:    proxy_pass http://127.0.0.1:3001;  
--  
61-  # Reverse proxy 2/2  
62-  location ~ /graphql-book-search {  
63:    proxy_pass http://127.0.0.1:3001;  
--  
74-  location ~ /app/budget-tracker[/]* {  
75-    rewrite ^/app/budget-tracker[/]*(.*)$ /$1 break;  
76:    proxy_pass http://127.0.0.1:3002;  
--  
102-  location ~ /app/community-tech-blogs[/]* {  
103-    rewrite ^/app/community-tech-blogs[/]*(.*)$ /$1 break;  
104:    proxy_pass http://127.0.0.1:3003;  
--  
130-  location ~ /app/goals-social-network[/]* {  
131-    rewrite ^/app/goals-social-network[/]*(.*)$ /$1 break;  
132:    proxy_pass http://127.0.0.1:3004;  
--  
158-  location ~ /app/image-gallery-nft-collab[/]* {  
159-    rewrite ^/app/image-gallery-nft-collab[/]*(.*)$ /$1 break;  
160:    proxy_pass http://127.0.0.1:3005;  
--  
184-  # Reverse proxy 2/2  
185-  location ~ /graphql-image-gallery-nft-collab {  
186:    proxy_pass http://127.0.0.1:3005;  
--  
197-  location ~ /app/note-taking[/]* {  
198-    rewrite ^/app/note-taking[/]*(.*)$ /$1 break;  
199:    proxy_pass http://127.0.0.1:3006;
```

Check folder configured paths actually exist:
```
grep -in "cwd:" ecosystem.config.js
```

The unique starting scripts:
- at eco folder:
	```
	grep -in "start:prod" ecosystem.config.js
	```
- at folder containing app folders:
	```
	grep -iRn "start:prod" --include="package.json"
	```


NOT RELEVANT (checking against PORT in .env file at app folder) because using pm2 to override env port. But if you went against advice of using ecosystem to manage the ports instead of the app folder .env files, then check the .env file ports match the vhost at the folder containing all app folders: `grep -iRn "PORT=" --include=".env"`

---

If during auditing you had to make changes to ecosystem, you *must* apply the settings:
```
pm2 delete all
pm2 start ecosystem.config.js --env production
```

- But if you have a Makefile to manage the commands, it could be defined so that you run the command: `make restart`. For Makefile, refer to [[PM2 ecosystem.config.js - Best Practice Makefile Make]]

---

If during auditing you had to make changes to your included vhost file, you *must* apply the settings:
```
nginx -t
service nginx restart
```
^ `nginx -t` checks syntax
^ Also your service syntax might differ depending on the OS
