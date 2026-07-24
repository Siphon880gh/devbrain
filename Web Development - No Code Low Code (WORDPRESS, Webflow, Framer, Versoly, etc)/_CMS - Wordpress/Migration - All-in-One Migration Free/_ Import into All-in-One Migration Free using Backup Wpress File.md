
Requirements:
- Wordpress already installed. Refer to [[_ PRIMER - Wordpress (Includes Setup)]]
	- You would have setup with the same database name, database user, and database password (all obtained from wp`-config.php` at the older website), and same title (view source), wordpress site username/password/email (credentials you used at `yourdomain.com/wp-login.php` or `yourdomain.com/wp-admin` and the emails at the left sidebar item `Users` ).
- Installed All-in-One Migration Free. Refer to [[Install Wordpress Migration All-in-One]]

At the Wordpress admin dashboard, go to left sidebar's All-in-One WP Migration -> Backups -> Import -> Import From -> File:
![[Pasted image 20260515025630.png]]

You'll confirm to proceed:
![[Pasted image 20260515030045.png]]

If your website and web server have been configured to handle large uploads, it should be able to reach 100% and show this:
![[Pasted image 20260515030135.png]]

->

100%

->

![[Pasted image 20260515030119.png]]


Either it errors that the file exceeds your site's upload size:
![[Pasted image 20260724041151.png]]
^ This is a php setting so Wordpress (A php framework) knows

Or just being stuck at a percent (silent failure):
![[Pasted image 20260724041050.png]]
^ This is at a htaccess or nginx level so Wordpress could not know

---

## Failed to upload?

If it's your first time, very likely your website and web server isn't ready. This is the problem with the free version - you have to go deep into your website and web server to configure it for large uploads! Paid version has a more streamlined restoring process that bypasses all that (See [[_ Import into All-in-One Migration Paid]]).

Refer to the error that stopped your restoration. There are various documents named after the errors in the same folder here. That will guide you on what to configure.

Or below is the quick guide on what to fix if you're on nginx server:

1. Get the file size of the wpress file that had been exported.
2. At server block listening to port 443, after {{settings}}, add:
```
    # All-in-One WP Migration Plugin: Needed for large WordPress uploads/imports at https layer
    client_max_body_size 512M;
```

3. Does server block listening to port 443 have a location sub-block to wp admin ajax? Then:
```
    location = /root/wp-admin/admin-ajax.php {
        client_max_body_size 512M;
    
        proxy_pass http://127.0.0.1:8080;
        // ...
```


4. Is server block listening to port 8080 where the real PHP processing occurs (especially with Cloudpanel)? A few steps

a. After the major top lines of code for the server listening to port 8080, add `client_max_body_size`:
```
server {
  listen 8080;
  listen [::]:8080;
  server_name wengindustries.com www.wengindustries.com wengindustry.com www.wengindustry.com;

  # All-in-One WP Migration Plugin: Needed for large WordPress uploads/imports at backend PHP layer
  client_max_body_size 512M;
```

b. At location sub-block `location ~ \.php$ {`, add fastcgi_param PHP_VALUE multiline. Make sure the new lines are added after `{{php_settings}}`, meaning you dont have to configure cloudpanel or whatever your panel is because the new lines will just override them
```  # Handle PHP requests
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
    fastcgi_param PHP_VALUE "{{php_settings}}
upload_max_filesize=4096M
post_max_size=4608M
max_input_time=7200
max_execution_time=7200
memory_limit=1024M";
```

c. Then **near the end of the sub-block** `location ~ \.php$ `:
```
    # All-in-One WP Migration Plugin: Needed for large WordPress uploads/imports at PHP handler too
    # We place at the very end of PHP request handling in case we need to override a setting in the CloudPanel expanded \{\{php_settings\}\}
    client_max_body_size 512M;
    }
```


5. Finally, feed the entire vhost into ChatGPT and ask if this works for uploads at whatever size your wpress file is. It will inform you what values to change in the vhost
6. Test importing. You may have to refresh the page because WP Migration All-in-One caches your file upload limit on the frontend

## If it reaches far then tells you:
![[Pasted image 20260724042203.png]]

## -> IT'S CLOUDFLARE


Are you on Cloudflare proxied domain? Free limits you to 100 MB on request, and upper tiers is 200 MB and 500MB+.
1. Disable Cloudflare only traffic if on Cloudpanel or follow your panel's equivalent setting. Security tab:
   ![[Pasted image 20260724043655.png]]

2. Force cloudflare off on your computer. No need to change server vhost or cloudflare settings. Edit with `sudo vi etc/hosts` file and add in:
```
# This line bypasses Cloudflare when opening the domain address on your computer:
X.XX.XXX.XXX wengindustries.com www.wengindustries.com
```

Then reset:
```
sudo dscacheutil -flushcache
sudo killall -HUP mDNSResponder
```

Then close out browser and revisit your wordpress URL (named domain, dont use IP)
   
> [!note] Editing your Mac’s `/etc/hosts` file bypasses Cloudflare **only for that Mac**.
> 
> Normally, this happens:
>
> ```
> Browser
 >   ↓
> Cloudflare DNS returns a Cloudflare IP
>    ↓
> Cloudflare proxy
>    ↓
> Your server: X.XX.XXX.XXX
> ```
>
> With this entry on your Mac:
>
> ```
> X.XX.XXX.XXX wengindustries.com www.wengindustries.com
> ```
> 
> the path becomes:
> 
> ```
> Browser
>    ↓
> Mac reads /etc/hosts instead of public DNS
>    ↓
> Your server directly: X.XX.XXX.XXX
> ```
> 
> Your browser still requests:
>
> ```
> https://wengindustries.com
> ```
>
> So it still sends the correct:
> 
> ```
> Host: wengindustries.com
> ```
>
> and uses `wengindustries.com` for HTTPS certificate validation. That is why you do **not** add `X.XX.XXX.XXX` to `server_name`.
>


Make sure to restrict back to only Cloudflare IP if that was you original settings