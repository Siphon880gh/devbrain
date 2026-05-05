
This guide is for 404, 403, 500, or


```
31.220.18.169 didn’t send any data.

ERR_EMPTY_RESPONSE
```


![](S5JdFKb.png)


That are NOT file permission issues. 

But file permission errors could lead to any of the above errors. File permissions depending on its nature can lead to any of the errors ([[File permissions leading to a variety of HTTPS status errors]]). So see the logs that it's not a file permission issue. This guide isn't to fix file permission issues that lead to webpages not loading on the web browser (But hint - one approach is, your nginx could run as www-data or nginx user, but does that nginx process user belongs to the group owner of your webpages?)

- Is this a fresh install of a dedicated server or web server (apache, nginx)
	- Firewall settings good to go? Look into enabling HTTP and HTTPS. If using ufw for firewall, refer to: [[UFW - Enable specific ports]]
	- Restart your nginx/apache. Look up google how to restart based on your OS, eg. Could be `sudo systemctl restart nginx`
		- See if the web server process is NginX or Apache is properly running
		- For example: `sudo systemctl status nginx`  then you can restart (slight downtime) or reload (faster) in place of status .This is for Ubuntu 22.04 using 
		- Know how to restart web server process
		- Know how to configure web server process centrally (apache and nginx) and directory level (apache htaccess)

- Is this visiting the public IP directly to see if a page appears?
	- Go to your site's CloudPanel Vhost
		- ![](TZ0nPkz.png)
		- Note to replace YOUR_PUBLIC_IP
		```
		server {  
		    listen 80;  
		    listen [::]:80;  
		    server_name YOUR_PUBLIC_IP;  
		
		    listen 443 ssl http2;
		    listen [::]:443 ssl http2;
		    {{ssl_certificate_key}}
		    {{ssl_certificate}}
		  
		    {{root}};  
		      
		    try_files $uri $uri/ /index.php?$args;  
		    index index.html index.htm index.php;  
		      
		      
		  location ~ \.php$ {  
		    include fastcgi_params;  
		    fastcgi_intercept_errors on;  
		    fastcgi_index index.php;  
		    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;  
		    try_files $uri =404;  
		    fastcgi_read_timeout 3600;  
		    fastcgi_send_timeout 3600;  
		    fastcgi_param HTTPS "on";  
		    fastcgi_param SERVER_PORT 443;  
		    fastcgi_pass 127.0.0.1:{{php_fpm_port}};  
		    fastcgi_param PHP_VALUE "{{php_settings}}";  
		  }  
		  
		    location / {  
		        try_files $uri $uri/ =404;  
		    }  
		}
		```

	- Public IP direct visit still not working in web browser:
	  Is your Nginx Vhost (`root` directive) or Apache configuration (`DocumentRoot` directive) pointing to the correct folder where your webpage files are? 
		- Eg. If Hostinger at Cloudpanel VHost: You might see placeholder {{root}} instead of the folder path spelled out. This page writes to the file the webpage's actual vhost file on the server, which could be a file located in a folder somewhere like `/etc/nginx/sites-enabled`, so you have to access that file on SSH terminal (either with vi, nano, or cat)

- Is this a multi website (rather than the default website that comes on when you first installed nginx, for example)
	- Is your website enabled? They would be at something similar to `/etc/**/sites-enabled/` where the asterisk is nginx or apache2 and there's a file in that folder corresponding to the server settings of your website. If your website conf is not in there, it might be in `/etc/**/sites-available`; you would have to enable the website from your list of available websites by creating a symbolic link, something like eg. `sudo ln -s /etc/nginx/sites-available/your_site_config /etc/nginx/sites-enabled/`
	- A default template website is similar to `/etc/**/sites-enabled/default`

	- Is your Nginx Vhost (`root` directive) or Apache configuration (`DocumentRoot` directive) pointing to the correct folder where your webpage files are? 
		- Eg. If Hostinger at Cloudpanel VHost: You might see placeholder {{root}} instead of the folder path spelled out. This page writes to the file the webpage's actual vhost file on the server, which could be a file located in a folder somewhere like `/etc/nginx/sites-enabled`, so you have to access that file on SSH terminal (either with vi, nano, or cat)