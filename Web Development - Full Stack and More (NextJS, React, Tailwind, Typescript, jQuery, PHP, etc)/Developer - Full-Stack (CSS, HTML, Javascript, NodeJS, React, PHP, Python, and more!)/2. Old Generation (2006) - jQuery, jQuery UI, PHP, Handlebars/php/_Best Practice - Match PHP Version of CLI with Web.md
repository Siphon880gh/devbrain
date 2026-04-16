
The best practice is to make sure you're using the same PHP that gets called when running the `php` command in terminal and is used to render your php webpages

If the versions don't match you're going to run into problems when enhancing PHP by running command lines then expecting your PHP webpages to get those enhancements.

  - Make sure PHP matches on command line and web version
	  - At a php file:
	```
	<?php
	echo PHP_VERSION;
	```
	- Then view on web browser

	- Run the command line:
	```
	php --version
	```
	- Choose which version to stick to. For example, as of April 15th, there is no MongoDB driver for PHP 8.5 on Debian 12. However there is a MongoDB driver for PHP 8.2 on Debian 12. For that reason, I'd choose Debian 12 for both command line and php versions. 
		- To investigate whether a dependency such as MongoDB is available for one of your latest PHP versions, ask ChatGPT and include the dependency name, the PHP versions installed on your server (from `ls /usr/bin/php*` or the PHP version dropdown in CloudPanel), and mention the OS you are on (eg. Debian 12). Mongo is a good example because in the future you might choose MongoDB as your database while still using PHP. In addition to ChatGPT, you can also check what MongoDB-related PHP packages are available directly on Debian 12 by running `apt search php | grep -i mongodb`, since the package name usually includes both `mongodb` and the PHP version, such as `php8.2-mongodb/oldstable,oldstable,now 1.15.0+1.11.1+1.9.2+1.7.5-1 amd64`. You'd find out that there is no official php8.5-mongodb package for Debian 12 (Bookworm), but the latest php version that does have a mongodb package under Debian 12 is php8.2.
		- You'd install with `sudo apt install php8.2-mongodb` then verify it's installed with `php -m | grep mongodb`. When your PHP script file (eg. index.php or api.php) includes the Mongo driver like `$client = new MongoDB\Driver\Manager($uri)`, it should be no problem if per your selected PHP version, the path to Mongo exists after installing Mongo: `/etc/php/8.2/mods-available/mongodb.ini``
		- Setting the PHP version
			- If setting command line, eg. `sudo update-alternatives --set php /usr/bin/php8.2`
			- If setting web, depends on your setup. For cloudpanel, you dont have to edit anything manually - just select at dropdown:
			  ![[Pasted image 20260415044926.png]]
