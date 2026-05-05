Matching are particularly precise of whether or not there is a trailing slash (eg. `domain.tld/test/` vs `domain.tld/test`).

So you want to normalize all urls WITHOUT a trailing slash to rewriting/redirecting to a trailing slash.

Trailing slash normalization: Redirect requests without a trailing slash to include one  
```
# Redirect requests without a trailing slash to include one  
location ~ ^/app/([^/]+)$ {  
    return 301 $scheme://$host$uri/;  
}
```

