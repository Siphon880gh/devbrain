
```
**Fatal error**: Array and string offset access syntax with curly braces is no longer supported in **/home/wengindustries/htdocs/wengindustries.com/app/exrx-searcher/assets/php/includes/phpQuery/phpQuery/phpQueryObject.php** on line **1059**
```

It works on one php environment (eg. computer), but not remote environment (eg. remote server)

PHP has removed curly brackets support on PHP 8.

If on Cloudpanel, you can roll back the php version! Roll back to PHP 7.4 Refer to [[CloudPanel - Change PHP Version]]