AKA: Get Started

Purpose: Create wordpress from the standpoint of a developer trying to become more visual and understands there are opportunities in wordpress to leverage development with small business owners that go with wordpress, squarespace, etc

The developer: Understands may not be as talented with visual placement / styling. However will incorporate AI tools to assist with that.

How to use**: Recommend you open a screen-persistent Table of Contents so you can navigate this document more easily.

---


## Setup
### Setup Wordpress

1. Download WordPress: Visit the official WordPress website at https://www.wordpress.org and download the latest version of WordPress. Unzip the downloaded file on your computer.
2. Configure FTP: Use an FTP client (such as FileZilla) to connect to your server using the FTP account credentials provided to you. This allows you to transfer files between your computer and the server.
3. Upload WordPress files: Once connected via FTP, navigate to the root directory of your server (usually public_html or www). Upload all the files and folders from the unzipped WordPress folder to the root directory of your server.
4. Create a database: Most hosting providers offer a control panel (such as cPanel or WHM) where you can create a MySQL database. Locate the database section and create a new database. Make note of the database name, username, and password, as you'll need them during the WordPress installation process. You may want to prefix the table name like (wp_site1)
	1. You can run in SQL tab: `CREATE wp_site1`
	2. You can (make sure to have your password in place of 'password')
```
CREATE USER 'username'@'localhost' IDENTIFIED BY 'password';

```

```
GRANT ALL PRIVILEGES ON databasename.* TO 'username'@'localhost';

```

When prompted by the Wordpress wizard to enter your database name, username, password, etc, your database name should be like "wp_site1" even though your prefix setting is "wp_"

1. Configure wp-config.php: In the root directory of your server, find the file named "wp-config-sample.php" and rename it to "wp-config.php". Open the file in a text editor and enter the database information you obtained in the previous step (database name, username, and password).
2. Install WordPress: Open your web browser and enter the URL of your website. The WordPress installation wizard should start automatically. If it doesn't, make sure you have uploaded the files correctly or check the URL you entered.
3. Complete the installation: Follow the on-screen instructions to complete the WordPress installation. You'll need to provide details such as the site title, administrator username, password, and email address.
4. Log in and customize: Once the installation is complete, you can log in to your WordPress dashboard by appending "/wp-admin" to your website's URL (e.g., www.example.com/wp-admin). Use the administrator credentials you set up during the installation. From the dashboard, you can customize your website, install themes and plugins, and start creating content.

If setting up locally:
![](https://i.imgur.com/om4VcrU.png)
^ Yes, notice the wp_ is repeated twice. Yes you can do "localhost:3306"

And if using MAMP/LAMP/MAMP, you get the port like here:
![](https://i.imgur.com/OB1m57b.png)


If you get this message in the wordpress wizard after submitting your database creds, url, and database name - double check the above steps and check the phpmyadmin screenshots here:
![](https://i.imgur.com/I8nEv43.png)

![](https://i.imgur.com/vrJ97T7.png)

![](https://i.imgur.com/ZneB4qW.png)


And make sure your db creds have permission to this new database. Your phpmyadmin link may differ but go into the database -> Privileges:
[http://localhost:8888/phpMyAdmin5/index.php?route=/server/privileges&db=wp_wordpress-test&checkprivsdb=wp_wordpress-test&viewing_mode=db](http://localhost:8888/phpMyAdmin5/index.php?route=/server/privileges&db=wp_wordpress-test&checkprivsdb=wp_wordpress-test&viewing_mode=db)  

Then Try Again
### Setup for a website, not a blog service

WP by default shows your blogs. Change to a multipage/single page? Go to Settings -> Reading -> A static page (Rather than "Your latest posts")


## Setup Site builder inside wordpress

### See if you like the default Gutenberg

Go to left sidebar -> Pages -> Edit a webpage
It kicks you right into the default site builder Gutenberg:
![](https://i.imgur.com/VtQ9O0q.png)

You can quickly read how to use Gutenberg Site builder at [[Gutenberg Site Builder - PRIMER]]

Reworded:
Unless you get another site builder (WPBakery, Salient theme's Enhanced WPBakery, Nectarblock Site Builder, Elementor Site Builder): The default website builder in WordPress is the Gutenberg site builder. It was introduced in WordPress version 5.0 and is now the default content editor for creating and editing posts and pages.

### If choose to get a better site builder inside Wordpress:

But Gutenberg is not a good site builder and is considered dated. Refer to [[Wordpress Site Builders]] to install a better site builder.

---

## Fundamentals

### Editing Page

Edit live view:
Appearance -> Customize -> Additional CSS

Edit a page:
Pages → All Pages → See Your Page: Edit

View a page:
Pages → All Pages → See Your Page: View

---

### Editing Menu

Edit menu:
Appearance -> Menus

First step is select the menu you're editing at: "Select a menu to edit:". Same place to create a new menu

Second step is you can add menu items from the left sidebar. Usually you add custom links or Wordpress pages:

![](https://i.imgur.com/vZ8SWFx.png)


### Marketable blocks

Switch to adding HTML for a block (Block Editor):
Click a block -> Edit as HTML

Adding CSS or script from a block:
Go ahead and do ``<style>`` or ``<script>`` blocks inside a block
You can test:

```
<style>
body {
	background-color: blue;
}
</style>
```

- Or another HTML block (either wholly or partially):
```
<script>
alert("hi");
</script>
```

### Image block
Add -> Image. May upload or use Media Library(WP Dashboard's Media)

Customize header/footer
Tools -> Theme File Editor -> parts->header/footer

---

## Workflows

Workflows:
Duplicate a page so you can work on it without affecting live/production site. You can View or Edit from “All Pages”


---

## Migration Guides

### Migration - Designed wordpress into fresh wordpress copy

All-In-One Migration Plugin
https://wordpress.org/plugins/all-in-one-wp-migration/

^ Click download
Unzip and move into /wp-content/plugins

If this error:
![](https://i.imgur.com/Gk36O6t.png)

cd into the wp-content/plugins/

make folders ./all-in-one-wp-migration/storage and ./all-in-one-wp-migration/migration/storage

run commands to recursively change permissions:
```
chmod 0777 -R ./wp-content
chown root:root -R ./wp-content
```

Increase Wordpress upload limits php before importing... making sure first 3 settings are greater than your wpress file:

```
@ini_set( 'upload_max_filesize' , '128M' );
@ini_set( 'post_max_size', '128M');
@ini_set( 'memory_limit', '256M' );
@ini_set( 'max_execution_time', '300' );
@ini_set( 'max_input_time', '300' );
```


If it complains still, then the settings are not taking. Here are other ways.

Try going into CPanel or WHM. Like ...cpsess0787040780/scripts2/multiphp_ini_editor/basic?login=1&post_login=29735274873117

![](https://i.imgur.com/VO1nkh4.png)





```
1. **Using a Plugin**
    
    There are plugins available that can increase your upload size limit. However, if your server has hard limits, a plugin might not work. The All-in-One WP Migration plugin itself has an extension to increase the upload size, but it's paid.
    
2. **Contact Your Hosting Provider**
    
    Sometimes shared hosting providers impose server-side limits that you cannot override from within WordPress. In such cases, the most straightforward solution might be to contact your hosting provider and request an increase in file upload size.
    
3. **Check the "Media" in the Dashboard**
    
    Sometimes WordPress might show the allowed max upload size in the `Media` -> `Add New` section in the dashboard. If it's not reflecting the changes, then it's very likely server-side settings or restrictions preventing the change.
    
4. **MultiPHP INI Editor (cPanel)**
    
    If your hosting uses cPanel, you may have the option to use the MultiPHP INI Editor, which provides a graphical interface to change PHP settings:
    
    - Login to cPanel.
    - Under the "Software" section, click on "MultiPHP INI Editor".
    - Select the domain you're working on.
    - Adjust the values for: `upload_max_filesize`, `post_max_size`, `memory_limit`, `max_execution_time`, and `max_input_time`.

Remember, after making these changes, always clear your browser cache and restart your web server (if you have that capability) to ensure the changes take effect. If all else fails, consider breaking up your backup into smaller parts or using another migration method.
```


https://claude.ai/chat/8a0a6411-bc60-4758-ab9a-2515f644e556
https://chat.openai.com/c/38475d71-70ad-4f18-956b-8fc5260620fc

### Migration - localhost to remote server

Have the same wordpress database name for that website as the target server

Upload the same files to the target server. Suggestion: It would be slow through a FTP client. A possible workflow is upload only once to a folder that you won’t change.  Then every time you migrate another Wordpress, go into ssh terminal and run the cp command from that folder to the new folder.

Adjust the database, username, and password at wp-config.php

Migration problems? Change wp-config.php:
define( 'WP_DEBUG', true );
And you might get a message like:

### Migration Errors

**Access denied for user 'wff2'@'localhost' to database wp_expert_teams'**
Check your username and password match
Check if that user has permission to the database.

WHM or Control Panel not giving you the UI to check?

If you can ssh, run mysql shell with mysql -u wff2 -p then query for show databases; . What doesn't show up means your database user does not have permission to it.

You can grant permission. Since you are already root by going into SSH, then run without the user and pass flags by running in terminal: mysql
Then show databases; to confirm all databases
Then grant to the specific db user: GRANT ALL PRIVILEGES ON wp_expert_teams.* TO 'wff'@'localhost'
Or you can probably run GRANT ALL  at PHPMyAdmin. And vice versa, you could reveal the user to database permissions there with SQL query: SHOW GRANTS FOR 'wff'@'localhost';
Reworded (theoretical):
PHPMyAdmin way
You could reveal the database user's database permissions  with SQL query: SHOW GRANTS FOR 'wff'@'localhost';
Then you can grant all databases to that user: GRANT ALL PRIVILEGES ON wp_expert_teams.* TO 'wff'@'localhost'

**Situation causing error: URL keeps redirecting to another URL that was similar where Wordpress was previously stored at the old server / localhost**
While still in the wp-config.php file, you may also need to update the site URL. Look for the lines that define WP_HOME and WP_SITEURL and modify them to reflect your online server's URL (or add them if they aren't there).

WP_HOME: This constant defines the URL of your WordPress site's homepage (where wp-config.php is). It should include the full URL, including the protocol (e.g., http:// or https://). It is typically used to set the base URL for your site.
WP_SITEURL: This constant defines the URL of the WordPress core files. It is often the same as WP_HOME but can be different if, for example, you have installed WordPress in a subdirectory.

During a migration, you would typically update both WP_HOME and WP_SITEURL in the wp-config.php file to reflect the new online server's URL. Here's an example:

define('WP_HOME', 'https://www.example.com'); define('WP_SITEURL', 'https://www.example.com');

By setting both constants to the same URL, you ensure that WordPress correctly identifies the website's address and core file location.


### Key Activity Areas:

http://localhost:8888/weng/clients/prereq-wp-2023-05-30/wp-login.php

http://localhost:8888/weng/clients/prereq-wp-2023-05-30/wp-admin/


## Advanced

### Files/Database

In WordPress, the content of pages (and other types of content like posts, custom post types, and media) is primarily stored in a database. When you create a page or make changes to it, the content, along with other metadata like the title, author, date, and settings, is saved in the WordPress database.

The database stores this information in specific tables, typically using the MySQL database management system. WordPress organizes the content and related data in tables such as wp_posts, wp_postmeta, and wp_terms, among others. These tables maintain the structure and relationships between different elements of your WordPress site.

When a visitor requests a page, WordPress retrieves the relevant data from the database and dynamically generates the HTML output to display on the visitor's browser.

However, it's worth noting that the actual files of your WordPress site, including themes, plugins, and media uploads, are stored in the file system of your web server. These files are separate from the content stored in the database.

The files related to themes are stored in the "wp-content/themes" directory, plugins in the "wp-content/plugins" directory, and media uploads in the "wp-content/uploads" directory by default. These files, along with the core WordPress files, are necessary for the proper functioning and appearance of your website.

In summary, while the content of pages and other elements is stored in the WordPress database, the files related to themes, plugins, and media uploads are stored on the server's file system.