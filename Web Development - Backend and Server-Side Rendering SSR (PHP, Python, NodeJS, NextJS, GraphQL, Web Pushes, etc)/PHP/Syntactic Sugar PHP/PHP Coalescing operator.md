  
```
$text = $data['text'] ?? '';
```

**PHP 7.0.  

The line `$text = $data['text'] ?? '';` in PHP is using the null coalescing operator `??`. This operator is used to check for the existence of something and return a default value if it does not exist. In this case, it's checking if the key `'text'` exists in the `$data` array.

Here's a breakdown of how it works:

- `$data['text']`: This tries to access the value associated with the key `'text'` in the `$data` array.
- `??`: This is the null coalescing operator. It checks if the left-hand side of the operator exists and is not `null`.
- `''`: This is the default value that will be returned if the left-hand side is `null` or not set.

So, `$text = $data['text'] ?? '';` will set `$text` to the value of `$data['text']` if it exists and is not `null`. If `$data['text']` is not set or is `null`, `$text` will be set to an empty string `''`.

This is particularly useful when dealing with JSON data or arrays where some keys may not be set, and you want to avoid undefined index notices or errors in PHP. It's a cleaner and more concise way to write a common pattern that was previously done with `isset()`:

```
$text = isset($data['text']) ? $data['text'] : '';
```

The null coalescing operator simplifies this to one line and is available as of PHP 7.0.