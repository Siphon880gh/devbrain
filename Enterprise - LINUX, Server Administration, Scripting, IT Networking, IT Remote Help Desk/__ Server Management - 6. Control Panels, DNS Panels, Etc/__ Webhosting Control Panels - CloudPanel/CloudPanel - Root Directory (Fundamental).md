
Changing document root at CloudPanel
![](r4gKBlk.png)

Which the Cloudpanel Vhost text entry is:
```
  server_name www.wengindustries.com wengindustries.com www1.wengindustries.com www.wengindustry.com wengindustry.com www1.wengindustry.com;  
  {{root}}
```

Which expands into the website’s vhost (eg. `/etc/nginx/sites-enabled/wengindustries.com.conf`):
```
  server_name www.wengindustries.com wengindustries.com www1.wengindustries.com www.wengindustry.com wengindustry.com www1.wengindustry.com;  
  root /home/wengindustries/htdocs/wengindustries.com;
```

It is NOT recommended that you hard code into CloudPanel's Vhost. Continue to have it use `{root}`