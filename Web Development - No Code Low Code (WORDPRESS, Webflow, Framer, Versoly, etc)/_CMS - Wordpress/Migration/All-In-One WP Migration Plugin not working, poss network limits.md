
What this is for: Anything to do with max file size, memory limit, etc

Specifically, if for [[Migration Troubleshooting - Import stuck at 0% (Console reviews 413 Request Entity Too Large)]], refer to that tutorial instead.

---


Try adding to wp-config.php found in your website files:
![](fqzPSOI.png)

Adding:
```
/* All-In-One WP Migration */
define('WP_MEMORY_LIMIT', '256M');
define('MAX_EXECUTION_TIME', 300);
```

And/or:
```
@ini_set( 'upload_max_filesize' , '200M' );
@ini_set( 'post_max_size', '200M');
@ini_set( 'memory_limit', '256M' );
@ini_set( 'max_execution_time', '300' );
@ini_set( 'max_input_time', '300' );
```

Or add them both, in the order presented here

But MAKE SURE your settings are applied before this line:
`/* That's all, stop editing! Happy publishing. */`

And preferably after this line:
`/* Add any custom values between this line and the "stop editing" line. */`

---

Check if the settings applied!

Go to the WordPress admin dashboard and navigate to `Tools > Site Health > Info`. Look for the "Server" section to verify the current values of:

- `upload_max_filesize` (Under Server as: Upload max filesize)
- `post_max_size`  (Under Server as: PHP post max size)
- `memory_limit`
- `max_execution_time`

If the settings did not apply from wp_config,  hosting provider or server configuration may override `@ini_set`.

Which is your server?.
- Nginx with CloudPanel? 
	- If using nginX, the php.ini actually overridden by CloudPanel settings because Vhost will refer to php settings at `fastcgi_param PHP_VALUE "{{php_settings}}";` , so edit your settings at cloudpanel config panel by going to CloudPanel → Settings → PHP Settings group:
	- See the settings:
	  ![](46xmwaA.png)
	- **For Nginx restart:** `sudo service nginx restart`
    
- Nginx without CloudPanel? 
	- Likely overridden either by your nginx central config file or any downstream website config files. Depending on your OS, in the case of Debian 12, the central config is:
	  `/etc/nginx/nginx.conf` and the downstreams are at `/etc/nginx/conf.d/` or `/etc/nginx/sites-enabled/`.
		- Nginx itself **cannot directly override PHP settings** like `post_max_size`, `memory_limit`, `max_execution_time`, or `upload_max_filesize`, as these are controlled by PHP. However, Nginx interacts with PHP through a FastCGI process (e.g., PHP-FPM), and it can **pass directives to PHP-FPM** using `fastcgi_param`. Eg.
		  ```
		  fastcgi_param PHP_VALUE "post_max_size=100M\n upload_max_filesize=100M\n memory_limit=256M\n max_execution_time=300";
			```
	- Another possibility is that php.ini is overriding. If that’s the case or you may want to test if that's the case, you want to edit the `php.ini.`
		- Figure out the path of php.ini by referring to [[PHP.ini where are you]]
		- You can place these settings **anywhere** in your `php.ini` file, but it's a good idea to group them together for easier management. If you're unsure, placing them at the bottom is fine.
		  
		```
		upload_max_filesize = 200M  
		post_max_size = 200  
		memory_limit = 256M  
		max_execution_time = 300  
		max_input_time = 300
		```


- Apache? Check Google (To be completed in this tutorial in the future)