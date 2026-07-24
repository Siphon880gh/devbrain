## Exporting

At the Wordpress admin dashboard, go to left sidebar's All-in-One WP Migration -> Export
![[Pasted image 20260515025032.png]]

Export file:
![[Pasted image 20260515025941.png]]

## **Think ahead:**
You’ll be importing the new file to your new server. However, your server needs to have the correct settings to allow the import of one large file, and the default settings often aren’t enough.

If this expiring WordPress site had previously been imported, copy its `.htaccess` or vhost configuration to a safe location. You can then refer to those settings later when configuring the new site to accept imports. If you didn't, no worries - the import guide will go over errors you encounter when uploading single backup file.

But make sure to copy your credentials so you can setup the new server's wordpress without running problems later. At your old site, get the database name and wordpress username
- At `wp-config.php`:
```
define( 'DB_NAME', '***' );
define( 'DB_USER', '***' );
define( 'DB_PASSWORD', '***' );
```

Copy your Wordpress site login and the site title (Go to view source)

![[Pasted image 20260724030659.png]]

---

## Once ready, go to Importing

Importing guide at [[_ Import into All-in-One Migration Free using Backup Wpress File]]