
## Problem:
I have a wordpress site at `/wp/main/` that's now moved to `/abc/wp/` Visiting `/abc/wp/` on the web browser it says page not found (a page not found message from wordpress). Visiting `/abc/wp/wp-admin` on the web browser, it's 404 message from the web browser

**Environment:**
On MAMP localhost server. You'll need to adjust these instructions to your particular setup (whether it's a remote server, etc)

## Solution

This is a classic “moved WP into a new subdirectory” issue. Two things usually break:
1. Your web server isn’t routing pretty URLs in the new subdirectory to index.php
2. WordPress thinks its URL is still the old path

Here’s a tight checklist to get you from 404 → working.

### 1. Rewriting URL

On MAMP (Apache), the **.htaccess** needs to be updated, and you have to make sure Apache allows `.htaccess` overrides.

#### If Apache

**Create (or replace) /Applications/MAMP/htdocs/abc/wp/.htaccess with:**

```
# /abc/wp/.htaccess
RewriteEngine On
RewriteBase /abc/wp/
RewriteRule ^index\.php$ - [L]

# pass everything that isn't a real file/dir to index.php
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /abc/wp/index.php [L]
```

**Make sure Apache lets .htaccess work:**

- Open: `/Applications/MAMP/conf/apache/httpd.conf`
- Ensure `LoadModule rewrite_module modules/mod_rewrite.so` is **not** commented.
- Find the `<Directory "/Applications/MAMP/htdocs">` block and make sure:
```
AllowOverride All
```
- Then File → Save
- Restart Apache (If on MAMP, restart from MAMP; otherwise restart from cli).

#### If Nginx

Two reliable patterns depending on how you map the files.

##### Pattern A — site root is the parent of /xny/wp (most common)

```
root /var/www/example.com;   # contains /xny/wp/index.php

location ^~ /xny/wp/ {
    index index.php index.html;
    try_files $uri $uri/ /xny/wp/index.php?$args;
}

# Generic PHP handler (adjust sock/version)
location ~ \.php$ {
    try_files $uri =404;
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    fastcgi_pass unix:/run/php/php8.2-fpm.sock;
}

# Optional: harden uploads
location ~* ^/xny/wp/wp-content/uploads/.*\.php$ { deny all; }
```

##### Pattern B — using `alias` for the subdir (only if you must)

```
location ^~ /xny/wp/ {
    alias /var/www/example.com/xny/wp/;
    index index.php index.html;
    try_files $uri $uri/ /xny/wp/index.php?$args;
}

# PHP handler compatible with alias
location ~ ^/xny/wp/.*\.php$ {
    include fastcgi_params;
    fastcgi_param SCRIPT_FILENAME /var/www/example.com/xny/wp/$fastcgi_script_name;
    fastcgi_pass unix:/run/php/php8.2-fpm.sock;
}

location ~* ^/xny/wp/wp-content/uploads/.*\.php$ { deny all; }
```


#### Testing

You can try visiting your website or `wp-admin/`. Chances are the pages appear unstyled as if the assets cant be found or it redirects to a page that can't be found (you can tell because there's a redirect url query). For example:
- At the wp-admin/ login page, I see it 404 on load-styles.php. It was using the OLD url
- Website is 404 on style.min.css and style.css and some font .woff2 etc

If this is the case, we are not done yet - proceed to next section.

### 2. Set Path for Wordpress

In `wp-config.php`:
```
define('WP_HOME', 'http://localhost:8888/abc/wp');  
define('WP_SITEURL', 'http://localhost:8888/abc/wp');  
define('RELOCATE', true);
```

And make sure in the right location of the file:
```
/* That's all, stop editing! Happy publishing. */  
  
define('WP_HOME',    'http://localhost:8888/xny/wp');  
define('WP_SITEURL', 'http://localhost:8888/xny/wp');  
define('RELOCATE', true);http://localhost:8888/xny/wp/wp-admin/admin.php?page=wpseo_dashboard  
  
/** Absolute path to the WordPress directory. */  
if ( ! defined( 'ABSPATH' ) ) {  
	define( 'ABSPATH', __DIR__ . '/' );  
}  
  
/** Sets up WordPress vars and included files. */  
require_once ABSPATH . 'wp-settings.php';
```

If you had it at the very bottom here, it would have errored out not finding the css, js, and load-styles.php. The key is to place it after `/* That's all, stop editing! Happy publishing. */` but not at the very bottom of the file if there are more code at the bottom.

And make sure you're not editing the wrong `wp-config.php` (WP could read another one higher up).

After the wp-config.php are set in, you should be able to access `wp-admin/` with no problem and nothing will be unstyled. Next we will make this solution permanent then undo the wpconfig.php:
1. Get **Better Search Replace (free) by WP Engine**
2. Go to **Tools → Better Search Replace**. 

Start replacing strings in the database with some caveats:
- Make sure DRY RUN is DISABLED (It likes to keep toggling back on whenever you perform a new search and replace)..
- Make sure to select all the tables. Otherwise if no table selected, it'll just say no matches!
  ![[Pasted image 20250917025119.png]]

Search and replace these (Adjust to your URLs):
- `http://localhost:8888/wp/main` -> `http://localhost:8888/abc/wp`
- `http://localhost:8888/wp/main/` -> `http://localhost:8888/abc/wp/`
- `/wp/main/` -> `/abc/wp/`
- `/wp/main` -> `/abc/wp`


Bad because you forgot to turn off DRY RUN (remember it likes to toggle back on for each new search):
![[Pasted image 20250917025917.png]]

Good because it replaced text!
![[Pasted image 20250917025930.png]]

ONCE you’ve fixed the database with the plugin, remove your entries from wp-config, or at least remove this line on RELOCATE, otherwise leaving it in could cause odd redirects:

### 3. Flush permalinks

You might need to perform this step

At `/wp-admin/` loads:
- Settings → Permalinks → Save (no changes needed)