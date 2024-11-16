
A location block like this is an exact match:
```
    location = / {
        return 301 /me;
    }
```

And if there's no exact match, you have access to $args:

Example 1:
wengindustries.com/test?q=2 redirects to wengindustries.com/me/?q=2
```
    location /test {
        return 301 /me?$args;
    }
```

Example 2:
wengindustries.com/test?qq redirects to wengindustries.com/me/qq
```
    location /test {
        return 301 /me/$args;
    }
```
