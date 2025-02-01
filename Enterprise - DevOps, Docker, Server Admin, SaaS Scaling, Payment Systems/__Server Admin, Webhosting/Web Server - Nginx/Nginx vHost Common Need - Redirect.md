Redirect works like this
```
location ~ ^/tools/(.*) {
    return 301 /app/$1;
}
```

In this example:
- `~` indicates that the `location` block uses a regular expression.
- `(.*)` captures everything after `/tools/` and assigns it to `$1`.

Visiting `domain.tld/tools/app1` redirects and the user can see the url change in the address bar, to: `domain.tld/app/app1`.

---

Reworded:

[https://wengindustries.com/tools/devbrain/](https://wengindustries.com/app/devbrain/) => [https://wengindustries.com/app/devbrain/](https://wengindustries.com/app/devbrain/)  

```
# Redirect tools/ to app/  
location ~ ^/tools/(.*) {  
	return 301 /app/$1;  
}
```

---

Trickier case

\<
This nginx vhost code doesnt seem to work:
```
location ~ ^/me/(.*) {
	 return 301 /me/?page=$1;
}
```

When I visit `domain.com/me/about` redirects to `domain.com/me/?page=
`
\>
The issue with your Nginx configuration lies in the regular expression and the `$1` reference in the `return` directive. The way you've written the `location` block causes the regex capture group to match but doesn't correctly pass the value to the `return` directive.

### Corrected Configuration

Here's the fixed Nginx configuration:

```nginx
location ~ ^/me/(.+)$ {
    return 301 /me/?page=$1;
}
```

### Explanation of Changes:

1. **Regex Adjustment**:
   - Changed `(.*)` to `(.+)$`:
     - `.*` matches zero or more characters, which can include an empty string. This is why your `$1` might be empty in certain cases.
     - `.+` ensures there is at least one character in the match after `/me/`.

2. **Regex Anchor**:
   - Added `$` to ensure the regex matches until the end of the URI, preventing potential over-matching.

3. **Redirect Behavior**:
   - `$1` now correctly references the content after `/me/`, as it requires at least one character due to the `.+` adjustment.

## But another problem comes up
Because of `^/me/(.+)$`, your css, js, pdf, etc files will also be rewritten to `/me/?page=$1` which will be 404 when link or script sourced.

To fix this, you should:
1. **Exclude Static Files**: Add a condition to avoid matching static file requests.
2. **Ensure Proper Ordering**: Place static file handling rules above the regex-based `location`.

```
# Handle static files first
location ~* ^/me/(.+)\.(css|js|png|jpg|jpeg|gif|ico|pdf|svg|woff|woff2|ttf|eot)$ {
    # root /me/dist/assets; # Adjust the path to your static file directory if necessary
    expires max;
    log_not_found off;
}

# Redirect /me/<something>
location ~ ^/me/(.+)$ {
    return 301 /me/?page=$1;
}
```

The `~*` operator makes the match case-insensitive.