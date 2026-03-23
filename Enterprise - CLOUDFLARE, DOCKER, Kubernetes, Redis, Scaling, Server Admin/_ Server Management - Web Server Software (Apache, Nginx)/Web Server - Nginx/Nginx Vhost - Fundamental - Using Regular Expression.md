
The `~` indicates using a regular expression. For example:
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

Want case-insensitive?

The `~*` operator makes the match case-insensitive.