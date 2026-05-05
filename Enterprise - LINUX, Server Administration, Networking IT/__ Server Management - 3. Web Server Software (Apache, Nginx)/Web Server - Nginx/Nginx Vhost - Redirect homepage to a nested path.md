Add this to vhost:
```
    location = / {  
        return 301 /me;  
    }
```

Make sure to restart nginx:
```
nginx -s reload
```