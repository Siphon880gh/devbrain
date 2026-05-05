Nginx logs are most useful when you know **where the logs are stored** and whether the **timestamps match what you are seeing right now** during your SSH session.

Nginx commonly has two main logs:

```bash
/var/log/nginx/access.log
/var/log/nginx/error.log
```

The **access log** shows requests coming into the server, including page visits, bot hits, HTTP status codes, IP addresses, and request timestamps.

The **error log** shows problems Nginx runs into, such as permission issues, missing files, bad upstream connections, SSL errors, or config-related problems.

To check them:

```bash
sudo tail -n 50 /var/log/nginx/access.log
sudo tail -n 50 /var/log/nginx/error.log
```

To watch them live:

```bash
sudo tail -f /var/log/nginx/access.log
sudo tail -f /var/log/nginx/error.log
```

If those files are empty or do not exist, Nginx may be writing logs somewhere else. This is common with CloudPanel, cPanel, Plesk, or custom Nginx setups.

To find the actual paths Nginx is using, run:

```bash
sudo nginx -T | grep access_log
sudo nginx -T | grep error_log
```

You may see paths like:

```nginx
access_log /home/example/logs/nginx/access.log;
error_log /home/example/logs/nginx/error.log;
```

If so, use those paths instead of `/var/log/nginx/access.log` and `/var/log/nginx/error.log`.

Many Nginx log entries include timestamps. This matters because you may be watching logs while testing a website, checking bot traffic, or confirming whether a recent error really matches the thing you just did.

To compare the log timestamps against the server’s current time, run:

```bash
date
```

This helps you confirm:

- whether the log entry happened recently
    
- whether the server clock looks correct
    
- whether the timestamp lines up with your current SSH session
    
- whether the event you are investigating happened before or after your test
    

You can also check the server’s time zone and clock sync status with:

```bash
timedatectl
```

A simple troubleshooting flow is:

```bash
date
sudo tail -f /path/to/access.log
sudo tail -f /path/to/error.log
```

Then refresh the website or reproduce the issue. If the request appears in the access log with a timestamp close to the output of `date`, you know Nginx is receiving the request now. If an error appears at the same time in the error log, that error is likely connected to your test.