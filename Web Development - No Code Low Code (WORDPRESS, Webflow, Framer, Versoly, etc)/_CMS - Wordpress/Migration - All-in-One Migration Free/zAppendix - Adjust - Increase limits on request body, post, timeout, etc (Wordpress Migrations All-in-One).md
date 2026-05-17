
**How to use:**
- Turn on floating Table of Contents.

---

## Overview

You use the plugin to export a copy of your website and it'd be a wpress file.

Then when you upload/import the wpress file on the newer server or website, you may run into your upload being blocked because it either takes too long or it's too large a file. There are multiple layers that can block:
```
WordPress wp-config.php
PHP php.ini
PHP .user.ini
Apache .htaccess
Nginx client_max_body_size
Cloudflare's free plan limits you to 120 seconds and 100 mb.
```

If one layer still has a smaller upload or timeout limit, that smaller limit can override everything else and cause the restore/import to fail.

We will start by increasing the file size and timeout limits inside WordPress. We will choose limits that make sense based on the size of the backup file (recall that you exported or downloaded a full website backup using **All-in-One WP Migration**).

Then if changing the WordPress settings is not enough and the restore/import still fails, we would move on to the next layer in this guide. This may include PHP, Nginx/Apache, CloudPanel, or other server-level settings.

At every layer after Wordpress, you will use the **same limit values** you chose earlier. Do not blindly copy the sample numbers from this guide. The syntax may change from layer to layer because each system uses a different configuration language, such as PHP, Nginx, or Apache, but the actual limit numbers should stay consistent.

---
## 1. Wordpress Level with `wp-config.php`

### What are the Wordpress limits?
  
Go to the WordPress admin dashboard and navigate to `Tools > Site Health > Info`. Look for the "Server" section to verify the current values of:  
  
- `upload_max_filesize` (Under Server as: Upload max filesize)  
- `post_max_size`  (Under Server as: PHP post max size)  
- `memory_limit`  
- `max_execution_time`

This is much easier than fumbling around the wp-config.php because the settings may be scattered or overriding each other.

### Recommended Wordpress Limits as a Starting Point

When importing or migrating a WordPress site, especially with plugins like **All-in-One WP Migration**, you often need to increase upload limits.

For many WordPress migrations, use these limits at your wordpress website's root `wp-config.php`:

![](fqzPSOI.png)

- Place this above the line that says: `/* That's all, stop editing! Happy publishing. */`
```
// ** Needed with many migration plugins like All-in-One WP Migration ** //
@ini_set( 'upload_max_filesize', '512M' ); /* The key setting */
@ini_set( 'post_max_size', '512M' );
@ini_set( 'memory_limit', '1024M' );
@ini_set( 'max_execution_time', '600' );
@ini_set( 'max_input_time', '600' );
define( 'WP_MEMORY_LIMIT', '1024M' );
define( 'MAX_EXECUTION_TIME', 600);
```

If either the time limit is too low or the file is too large, it’d freeze at some percent or you get an error right away, depending on which level the limit hit first. 

The memory_limit should be larger than post_max_size, otherwise that will get stuck at some percent too

### Limit formula including memory limit:
- There are practical sizing rules that work well for WordPress migrations.
	- upload_max_filesize >= .wpress file size  
	- post_max_size >= upload_max_filesize  
	- memory_limit = 2x to 4x the .wpress file size  
	- 1024M etc for memory_limit is just easy to think about because it maps to a common memory sizes (1024 megabytes = 1GB, 512M = 0.5GB)  

### Deciding the Limits

The limits are going to depend on how fast your server is and how large the migration wpress file was.

600 seconds is 10 mins and that covers 512M quite well on 2 VCPU 8gb 80 disk local CCX13 on Hetzner while only 3% cpu is being used and no traffic

A single page scrolling website that's basically my developer portfolio was 265MB already (The same plugin exported this file):
![[Pasted image 20260517014940.png]]

That will upload / import just fine.
### Verifying the configurations have applied

Go to the WordPress admin dashboard and navigate to `Tools > Site Health > Info`. Look for the "Server" section to verify the current values of:

- `upload_max_filesize` (Under Server as: Upload max filesize)
- `post_max_size`  (Under Server as: PHP post max size)
- `memory_limit`
- `max_execution_time`

### **Proceed to testing:**

After adjusting the WordPress limits, test the import again.

Try restoring/importing the backup file and see if it completes successfully. If the import works, you do not need to edit any deeper server settings. We can stop here.

If the import still fails, then move on to the next layer. Use the same file size and timeout values you already decided on instead of randomly copying sample numbers from the guide.

---
## 2. PHP directory level with `.user.ini`

Create or edit a `.user.ini` file in your WordPress root directory.

For example
`/home/example/htdocs/domain.com/wordpress-multisite1/.user.ini`

Add:
```
upload_max_filesize = 512M
post_max_size = 512M
memory_limit = 1024M
max_execution_time = 600
max_input_time = 600
```

### Why `.user.ini` Works

`.user.ini` works because PHP can load per-directory PHP settings from a `.user.ini` file when PHP is running through setups like:
```
PHP-FPM
FastCGI
CGI
LiteSpeed / LSAPI
some Nginx + PHP-FPM setups
```

Important: `.user.ini` changes may not apply instantly. PHP may cache `.user.ini` settings for a few minutes. You can wait a few minutes or restart PHP-FPM:
Eg. `sudo systemctl restart php8.2-fpm`

### **Proceed to testing:**

After adjusting the PHP directory limits, test the import again.

Try restoring/importing the backup file and see if it completes successfully. If the import works, you do not need to edit any deeper server settings. We can stop here.

If the import still fails, then move on to the next layer. Use the same file size and timeout values you already decided on instead of randomly copying sample numbers from the guide.

---
## 3. PHP global level with `php.ini`

If restoring still fail, let's now edit at the PHP global level, usually at a `php.ini`.

You could have several versions of PHP. This is the case if multiple php version paths exist on your server:
- /usr/bin/php7.1
- /usr/bin/php7.2
- /usr/bin/php7.3
- /usr/bin/php7.4
- /usr/bin/php8.0
- /usr/bin/php8.1
- /usr/bin/php8.2
- /usr/bin/php8.3
- /usr/bin/php8.4
- /usr/bin/php8.5
- And so on...

Not sure which version?  

In terminal you can determine the version of php that would run if scripts run php on the behalf of the server or app - run this command `php --version`. The problem is that it might not be the same php version that's rendering your .php files for visitors to your website.

There are two ways to find out the web php version
- Option 1 - Create a custom secret php file and echo the web php version:
	```
	<?php
	echo phpversion();
	?>
	```
	Then visit that secret url for the web php version
- Option 2 - Wordpress dashboard's Tools -> Site Health can also tell you PHP version

You want the CLI php to match the web php to prevent future conflicts when you need to have web app logic that works on the web and as executable scripts that run in the background. It also helps prevent having to keep track of two sets of configurations. You can do that here: [[_Best Practice - Match PHP Version of CLI with Web]]

Next you edit the php settings. You have two options
- Option 1 - Edit manually at `php.init`
  Add lines or update the web `php.ini`:
	- Recommended you just add it to the very bottom that way it can just override all the previous scattered around settings
	- While `/usr/bin/php8.2` is the executable path, the config path we need looks like: `/etc/php/8.2/fpm/php.ini` (PHP-FPM aka FastCGI Process Manager) or `/etc/php/8.2/apache2/php.ini` (Apache's mod_php)
	```
	upload_max_filesize = 512M
	post_max_size = 512M
	memory_limit = 1024M
	max_execution_time = 600
	max_input_time = 600
	```
	
	Restart PHP service after editing and saving.
	- If PHP-FPM:
	  Eg. `sudo systemctl restart php8.2-fpm`
	- If mod_php (Apache):
	  Eg. `sudo systemctl restart apache2`
- Option 2 - Go through web panel.

	If on CPanel or WHM, etc. Like ...cpsess0787040780/scripts2/multiphp_ini_editor/basic?login=1&post_login=29735274873117, lets you see and edit the PHP settings more easily:
	
	![](VO1nkh4.png)

	If on CloudPanel, go to "Settings" tab for your website, and scroll down to find the PHP Settings:
	![](46xmwaA.png)

### **Proceed to testing:**

After adjusting the PHP global limits, test the import again.

Try restoring/importing the backup file and see if it completes successfully. If the import works, you do not need to edit any deeper server settings. We can stop here.

If the import still fails, then move on to the next layer. Use the same file size and timeout values you already decided on instead of randomly copying sample numbers from the guide.


---

## 3a. If on Apache server, edit `.htaccess`

For Apache servers, you may also be able to increase limits from the WordPress `.htaccess` file.

Edit the `.htaccess` file in your WordPress root directory:
For example:
`/home/example/htdocs/domain.com/wordpress-multisite1/.htaccess`

Add:
```
# Needed with many migration plugins like All-in-One WP Migration
php_value upload_max_filesize 512M
php_value post_max_size 512M
php_value memory_limit 1024M
php_value max_execution_time 600
php_value max_input_time 600
```


This usually only works when Apache is running PHP through **mod_php**.

If your server uses PHP-FPM, these `.htaccess` `php_value` lines may not work and can even cause a **500 Internal Server Error**. If that happens, remove those lines and use `php.ini` or `.user.ini` instead (next sections).

Apache is really good at instantly using directory level .htaccess settings, but if you want to be sure, you can run:
```
sudo systemctl restart apache2
```

### **Proceed to testing:**

After adjusting the Apache limits, test the import again.

Try restoring/importing the backup file and see if it completes successfully. If the import works, you do not need to edit any deeper server settings. We can stop here.

If the import still fails, then move on to the next layer. Use the same file size and timeout values you already decided on instead of randomly copying sample numbers from the guide.

---

## 5b. If on Nginx server

Between Apache and Nginx, Nginx has the most configuration and gotchas you have to work with.

For Nginx, the important setting is:
```
client_max_body_size 512M;
```

This controls the largest request body Nginx will accept before WordPress or PHP even sees it.

Depending on your vhost, you may need to copy that setting to multiple places

For example, Cloudpanel has a backend `8080` server block, so you must also place `client_max_body_size 512M;` there.

And you may need to place the setting at the PHP location (URL location) if needed.

Your configuration might differ. Use this as a guide:
**Front `80/443` Server Block**
```
server {
  listen 80;
  listen [::]:80;
  listen 443 ssl;
  listen [::]:443 ssl;

  server_name domain.com www.domain.com;

  # Needed for large WordPress uploads/imports before proxying to backend
  client_max_body_size 512M;

  # rest of config...
}
```

**Backend `8080` Server Block**
```
server {
  listen 8080;
  listen [::]:8080;

  server_name domain.com www.domain.com;

  # Needed for large WordPress uploads/imports at backend PHP layer
  client_max_body_size 512M;

  root /home/example/htdocs/domain.com;
  index index.php index.html index.htm;

  location / {
    try_files $uri $uri/ /index.php?$query_string;
  }

  location ~ \.php$ {
    include fastcgi_params;
    fastcgi_intercept_errors on;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;

    try_files $uri =404;

    fastcgi_read_timeout 3600;
    fastcgi_send_timeout 3600;

    fastcgi_pass 127.0.0.1:9000;

    client_max_body_size 512M;
  }
}
```
^ At the `8080` server block, we have placed `client_max_body_size` in two places. Can you find them?

At either server blocks: Is 512M the limit you chose at the other layers? Make sure it stays consistent with the earlier layers we've configured.

Restart nginx with:
```
sudo nginx -t
sudo systemctl reload nginx
```
Or if your server supports the single command: `sudo nginx -s reload`

**Test if importing passes**
Fails?

### Nginx other settings


Make sure nginx doesn’t have vhost lowering the timeout that you have intended, eg

Look for them existing and if they do, bump it up as necessary. They’re in seconds:
```
    fastcgi_read_timeout 3600;
    fastcgi_send_timeout 3600;
```

```
    proxy_connect_timeout      720;
    proxy_send_timeout         720;
    proxy_read_timeout         720;
```

Restart nginx with:
```
sudo nginx -t
sudo systemctl reload nginx
```
Or if your server supports the single command: `sudo nginx -s reload`

**Test if importing passes**
Fails?

### Nginx for `domain.com/wordpress-multisite1`

Add location sub-block to 80/443 server block(s):
```
location /wordpress-multisite1/ {
    client_max_body_size 512M;

    try_files $uri $uri/ /multisite1/index.php?$query_string;
}
```

Warning: Do **not** use `^~` for the `/wordpress-multisite1/` location unless you also create a separate PHP handler for `/wordpress-multisite1/*.php`, because `^~` can prevent the regex PHP block from catching PHP files.

Restart nginx with:
```
sudo nginx -t
sudo systemctl reload nginx
```
Or if your server supports the single command: `sudo nginx -s reload`

**Test if importing passes**
Fails?

### Nginx PHP Handler

Append to the bottom of your PHP handler so it overrides any previous setting (you may have Cloudpanel multiline settings variable):
```
location ~ \.php$ {
    # ...

    # All-in-One WP Migration Plugin: Needed for large WordPress uploads/imports at PHP handler too
    # We place at the very end of PHP request handling in case we need to override a setting in the CloudPanel expanded \{\{php_settings\}\}
    client_max_body_size 512M;
}
```

Restart nginx with:
```
sudo nginx -t
sudo systemctl reload nginx
```
Or if your server supports the single command: `sudo nginx -s reload`

**Test if importing passes**
Fails? Then continue to next layer

---
## Are We On Cloudflare?

Cloudflare is great for protection, caching, and hiding your origin IP, but it also has proxy limits. 

For example, Cloudflare’s Free/Pro upload limit is **100 MB**, and long requests can hit timeout limits (**120 second** proxy read timeout). This is often not enough for Wordpress Migrations All-in-One because a simple one page scroller portfolio for a web developer is already over 250mb.

**Switch your Cloudflare DNS record from proxy to DNS-only so that this limit does not get in your way.**

> [!note] Concern - IP Hiding Goes Away
> You may be concerned that your VPS or dedicated server IP could end up on a botnet list and get attacked directly through scraping or DDoS attempts. This is especially concerning if your server has been attacked before.
>
> Even if you block unwanted traffic at the Linux firewall level, that does not always solve the problem. A `403 Forbidden` response does not necessarily stop bots from recording your IP and continuing to target it later. This would overwhelm your server's CPU and get your website to crash or even be flagged by removal by your web host (despite the CPU hits are from firewall denying the incoming traffic, because the sheer volume of incoming traffic to process and block can still overwhelm your CPU)
>
> - If your host supports a **floating IP**, use the floating IP instead of your original VPS or dedicated server IP. That way, if the floating IP gets targeted, you can swap it out later. Be careful not to expose the original server IP, because the original IP may still work even while the floating IP is active.
>
> - If you have a **throwaway domain** (especially as an entrepreneur, you likely will have a few domains you haven't developed or promoted yet), you can temporarily use it during migration. Since the domain has not been publicly shared, it is much less likely or ever to be detected and placed on a botnet’s scrape or attack list, unless the domain is some common phrasing or wording since there are bots that guess domain names.
>
>   However, if you use a temporary domain, you may need to update WordPress’ domain/URL settings. See [[Wordpress - Had changed URL or domain]]. After the migration is complete, you can reverse the changes:
>
>   - Point the DNS record back to the original domain.
>   - Turn Cloudflare Proxy back on.
>   - Change the WordPress URL settings back to the final intended domain.
Then you have to wait for the DNS-only to take effect. Could take a few minutes

### Confirm and confirm that DNS-only is really bypassing Cloudflare

From your local computer:
```
dig +short wengindustries.com
```

You should see your **actual server IP**, not Cloudflare IPs.

Cloudflare IPs often start with ranges like:
```
104.x.x.x
172.64.x.x
188.114.x.x
```

If it still returns Cloudflare IPs, your DNS change has not fully taken effect locally yet. Try incognito, flush DNS, or connect directly through the server IP/origin hostname.

Also make sure no AAAA records proxying to the Ipv6. You can remove them or turn them to DNS. Add them back in after this is done. Or you can temporarily take off AAAA by pointing them to officially recognized dummy IPs: `100::`. The AAAA is another potential fail point so we remove or disable it for now.

**Worried about exposing your VPS/Dedicated server's IP address when temporarily switching Cloudflare to DNS?**

Skip if no worried or you feel hackers won't find your IP right away (especially if you haven't been on an attack list before - botnet that automatically attacks / scrapes and overwhelms your server CPU as soon as your web server is online)

Because once hackers put your VPS' IP into their botnet, you'll automatically be attacked forever even if you place Cloudflare back onto proxy.

Some options:
- Add a floating IP to your server in the mean time, then switch back. Only ever point to that floating IP (never the original IP).
- Tunnel your Wordpress site to a custom port at your local machine like localhost:5000. You can temporarily remove the A record AND the AAAA records (they will get in the way) at Cloudflare. Or you can use official dummy IPs `192.0.2.1` and `100::` for the DNS records at Cloudflare.

**Once confirmed:**

Proceed to test Wordpress All-in-one Migration

---

## Nginx Last Resort - Central Configurations
- Instead you edit at the central config file for nginx:
  ```
	sudo vi /etc/nginx/nginx.conf
	```
- Look for `client_max_body_size` (Hint, for vim, typing '/' lets you type your search words, then you press enter to jump to match)
- You can set to 64M, or 128M, or 512M by convention (you can set to any megabytes actually):
  ```
  client_max_body_size 512M;
	```
- Test syntax with `sudo nginx -t`, but reload nginx with: `sudo service nginx reload` or `sudo nginx -s reload` (if system supports it)


---

## Nginx Last Resort - More Configurations
All-in-One WP Migration import AJAX - Bypass Varnish/proxy buffering

If none of the above works and you’re on Nginx, then consider adding:
At your main 443 server block a location sub-block that adjusts the limits at the wordpress endpoint

```
    location = /root/wp-admin/admin-ajax.php {
        client_max_body_size 512M;
    
        proxy_pass http://127.0.0.1:8080;
    
        proxy_set_header Host $host;
        proxy_set_header X-Forwarded-Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto https;
    
        proxy_redirect off;
    
        proxy_connect_timeout 1200;
        proxy_send_timeout 1200;
        proxy_read_timeout 1200;
        send_timeout 1200;
    
        proxy_buffering off;
        proxy_request_buffering off;
    }
```

At your 8080 PHP server block, adjust the limits at the URL path level (in case of conflicts):
Adjust path to wordpress
```
  # MAYBE: All-in-One WP Migration Plugin: Needed for large WordPress uploads/imports at backend PHP layer
  location /WP_PATH/ {
    client_max_body_size 512M;

    try_files $uri $uri/ /root/index.php?$query_string;
  }

```


---

## **Appendix**
Difference Between `upload_max_filesize`, `post_max_size`, and `client_max_body_size`?

Refer to [[zAppendix - About - Difference Between upload_max_filesize, post_max_size, and client_max_body_size]]