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
CREATE USER 'username'@'host' IDENTIFIED BY 'password';

```
^ Make sure to replace username and password

```
GRANT ALL PRIVILEGES ON *.* TO 'username'@'%' WITH GRANT OPTION;
```
^ Make sure to replace username. The % means allow from any IP address or hostname. If that doesn't serve your needs, you can secure it by replacing `%` with `localhost`

Flush the privileges to ensure the changes take effect immediately:
```
FLUSH PRIVILEGES;
```


When prompted by the Wordpress wizard to enter your database name, username, password, etc, your database name should be like "wp_site1" even though your prefix setting is "wp_"

1. Configure wp-config.php: In the root directory of your server, find the file named "wp-config-sample.php" and rename it to "wp-config.php". Open the file in a text editor and enter the database information you obtained in the previous step (database name, username, and password).
2. Install WordPress: Open your web browser and enter the URL of your website. The WordPress installation wizard should start automatically. If it doesn't, make sure you have uploaded the files correctly or check the URL you entered.
3. Complete the installation: Follow the on-screen instructions to complete the WordPress installation. You'll need to provide details such as the site title, administrator username, password, and email address.
4. Log in and customize: Once the installation is complete, you can log in to your WordPress dashboard by appending "/wp-admin" to your website's URL (e.g., www.example.com/wp-admin). Use the administrator credentials you set up during the installation. From the dashboard, you can customize your website, install themes and plugins, and start creating content.

If setting up locally:
![](https://i.imgur.com/om4VcrU.png)
^ Yes you can do "localhost:3306". 
^ Yes, notice the wp_ is repeated twice. That can cause confusion. It isn't erroneous though. But maybe you should keep it blank. For more information, refer to [[_ Wordpress - Multiple wordpress websites sharing the same database]]

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


## Setup Site builder inside Wordpress

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