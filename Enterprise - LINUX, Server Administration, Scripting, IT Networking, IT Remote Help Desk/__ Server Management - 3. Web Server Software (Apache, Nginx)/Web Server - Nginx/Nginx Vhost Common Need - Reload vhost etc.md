
Run
```
nginx -s reload;
```

The -s means to send a signal to master processes. Here we're sending a "reload" signal.

Test first with `nginx -t`. Reload does not drop connections; `systemctl restart nginx` does. See [[Nginx - Compare nginx -t with reload and restart]].