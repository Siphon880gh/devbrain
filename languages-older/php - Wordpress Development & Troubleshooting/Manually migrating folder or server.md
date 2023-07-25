
It is not recommended to manually migrate (either server or moving folder path). You should use All-In-One WP Migration plugin.

But if you're already in the middle of migrating, here are the full steps:

---

You would have copied the codebase into another folder. You would have recreated the wp database and its tables.

Your database credentials may differ. The paths may differ and it's your database keeping track of the paths. The below sections are the solutions that should be done in order. 

---

Make sure username and password of your database is valid at wp_config.php:
```
define( 'DB_NAME', '....' );

/** Database username */
define( 'DB_USER', '....' );

/** Database password */
define( 'DB_PASSWORD', '....' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

```

---


Go into MySQL and find the options:
```
SELECT * FROM `wp_options` WHERE option_name="siteurl" OR option_name="home"
```

Then modify the option_value appropriately.  For example, you may have moved it into another folder
`https://www.site.com` => `https://www.site.com/site`

---

Now it's time to readjust the paths that Wordpress internally points to.

Get Update-Urls plugin to replace old path with new path
https://wordpress.org/support/plugin/update-urls/

In addition, you may want to set the new paths in your wp_config.php just in case:
```
define('WP_CONTENT_DIR', '/home/new/path/wp-content');

define('WP_PLUGIN_DIR', '/home/new/path/wp-content/plugins');
```

---


If update-urls doesn't seem enough, you may be tempted to export the wordpress database, run a search and replace, then import back in. Keep in mind CSV format will complain when you import back in because of character limit.


Here's a quick guide to do its job:

\>>
Here are a few steps to search and replace old paths in MySQL after moving a WordPress codebase:

1. Make a backup of your database before making any changes! This allows you to revert if something goes wrong.

2. Connect to the MySQL database using the mysql command or a tool like phpMyAdmin.

3. Search for the old path you want to replace. For example, to find instances of '/old/path/':

```sql
SELECT * FROM wp_posts WHERE post_content LIKE '%/old/path/%';
```

4. Once you've identified the rows that need to be changed, run an UPDATE query to replace the old path with the new one. For example:

```sql 
UPDATE wp_posts 
SET post_content = REPLACE(post_content, '/old/path/', '/new/path/') 
WHERE post_content LIKE '%/old/path/%';
```

5. Repeat this process for other tables that may contain the old path, such as wp_postmeta, wp_options, etc. 

6. Test everything to make sure the replacements worked and nothing is broken.

The key things to watch out for are making a backup first, searching to identify what needs to be changed, then running UPDATE queries to replace the old path with the new one. Go slowly and test frequently to avoid breaking things! Let me know if you have any other questions!


\>>
Here is an exhaustive list of things to search and replace when moving a WordPress site to a new path:

- wp_posts table
    - post_content - replace old URL with new URL
    - post_title - replace old URL with new URL
    - post_excerpt - replace old URL with new URL
    - guid - replace old URL with new URL
- wp_postmeta table
    - meta_value - replace old URL with new URL
- wp_options table
    - option_value - replace old URL with new URL for options like:
        - home
        - siteurl
        - upload_path
        - upload_url_path
        - blogupload_url
        - featured_images_url
- wp_comments table
    - comment_author_url - replace old URL with new URL
    - comment_content - replace old URL with new URL
- wp_links table
    - link_url - replace old URL with new URL
    - link_image - replace old URL with new URL
    - link_rss - replace old URL with new URL
- wp_usermeta table
    - meta_value - replace old URL with new URL
- wp_gdpr_requests table
    - request_text - replace old URL with new URL
- wp_eu_cookie_compliance_preferences table
    - consent_content - replace old URL with new URL
- Media library
    - Scan attachment URLs and replace old URL with new URL
- Theme files
    - Replace old URL with new URL in any hardcoded URLs
- Plugin files
    - Replace old URL with new URL in any hardcoded URLs
- .htaccess file
    - Update rewrite rules and redirects for new path
- XML sitemap
    - Regenerate sitemap with new URLs

So in summary, every table and file that contains a reference to the old URL needs to be searched and replaced with the new URL. Let me know if you need any clarification or have additional questions!