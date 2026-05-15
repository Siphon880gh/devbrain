If you change the domain name or URL for a WordPress site, you also need to update the WordPress settings internally. Otherwise, WordPress may still try to use the old domain, which can cause problems such as:

- Login page constantly refreshing
- Login redirect loops
- “Incorrect password” errors even with the correct password
- Admin dashboard not loading
- Pages redirecting to the old domain
- Broken images, CSS, or links

This happens because WordPress stores the site URL in its configuration and database, not just in DNS or your hosting panel.

For example:

```txt
Old domain:
https://oldsite.com

New domain:
https://newsite.com
````

Even if DNS already points to the new server/domain, WordPress may still internally think the site is:

```txt
https://oldsite.com
```

So after changing domains, make sure to also update:

- WordPress Address (URL)
    
- Site Address (URL)
    
- Database references to the old domain
    
- SSL configuration
    
- Cache/CDN settings
    

Otherwise, you can end up with redirect and authentication issues that look like the site is “broken,” when it is really just still referencing the old URL internally.

---

## Method 1 — Change It from WordPress Admin

If you can still log in:

1. Go to **Settings → General**
    
2. Change:
    
    - **WordPress Address (URL)**
        
    - **Site Address (URL)**
        
3. Save changes.
    

Example:

```txt
Old:
http://oldsite.com

New:
https://newsite.com
```

---

## Method 2 — Change It in `wp-config.php`

If the site redirects incorrectly or you cannot log in:

Edit:

```txt
wp-config.php
```

Add this, but first make sure there are no existing `WP_HOME` or `WP_SITEURL` lines:

```php
define('WP_HOME', 'https://newdomain.com');
define('WP_SITEURL', 'https://newdomain.com');
```

Place it above:

```php
/* That's all, stop editing! */
```

This forces WordPress to use the new domain.

---

## Method 3 — Change Directly in the Database

This is useful if the domain is badly broken.

In phpMyAdmin or MySQL:

```sql
UPDATE wp_options
SET option_value = 'https://newdomain.com'
WHERE option_name IN ('siteurl', 'home');
```

You can also manually edit:

```txt
wp_options
```

Rows:

- `siteurl`
- `home`

---

## Important: Replace Old Domain References

After changing the main URL, old links may still exist inside:

- posts
    
- images
    
- menus
    
- Elementor pages
    
- serialized data
    

Use a safe search/replace tool.

### WP-CLI

```bash
wp search-replace 'https://old.com' 'https://new.com'
```

### Plugin

Popular plugin:

- Better Search Replace
    

---

## Important DNS / Hosting Steps

You also usually need:

### 1. Point DNS

At your domain registrar, add:

```txt
A record -> server IP
```

Or:

```txt
CNAME -> hostname
```

---

### 2. Add the Domain in Hosting Panel

Examples:
- CloudPanel
- cPanel
- Hostinger

Add the new domain before switching URLs.

---

### 3. SSL Certificate

If using HTTPS:
- Install a new SSL certificate
- Update Cloudflare SSL mode if applicable

---

## Typical Domain Change Flow

```txt
1. Point DNS
2. Add domain to hosting
3. Install SSL
4. Change WP URLs
5. Run search-replace
6. Clear caches/CDN
```

---

## If WordPress Keeps Redirecting to the Old Domain

Usually caused by:
- cached redirects
- `.htaccess`
- hardcoded URLs
- Cloudflare cache
- plugins
- database values not updated

Common fix:

```bash
wp cache flush
```

Then clear:
- browser cache
- CDN cache
- plugin cache