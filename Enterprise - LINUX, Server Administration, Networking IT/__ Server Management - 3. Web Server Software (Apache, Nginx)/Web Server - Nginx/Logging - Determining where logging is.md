
Logs help determine whether there are suspicious activity or bugs.
```
tail -f /var/log/nginx/access.log /var/log/nginx/error.log
```

Your system's location might vary.

#### If logs are empty  

If logs are empty, confirm whether nginx is logging somewhere else:
- You absolutely could have one access log that's empty and exists where another access log path is actually used. For example, you could have an empty `/home/<SITE_NAME>/logs/nginx/access.log`but logging actually goes to `/var/log/nginx/access.log`
  
- The following command dumps the full parsed Nginx configuration to stdout, including all included files, then greps/parses for access_log setting that can be either on or off
```
sudo nginx -T 2>/dev/null | grep access_log
```

Also check whether the log appears empty because Nginx is writing to a different dated or compressed log file.

- Dated logs are aka Rotated logs. This means logs are split into separate files over time, often one file per day, with the date included in the filename.
  
```
sudo ls -la /home/wengindustries/logs/nginx/
sudo zcat /home/wengindustries/logs/nginx/access.log-*.gz 2>/dev/null | tail -n 20
```

If the active access log is empty but rotated logs contain traffic, the issue may be **logging location/rotation**, not absence of requests. Could look like:
![[Pasted image 20260321055128.png]]

