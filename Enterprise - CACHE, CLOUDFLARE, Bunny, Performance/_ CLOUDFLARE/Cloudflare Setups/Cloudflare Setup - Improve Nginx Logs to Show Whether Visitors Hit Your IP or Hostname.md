By default, Nginx access logs usually show the visitor IP, request path, status code, referrer, and user agent. That is useful, but sometimes it is not enough.

You may be attacked/scraped/DDoS and you wonder if it's because they have your VPS / dedicated server's IP. In that case, hiding behind Cloudflare Proxy records won't be enough because your IP is already exposed. You'd have to change the IP (on some webhosts that means wiping your files)

Other reasons include:

- Did the visitor reach the site through the correct domain?
- Did they visit the server directly by IP address?
- Which hostname did Nginx receive?
- Was the request proxied through Cloudflare?
- Which vhost/server block handled the request?

To make your logs more useful, update your Nginx `log_format` definitions so they include hostname and server information.

---

## Original Nginx Log Format

You may currently have something like this:

```nginx
log_format main '$remote_addr - $remote_user [$time_local] "$request" '
                '$status $body_bytes_sent "$http_referer" '
                '"$http_user_agent" "$http_x_forwarded_for"';

log_format cloudflare '$http_cf_connecting_ip - $remote_user [$time_local] "$request" '
                      '$status $body_bytes_sent "$http_referer" '
                      '"$http_user_agent" "$http_x_forwarded_for"';
```

This works, but it does not clearly show which hostname the visitor used.

---

## Improved Nginx Log Format

Replace it with something like this:

```nginx
log_format main '$remote_addr - $remote_user [$time_local] '
                '"$request" $status $body_bytes_sent '
                'Host="$host" HttpHost="$http_host" '
                'ServerAddr="$server_addr" ServerName="$server_name" '
                'Referer="$http_referer" UA="$http_user_agent" '
                'XFF="$http_x_forwarded_for"';

log_format cloudflare '$http_cf_connecting_ip - $remote_user [$time_local] '
                      '"$request" $status $body_bytes_sent '
                      'Host="$host" HttpHost="$http_host" '
                      'ServerAddr="$server_addr" ServerName="$server_name" '
                      'CF-Ray="$http_cf_ray" '
                      'Referer="$http_referer" UA="$http_user_agent" '
                      'XFF="$http_x_forwarded_for"';
```

This adds several helpful fields:

```txt
Host="$host"
HttpHost="$http_host"
ServerAddr="$server_addr"
ServerName="$server_name"
CF-Ray="$http_cf_ray"
```

---

## What These Fields Tell You

### `$host`

This is the hostname Nginx decides to use for the request.

It usually comes from the request’s `Host` header, but Nginx can normalize or fall back to a configured server name in some cases.

Example:

```txt
Host="example.com"
```

or:

```txt
Host="123.123.123.123"
```

If you see the server IP here, someone probably visited your server directly by IP.

---

### `$http_host`

This is the raw `Host` header sent by the browser or bot.

Example:

```txt
HttpHost="example.com"
```

or:

```txt
HttpHost="123.123.123.123"
```

This is especially useful when debugging direct-to-IP traffic, strange bots, bad DNS, or misconfigured domains.

---

### `$server_addr`

This is the server IP address that handled the request.

Example:

```txt
ServerAddr="123.123.123.123"
```

This helps when the server has multiple IP addresses or when you are using floating IPs.

---

### `$server_name`

This is the `server_name` from the Nginx vhost/server block that handled the request.

Example:

```txt
ServerName="example.com"
```

This helps you confirm which Nginx vhost matched the request.

---

### `$http_cf_ray`

This is the Cloudflare Ray ID.

Example:

```txt
CF-Ray="8f123abc456def-LAX"
```

If this field exists, the request likely came through Cloudflare.

If it is empty, the request may have reached your origin server directly.

---

## Why This Is Useful

After updating the log format, your access logs can show whether someone visited:

```txt
https://example.com
```

or directly hit:

```txt
http://123.123.123.123
```

That matters when you are trying to protect your origin IP.

If your site is supposed to be behind Cloudflare, direct IP visits are usually not desirable. They may mean:

- Your origin IP leaked somewhere.
    
- A bot is scanning your server directly.
    
- DNS is misconfigured.
    
- A subdomain is bypassing Cloudflare.
    
- A previous floating IP or old DNS record exposed the server.
    

With the improved log format, you can inspect the access log and see exactly what hostname was used.

---

## Example Log Output

With the improved format, a normal Cloudflare-proxied request might look like this:

```txt
203.0.113.10 - - [15/Apr/2026:12:30:22 -0700] "GET / HTTP/2.0" 200 4821 Host="example.com" HttpHost="example.com" ServerAddr="123.123.123.123" ServerName="example.com" CF-Ray="8f123abc456def-LAX" Referer="-" UA="Mozilla/5.0 ..." XFF="203.0.113.10"
```

A direct IP hit might look like this:

```txt
198.51.100.25 - - [15/Apr/2026:12:31:10 -0700] "GET / HTTP/1.1" 200 4821 Host="123.123.123.123" HttpHost="123.123.123.123" ServerAddr="123.123.123.123" ServerName="_" Referer="-" UA="curl/8.0" XFF="-"
```

That tells you the visitor did not use your domain. They hit the server IP directly.

---

## Where to Check the Logs

Depending on your setup, logs may appear in different places.

For CloudPanel sites, you may see logs under the site user’s log directory:

```bash
/home/wengindustries/logs/nginx/access.log
```

Rotated logs may look like this:

```bash
/home/wengindustries/logs/nginx/access.log-2026-04-15
```

You may also have system-wide Nginx logs:

```bash
/var/log/nginx/access.log
```

To watch the log live:

```bash
tail -f /home/wengindustries/logs/nginx/access.log
```

Or:

```bash
tail -f /var/log/nginx/access.log
```

To search for direct IP visits:

```bash
grep 'HttpHost="123.123.123.123"' /home/wengindustries/logs/nginx/access.log
```

Replace `123.123.123.123` with your server IP.

---

## Where Access Log Paths Are Set

The log format is usually defined globally, but the actual access log and error log paths are usually set inside the vhost/server block.

For example:

```nginx
access_log /home/wengindustries/logs/nginx/access.log cloudflare;
error_log /home/wengindustries/logs/nginx/error.log;
```

or:

```nginx
access_log /var/log/nginx/access.log main;
error_log /var/log/nginx/error.log;
```

In CloudPanel, the vhost may use shortcut placeholders like:

```nginx
{{access_log}}
{{error_log}}
```

Those placeholders are expanded by CloudPanel. If you need to see the real log paths, check the generated Nginx vhost files.

Common places to inspect include:

```bash
/etc/nginx/sites-available/
```

and:

```bash
/etc/nginx/sites-enabled/
```

For example:

```bash
grep -R "access_log" /etc/nginx/sites-available/
grep -R "error_log" /etc/nginx/sites-available/
```

This helps you find exactly where each site is writing its logs.

---

## Important: `log_format` Must Be Defined Before the Vhost Uses It

If your vhost says:

```nginx
access_log /home/wengindustries/logs/nginx/access.log cloudflare;
```

then Nginx must already know what `cloudflare` means.

That means this must exist somewhere in the Nginx `http` context:

```nginx
log_format cloudflare '...';
```

If Nginx complains that `cloudflare` is not recognized, it usually means the vhost is trying to use a log format that has not been loaded yet.

You may see an error like:

```txt
unknown log format "cloudflare"
```

or:

```txt
nginx: [emerg] unknown log format "cloudflare"
```

---

## Test and Reload Nginx

After changing the config, always test it first:

```bash
nginx -t
```

If the test passes, reload Nginx:

```bash
systemctl reload nginx
```

If you are using CloudPanel and it still complains about the `cloudflare` format not being recognized, restart Nginx:

```bash
systemctl restart nginx
```

In some cases, CloudPanel’s generated vhost config may not pick up the global log format until Nginx is fully restarted.

---

## Summary

Adding hostname and server fields to your Nginx logs makes troubleshooting much easier.

The improved format lets you see:

```txt
Host
HttpHost
ServerAddr
ServerName
CF-Ray
Referer
User-Agent
X-Forwarded-For
```

This helps you quickly answer:

```txt
Did they visit my domain, or did they hit my server IP directly?
```

For Cloudflare-protected sites, this is especially useful because direct IP hits can reveal whether your origin server is being scanned, attacked, or bypassed.