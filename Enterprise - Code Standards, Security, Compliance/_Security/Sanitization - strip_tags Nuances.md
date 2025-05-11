
`strip_tags()` removes html tags

You can specify allowed tags:

```php
strip_tags($input, '<p><a><br>');  // allows <p>, <a>, and <br> tags
```

So the full **sanitization chain** might look like:

```php
htmlspecialchars(strip_tags(trim($_GET['passw'])), ENT_QUOTES, 'UTF-8');
```
