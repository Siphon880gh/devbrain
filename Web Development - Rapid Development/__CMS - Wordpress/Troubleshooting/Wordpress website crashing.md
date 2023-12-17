
See what the errors are by placing this code before `define('WP_USE_THEMES', true)` at `index.php`:

```
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

Visit the website again. It'll be a blank page giving you some PHP error. Read all the way to the right and it'll tell you what folder and file the error is from, and it could clue you in to which plugin is conflicting or problematic.

Then go into /wp-content/plugins with FTP and disable that plugin by renaming it by postfixing it with "-off" in the filename. Or disable from Wordpress Plugins dashboard.

Why is this not on by default? Well if a wordpress site crashes, it may reveal sensitive info to a hacker how to penetrate deeper.

---

Note that there's an equivalent way of setting these options in `wp-config.php`