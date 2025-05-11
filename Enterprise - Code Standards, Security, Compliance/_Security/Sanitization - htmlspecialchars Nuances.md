
```
$username = htmlspecialchars($_GET["username"], ENT_QUOTES, 'UTF-8');
```

The flags `ENT_QUOTES`, `'UTF-8'`, etc., are parameters for `htmlspecialchars()`, not `strip_tags()`.

### For `htmlspecialchars()` the available **flags** are:

|Flag|Description|
|---|---|
|`ENT_COMPAT`|Default. Converts double quotes, but leaves single quotes.|
|`ENT_QUOTES`|Converts both double and single quotes.|
|`ENT_NOQUOTES`|Does **not** convert any quotes.|
|`ENT_SUBSTITUTE`|Replaces invalid UTF-8 with a replacement character.|
|`ENT_DISALLOWED`|Removes characters that can't be represented in the target charset.|
|`ENT_HTML401`|Handle as HTML 4.01 (default).|
|`ENT_XML1`|Handle as XML 1.0.|
|`ENT_XHTML`|Handle as XHTML.|
|`ENT_HTML5`|Handle as HTML5.|

You can combine flags using bitwise OR (`|`), e.g.:

```php
htmlspecialchars($input, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
```
