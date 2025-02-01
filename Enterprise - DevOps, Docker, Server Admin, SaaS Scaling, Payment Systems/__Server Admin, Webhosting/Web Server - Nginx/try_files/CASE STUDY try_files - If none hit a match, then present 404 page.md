```
location / {  
    try_files $uri $uri/ =404;
    # ...
```

User visits a URL that is not found, then nginx tries `$uri` , then tries `$uri/` , and if that fails, then it opens the default 404 page because of `=404` . Order matters.
