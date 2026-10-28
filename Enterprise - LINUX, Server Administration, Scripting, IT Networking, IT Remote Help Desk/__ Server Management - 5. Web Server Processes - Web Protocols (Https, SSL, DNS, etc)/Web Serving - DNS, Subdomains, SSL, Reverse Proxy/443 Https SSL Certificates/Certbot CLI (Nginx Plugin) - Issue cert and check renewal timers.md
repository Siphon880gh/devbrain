Issue a Let's Encrypt cert with Certbot's Nginx plugin, then confirm renewal is actually scheduled.

This is the HTTP-01 path (Certbot talks to Nginx on the server). For wildcards you still need the DNS challenge: [[Certbot with Wildcard SSL]].

Certbot is not preinstalled on most distros. On Debian/Ubuntu you typically need both Certbot and the Nginx plugin:

```bash
sudo apt update
sudo apt install certbot python3-certbot-nginx
```

## Issue the cert

Obtain the certificate files only (does **not** rewrite your vhost):

```bash
sudo certbot certonly --nginx -d example.com -d www.example.com
```

`certonly` fetches the cert. You still point `ssl_certificate` / `ssl_certificate_key` at the files under `/etc/letsencrypt/live/example.com/` and then:

```bash
sudo nginx -t && sudo systemctl reload nginx
```

If you want Certbot to edit the Nginx vhost for you (listen 443, cert paths, often the HTTP→HTTPS redirect):

```bash
sudo certbot --nginx -d example.com -d www.example.com
```

Then still run `nginx -t` and reload if you edited anything yourself afterward. See [[Nginx - Compare nginx -t with reload and restart]].

## Renewal is a cron/timer thing — check it

Let's Encrypt certs expire every 90 days: [[Certbot is Limited to 90 Days]]. Issuing once is not enough.

On modern Debian/Ubuntu, Certbot usually installs a systemd timer. Check that it exists and when it last/next ran:

```bash
systemctl list-timers | grep certbot
systemctl status certbot.timer
```

You should see `certbot.timer` listed. If it is missing or inactive, renewal will not happen on its own.

Dry-run the renew path without replacing the live cert:

```bash
sudo certbot renew --dry-run
```

Some setups still use cron instead of (or in addition to) the timer:

```bash
sudo crontab -l
ls /etc/cron.d/ | grep -i certbot
```

A typical cron line looks like:

```
0 3 * * * certbot renew --quiet && systemctl reload nginx
```

If neither a timer nor a cron line exists, add one of them. After a successful renew, Nginx still needs a reload so it opens the new cert files.
