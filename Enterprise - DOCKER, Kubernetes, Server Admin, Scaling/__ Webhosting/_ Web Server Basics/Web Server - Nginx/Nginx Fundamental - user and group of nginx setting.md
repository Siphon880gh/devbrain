Top of the nginx main conf is the user and group your web server will act as when viewing webpages from a web browser
```
user www-data www-data;  
```


Find out by editing the nginx main conf file which could possibly be `vi /etc/nginx/nginx.conf`. It's at the top of the file like `user www-data www-data`

---

  
In the `nginx.conf` configuration file, the `user` directive is used to define the user and optionally the group that the Nginx worker processes will run as. The typical format is:

```
user <user> [group];  
```

Here’s how you would set it up to run as `www-data` for both user and group:

```
user www-data www-data
```

Nginx’s default user is different based on OS too: `www-data` (on Debian/Ubuntu systems) or `nginx` (on CentOS/RHEL systems)