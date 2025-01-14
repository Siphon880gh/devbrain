
Heredoc (available PHP4 and up) allows you to forgo having to escape quotes or mixing html with php start and php end tags in the same attribute value which looks confusing

Instead of:
```
<?php
$v = "?v=1";

<link href="index.css?v=<?php echo $v; ?>" rel="stylesheet">
<script src="index.js?v=<?php echo $v; ?>">
?>
```

  
You can have:
```
<?php
$v = "?v=1";

echo <<<cbust_ipad
<link href="index.css$v" rel="stylesheet">
<script src="index.js$v"></script>
cbust_ipad;
?>
```

Nicer in vs code or cursor ai color linting:
![](https://i.imgur.com/YCe0M5C.png)

Also nicer in future code maintenance when you glance for the assets being loaded from markup or you're adding another asset on a script or link tag