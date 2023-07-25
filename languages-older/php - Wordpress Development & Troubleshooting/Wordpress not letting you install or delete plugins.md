It either errors your FTP credentials are wrong or cannot create folder or cannot erase files/folders

---

When FTP fails for adding or deleting plugins at the Wordpress dashboard, it will ask you to provide FTP credentials information

Try this. XX.XX.XXX.XX is the numeric values
Create the user in cpanel. For example: wp
For username, try`wp@wengindustry.com` instead of `wp`

So the result is:
XX.XX.XXX.XX:21
wp@wengindustry.com
YOUR-PASSWORD
FTPS on

![](https://i.imgur.com/YYnnH14.png)

---

If it complains about unable to locate, or create, or delete, it's a file permission error.

![](https://i.imgur.com/EPGY5Zt.png)

Pretend that root is the folder of your wordpress codebase. Fix permissions:
```
cd root
chmod -R 755 .
chown -R bse7iy70lkjz:bse7iy70lkjz .
cd ../
chown -R bse7iy70lkjz:bse7iy70lkjz root
chmod -R 755 root
```

^ That follows user and group names. Mines happen to have the same name for both. To get your user:group:name's, create this php file and visit directly in the address bar:
```
<?php

// Get the user information
$userInfo = posix_getpwuid(posix_geteuid());
echo "Current User: " . $userInfo['name'] . "<br>";

// Get the group information
$groupInfo = posix_getgrgid(posix_getegid());
echo "Current Group: " . $groupInfo['name'] . "<br>";

?>
```

Fix wp_config. You may want FS_METHOD to be direct to minimize file permission problems in Wordpress dashboard. You can be explicit about the content directory and plugin directory (especially if you had moved files). At wp_config
```
define('FS_METHOD', 'direct');
define('WP_CONTENT_DIR', '/home/bse7iy70lkjz/public_html/root/wp-content');
define('WP_PLUGIN_DIR', '/home/bse7iy70lkjz/public_html/root/wp-content/plugins'); 
```

To stop it keep asking FTP credentials, you can at wp_config:
```
define('FTP_USER', 'wp@wengindustry.com');
define('FTP_PASS', 'YOUR-PASSWORD');
define('FTP_HOST', 'XX.XX.XXX.XX:21');
define('FTP_SSL', true);
```


---


If continues to fail, 

You want FTP debug information. At wp_config, adjust the path where you want the FTP logs:

```
// Enable FTP debugging
define('FTP_DEBUG', true);
define('FTP_LOG', '/home/bse7iy70lkjz/public_html/root/ftp-debug.log');
```


Check that FTP is enabled in your php.ini file. The allow_url_fopen setting needs to be set to On.

Get the php.ini file with either:
```
php -i | grep 'Loaded Configuration File'
```
or:
```
php --ini
```