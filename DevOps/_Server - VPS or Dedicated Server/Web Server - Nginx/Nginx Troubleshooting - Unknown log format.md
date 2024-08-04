Vhosts not saving or nginx not starting successfully from service or systemctl.

So you checked the syntax of combining nginx main config with the sites' vhost by running
```
sudo nginx -t
```
	

And the log error is:  
```
unknown log format "main" in /etc/nginx/sites-enabled/domain.tld.conf:22
```

Problem is though syntax correct, variables weren't defined at the nginx main config that the site's vhost uses, so in a way is incorrect syntax. Perhaps Cloudpanel made assumptions the variable exists in nginx main config or it failed to add to the nginx main config during installation
	
In that case, define the “main” log’s log_format at nginx’s main config
```
vi /etc/nginx/nginx.conf  
```
	
Add into http block but. before it include nginx other config files and sites-enabled’s vhost:
```
log_format main '$remote_addr - $remote_user [$time_local] "$request" '  
		 '$status $body_bytes_sent "$http_referer" '  
		 '"$http_user_agent" "$http_x_forwarded_for"';  
```
	
	
(so that’s before:  
```
	        include /etc/nginx/conf.d/*.conf;
	        include /etc/nginx/sites-enabled/*;
```
)
	

Test if successful (checks all nginx cong including wildcarded sites enabled vhosts)
```
sudo nginx -t
```
	  

Finally, make sure in /etc/nginx/nginx.conf at the very top, that the user and group the web server will act as is:
```
user www-data www-data;
```



