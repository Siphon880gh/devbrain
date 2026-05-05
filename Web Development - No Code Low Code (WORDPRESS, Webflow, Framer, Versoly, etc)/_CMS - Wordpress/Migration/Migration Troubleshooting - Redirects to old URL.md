
**Situation causing error: URL keeps redirecting to another URL that was similar where Wordpress was previously stored at the old server / localhost**
While still in the wp-config.php file, you may also need to update the site URL. Look for the lines that define WP_HOME and WP_SITEURL and modify them to reflect your online server's URL (or add them if they aren't there).

WP_HOME: This constant defines the URL of your WordPress site's homepage (where wp-config.php is). It should include the full URL, including the protocol (e.g., http:// or https://). It is typically used to set the base URL for your site.
WP_SITEURL: This constant defines the URL of the WordPress core files. It is often the same as WP_HOME but can be different if, for example, you have installed WordPress in a subdirectory.

During a migration, you would typically update both WP_HOME and WP_SITEURL in the wp-config.php file to reflect the new online server's URL. Here's an example:

define('WP_HOME', 'https://www.example.com'); define('WP_SITEURL', 'https://www.example.com');

By setting both constants to the same URL, you ensure that WordPress correctly identifies the website's address and core file location.