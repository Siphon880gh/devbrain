Use case: Every time you make changes to the Nginx configuration files, you need to restart or reload Nginx for the changes to take effect. You can reload Nginx, which is generally safer as it won’t drop connections. Use the following command:  

You can reload Nginx, which is generally safer as it won’t drop connections. Use the following command:

```
sudo systemctl reload nginx  
```

If you prefer to restart (which stops and starts the service again), use:

```
sudo systemctl restart nginx
```