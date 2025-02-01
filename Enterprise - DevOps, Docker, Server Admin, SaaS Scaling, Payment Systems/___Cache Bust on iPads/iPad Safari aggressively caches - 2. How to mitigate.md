What could crash your web app for visitors is caching differences of iPad Safari. iPad Safari insists on a stale js file despite letting your html or php changes thru. This mismatch could cause js errors that you don't get on another device

What's irritating is that iPad ignores your cache control header even if it orders the browser to get a new copy of js and css files

Doesn’t apply to: Apps controlled with webpack / react builder so that the bundled js filename is hashed or those controlled with service worker which is heavy on caching until you change the version number

Applies to: js/jquery files and you can afford to use php files (time to convert your html into php). If you must stick with html files then your solution is to use url query ?v=*** on your script and link assets despite it being problematic with git diff and future maintenance (php resolves that by having $v at each script and css link, and you change that $v value at one file)

iPad is very aggressive about caching even if I set the php or server to disable caching. 
To see why, refer to [[iPad Safari aggressively caches - 1. Why]]. This caching woe is valid so far into 12/24. 

---

Below are approaches to forcefully bust a cache on iPads. It usually involves changing the filename or the url to the file assets, and there is a seamless way to do so if you're using PHP that does not force you to make another commit, crowding the git diffs. Even if you are not on PHP, then you're gonna have to change the script and link url's and will have to crowd the git diffs.

A quick and dirty way is to use style and script blocks...
Or PHP-include the js and css files inside style and script blocks like so:
```
<style>
<?php include("assets/index.css"); ?>
</style>
<script>
<?php include("assets/index.css"); ?>
</script>
```
^ Neither approach is reasonable if you have a huge code base that you need to maintain in the future (too long of a HTML file, or quickly looking at asset files at the markup)

A quick and dirty way is to change the script[src] and link[href] by adding a version url query.
```
<script src="index.js?v=2">
```

Problem with that is it’s a headache when you have many HTML/php files that open asset files (js and css) and you’d have to change it for them all (especially if you have made many major updates and forgot which asset files have been changed). Another problem is if you keep up with git commits, it’s difficult to manage git commits when you’re at a point you perform code reviews and do git diffs and it’d show many files’ lines that are irrelevant to code reviews because of a simple url query change.

You can’t work around git issues by changing the url back to the original after some time (When you change the url to  script src=”index.js?=v2” it will load a new copy. But later you changed it back (for git repo etc): script src=”index.js” it will continue loading the old copy).

Even if git diff is not a concern, you could make that easier with sed search all and replace in files, but there’s a chance that could mess up and you wouldn’t know if a url query hasn’t been changed at a file.

A solution is to use PHP instead of HTML and with PHP you can have all webpages link to ONE php file that sets the version number, then you echo that version number in the url. But it looks messy:
- Say it’s just one file you have to change in multiple places
```
$version="1";
<link href="index.css?v=<?php echo $version; ?>" rel="stylesheet">
<script src="index.js?v=<?php echo $version; ?>">
```

- Say it’s multiple files you have to change, then:

FILE 1:
```
include("./cache-version.php");

<link href="index.css?v=<?php echo $version; ?>" rel="stylesheet">
<script src="index.js?v=<?php echo $version; ?>">
```

  
FILE 2:
```
include("./cache-version.php");

<link href="index.css?v=<?php echo $version; ?>" rel="stylesheet">
<script src="index.js?v=<?php echo $version; ?>">
```

  
cache-version.php:
```
$version="1";
```
^Now the problem is it looks messy. For maintaining future code if you want to quickly glance what the asset files are at markup file or add more asset files via link or script, there will be some mental resistance. That php phrase inside html line is jarring and does not aide in reading comprehension. 

PHP 4 and up supports a cleaner syntax with heredoc:

File 1, file 2, etc imports $v globally to cache bust on iPads Safari which have sticky cache. That $v is “?v=$version”, and you set $version at version-cache-bust.php at the top.

```
<?php include("./assets/version-cache-bust.php");
echo <<<cbust_ipad

  <link href="assets/index.css$v" rel="stylesheet">
  <link href="assets/common.css$v" rel="stylesheet">

cbust_ipad;
?>
```

  
If the same file may have multiple cbust_ipad, you could comment out or remove the include at the subsequent blocks:
```
<?php // include("./assets/version-cache-bust.php");
echo <<<cbust_ipad
  <script src="assets/index.js$v"><script>
cbust_ipad;
```


So the file could be:
```
<?php include("./assets/version-cache-bust.php");
echo <<<cbust_ipad

  <link href="assets/index.css$v" rel="stylesheet">
  <link href="assets/common.css$v" rel="stylesheet">

cbust_ipad;
?>
...
<?php
echo <<<cbust_ipad
  <script src="assets/index.js$v"><script>
cbust_ipad;
```

version-cache-bust.php:
```
<?php
// Change this to cache bust on iPad's Safari which has sticky cache.
$version = "1";

// Internal:
$v = "?v=$version";
?>
```

  
The coloring in VS Code / Cursor looks helpful too
![](YCe0M5C.png)
