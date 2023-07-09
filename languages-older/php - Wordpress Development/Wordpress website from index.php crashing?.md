
Place this code before `define('WP_USE_THEMES', true)`

```
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

Visit the website again. It'll be a blank page giving you some PHP error. Read all the way to the right and it'll tell you what folder and file the error is from, and it could clue you in to which plugin is conflicting or problematic.

Then go into /wp-content/plugins with FTP and disable that plugin by renaming it by postfixing it with "-off" in the filename. Or disable from Wordpress Plugins dashboard.