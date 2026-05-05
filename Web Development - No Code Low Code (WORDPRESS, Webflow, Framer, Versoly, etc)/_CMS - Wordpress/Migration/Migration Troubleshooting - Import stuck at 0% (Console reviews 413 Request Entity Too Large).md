Titled: Import stuck at 0% (Console reviews 413 Request Entity Too Large)

The import is stuck at 0%:
![](mKT7WRJ.png)


If you open DevTools console, looks like:
![](EbxEtB8.png)

---

Which is your server?.
- Nginx with or without CloudPanel? 
	- CloudPanel does not have PHP settings for client side post limits
	- Instead you edit at the central config file for nginx:
	  ```
		sudo vi /etc/nginx/nginx.conf
		```
	- Look for `client_max_body_size` (Hint, for vim, typing '/' lets you type your search words, then you press enter to jump to match)
	- You can set to 64M, or 128M, or 512M by convention (you can set to any megabytes actually):
	  ```
	  client_max_body_size 512M;
		```
	- Test syntax with `sudo nginx -t`, but reload nginx with: `sudo service nginx reload`
	  
- Apache? Check Google (To be completed in this tutorial in the future)