

- If visiting http://www.domain.com with the "www." is giving this error about too many redirects:
		![](https://i.imgur.com/v3Cnk6m.png)
	- Solution:
		1. Remove this server block (feel free to backup to your some document if you’re concerned)
			```
			server {  
				listen 80;  
				listen [::]:80;  
				listen 443 quic;  
				listen 443 ssl;  
				listen [::]:443 quic;  
				listen [::]:443 ssl;  
				http2 on;  
				http3 off;  
				{{ssl_certificate_key}}  
				{{ssl_certificate}}  
				return 301 https://www.domain.tld$request_uri;  
			}
			```
		1. Comment out https scheme rewrite at the other block
		```
		#if ($scheme != "https") {  
		#  rewrite ^ https://$host$request_uri permanent;  
		#}  
		```
		
		2. At your main server block for 80 and 443, add the www (See server_name line):
			```
			server {  
			  listen 80;  
			  listen [::]:80;  
			  listen 443 quic;  
			  listen 443 ssl;  
			  listen [::]:443 quic;  
			  listen [::]:443 ssl;  
			  http2 on;  
			  http3 off;  
			  {{ssl_certificate_key}}  
			  {{ssl_certificate}}  
			  server_name domain.tld www1.domain.tld www.domain.tld;  
			  {{root}}
			  # ...
			```

		3. At your 8080 port server block, also do the same:
			```
			server {  
			  listen 8080;  
			  listen [::]:8080;  
			  server_name domain.tld www1.domain.tld www.domain.tld;  
			  {{root}} 
			  # ...
			```
