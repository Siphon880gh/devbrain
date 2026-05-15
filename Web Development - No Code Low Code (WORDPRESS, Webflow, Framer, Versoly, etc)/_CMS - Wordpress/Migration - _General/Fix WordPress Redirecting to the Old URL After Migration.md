## Situation

After moving a WordPress site to a new server, domain, or hosting account, the website may keep redirecting to an old URL.

For example, you may see WordPress redirect to:

```text
http://localhost
http://127.0.0.1
https://old-domain.com
https://old-server-domain.com
```

This often happens when WordPress still thinks the site lives at the old address. During a migration, WordPress may still have the previous URL stored in its configuration or database.

A common fix is to set the correct site URL directly inside `wp-config.php`.

WordPress officially supports defining `WP_HOME` and `WP_SITEURL` in `wp-config.php`. These values override the corresponding `home` and `siteurl` values from the WordPress database, which can help recover a site that is redirecting to the wrong place. ([WordPress Developer Resources](https://developer.wordpress.org/apis/wp-config-php/?utm_source=chatgpt.com "wp-config.php – Common APIs Handbook"))

---

# Fix: Update `WP_HOME` and `WP_SITEURL` in `wp-config.php`

Open your WordPress `wp-config.php` file.

This file is usually located in the root folder of your WordPress installation, near files and folders like:

```text
wp-config.php
wp-admin/
wp-content/
wp-includes/
```

Look for existing lines like this:

```php
define( 'WP_HOME', 'https://old-domain.com' );
define( 'WP_SITEURL', 'https://old-domain.com' );
```

If they exist, update them to your new website URL.

If they do not exist, add them manually.

Place them above this line:

```php
/* That's all, stop editing! Happy publishing. */
```

Example:

```php
define( 'WP_HOME', 'https://www.example.com' );
define( 'WP_SITEURL', 'https://www.example.com' );
```

Use your real domain instead of `example.com`.

Do **not** add a trailing slash at the end.

Correct:

```php
define( 'WP_HOME', 'https://www.example.com' );
define( 'WP_SITEURL', 'https://www.example.com' );
```

Avoid:

```php
define( 'WP_HOME', 'https://www.example.com/' );
define( 'WP_SITEURL', 'https://www.example.com/' );
```

WordPress documentation notes that these URLs should include the protocol, such as `http://` or `https://`, and should not end with a trailing slash. ([WordPress Developer Resources](https://developer.wordpress.org/advanced-administration/wordpress/wp-config/?utm_source=chatgpt.com "Editing wp-config.php – Advanced Administration Handbook"))

---

# What `WP_HOME` Means

`WP_HOME` defines the public homepage URL of your WordPress site.

This is the address visitors should type into the browser to reach your website.

Example:

```php
define( 'WP_HOME', 'https://www.example.com' );
```

In most normal migrations, this should be your live domain.

For example, if your site is now supposed to load at:

```text
https://www.example.com
```

Then `WP_HOME` should be:

```php
define( 'WP_HOME', 'https://www.example.com' );
```

WordPress describes this as the “home” address, meaning the URL people use to reach the site. Defining it in `wp-config.php` overrides the `home` value from the database but does not permanently change the database value. ([WordPress Developer Resources](https://developer.wordpress.org/apis/wp-config-php/?utm_source=chatgpt.com "wp-config.php – Common APIs Handbook"))

---

# What `WP_SITEURL` Means

`WP_SITEURL` defines the URL where the WordPress core files are located.

In most standard WordPress installs, this is the same as `WP_HOME`.

Example:

```php
define( 'WP_SITEURL', 'https://www.example.com' );
```

However, it can be different if WordPress is installed in a subdirectory.

For example, if visitors go to:

```text
https://www.example.com
```

but the WordPress files are inside:

```text
https://www.example.com/wordpress
```

then your configuration may look like this:

```php
define( 'WP_HOME', 'https://www.example.com' );
define( 'WP_SITEURL', 'https://www.example.com/wordpress' );
```

For most simple migrations, though, both values are the same:

```php
define( 'WP_HOME', 'https://www.example.com' );
define( 'WP_SITEURL', 'https://www.example.com' );
```

WordPress defines `WP_SITEURL` as the address where the WordPress core files reside. Setting it in `wp-config.php` overrides the database `siteurl` value. ([WordPress Developer Resources](https://developer.wordpress.org/advanced-administration/wordpress/wp-config/?utm_source=chatgpt.com "Editing wp-config.php – Advanced Administration Handbook"))

---

# Why This Fixes Redirect Problems

WordPress uses the site URL values to decide where the website should load from.

If those values still point to the old server, old domain, or `localhost`, WordPress may keep redirecting you away from the correct domain.

This can cause problems like:

```text
New domain redirects to old domain
Live site redirects to localhost
Login page keeps refreshing
Admin dashboard redirects to the old URL
Website says password is wrong or simply reloads the login page
Too many redirects error
```

By adding the correct values to `wp-config.php`, you force WordPress to use the new live URL.

Example:

```php
define( 'WP_HOME', 'https://www.example.com' );
define( 'WP_SITEURL', 'https://www.example.com' );
```

This is especially useful after moving WordPress from:

```text
localhost
```

to:

```text
https://www.example.com
```

or from an old server/domain to a new server/domain.

---

# Important Note

Setting `WP_HOME` and `WP_SITEURL` in `wp-config.php` hard-codes the site URL.

That means WordPress will use these values even if the database has something different.

This can be helpful for fixing a broken migration, but it also means the URL fields in the WordPress dashboard may no longer be editable from:

```text
Settings > General
```

WordPress notes that this method is not always the best permanent fix because it hard-codes the URL into the site configuration. ([WordPress Developer Resources](https://developer.wordpress.org/advanced-administration/upgrade/migrating/?utm_source=chatgpt.com "Migrating WordPress – Advanced Administration Handbook"))

For a quick migration repair, it is a good troubleshooting step. Later, once the site is stable, you can decide whether to keep the constants in `wp-config.php` or update the database values directly.

---

# Final Example

For a normal WordPress site now hosted at:

```text
https://www.example.com
```

add this to `wp-config.php`:

```php
define( 'WP_HOME', 'https://www.example.com' );
define( 'WP_SITEURL', 'https://www.example.com' );
```

Place it above:

```php
/* That's all, stop editing! Happy publishing. */
```

After saving the file, reload the website and try logging into WordPress again.

If WordPress was redirecting because it still remembered the old URL, this should force it to use the new live domain.