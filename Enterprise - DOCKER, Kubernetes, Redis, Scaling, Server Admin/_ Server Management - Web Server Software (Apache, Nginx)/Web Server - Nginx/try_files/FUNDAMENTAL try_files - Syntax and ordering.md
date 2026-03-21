
```
try_files $uri $uri/ /index.php?$args =404;
```

**Order Matters:** The `try_files` directive checks the existence of files in the order you specify.
- `$uri`: Checks if the exact URI matches a file.
- `$uri/`: Checks if the URI matches a directory (important for serving index files in directories).
- `/index.php?$args`: Passes the request to `index.php` if the above checks fail.
- `=404`: Returns a 404 error if none of the above are found, which could open the default 404 page or your defined error_page (if the status error matches).

