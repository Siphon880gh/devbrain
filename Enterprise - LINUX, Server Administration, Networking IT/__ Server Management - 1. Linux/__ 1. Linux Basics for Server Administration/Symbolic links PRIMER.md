
Let's say you create symbolic links (aka shortcuts) to supervisor app configs and supervisor central config

You use `ln -s ORIGINAL SHORTCUT` which could be for files or folders  

If you run tree to review the results (`apt-get install tree`)

    └── current_folder  
        ├── conf.d -> /etc/supervisor/conf.d  
        ├── supervisord.conf -> /etc/supervisor/supervisord.con  
        ├── supervisor  

If you run `ls -la` (not you need the detailed view):
```
lrwxrwxrwx 1 root root   22 Nov 19 13:15 conf.d -> /etc/supervisor/conf.d

lrwxrwxrwx 1 root root   32 Nov 19 13:15 supervisord.conf -> /etc/supervisor/supervisord.conf
```

