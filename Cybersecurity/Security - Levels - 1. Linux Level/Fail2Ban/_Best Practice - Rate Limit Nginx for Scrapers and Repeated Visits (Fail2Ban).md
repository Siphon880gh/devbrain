Fail2Ban does **not** watch web traffic by default. Out of the box it only protects SSH (port 22) by reading failed login attempts. Scrapers, DDoS-style floods, and suspiciously repeated page hits are invisible until you connect Nginx access logs to a custom jail.

This guide sets up rate limiting for a specific URL path (`/site1/`) on Nginx: **60 requests per minute**, static assets ignored, **24-hour ban** on violation.

---

## Why Fail2Ban ignores web traffic by default

| What Fail2Ban does by default | What it does **not** do |
|---|---|
| Watches SSH failed logins | Read Nginx access logs |
| Bans via firewall (iptables, ufw) | Know Nginx is running |
| Protects port 22 | Guess normal browsing speed for your site |

To block scrapers or repeated visits, you must manually bridge Nginx logs and Fail2Ban in three steps:

1. **Define the target** — which URLs to watch (e.g. `/site1/`)
2. **Set the limit** — how many requests count as human vs. bot
3. **Trigger the ban** — tell Fail2Ban to drop the IP in your firewall

---

## Step 1: Create the filter pattern

A filter tells Fail2Ban what a "scraping request" looks like in the log.

```bash
sudo vi /etc/fail2ban/filter.d/nginx-site1-scrape.conf
```

Press `i` for Insert mode, paste:

```ini
[Definition]
# Matches GET or POST requests containing /site1/ in the URL
failregex = ^<HOST> -.*"GET .*/site1/.* HTTP/.*"
            ^<HOST> -.*"POST .*/site1/.* HTTP/.*"

# Ignores static assets to avoid accidental bans
ignoreregex = \.(jpg|jpeg|png|gif|css|js|ico|woff|woff2|svg)$
```

Press `Esc`, then `:wq` and Enter to save.

---

## Step 2: Configure the jail in `jail.local`

The jail defines when a ban triggers. **Never edit `jail.conf` directly** — always use `jail.local`.

```bash
sudo vi /etc/fail2ban/jail.local
```

Press `G` to jump to the bottom. Press `i`, add a blank line, paste:

```ini
[nginx-site1-scrape]
enabled  = true
port     = http,https
filter   = nginx-site1-scrape
logpath  = /var/log/nginx/access.log
backend  = auto

# Rate limit: >60 requests in 60 seconds → ban for 24 hours
findtime = 60
maxretry = 60
bantime  = 24h
```

| Setting | Meaning |
|---|---|
| `findtime = 60` | Count requests within a 60-second window |
| `maxretry = 60` | Ban after more than 60 matching requests in that window |
| `bantime = 24h` | Keep the IP blocked for 24 hours |

Press `Esc`, then `:wq` and Enter to save.

---

## Step 3: Test the regex, then activate

Validate the filter against your live access log **before** restarting:

```bash
sudo fail2ban-regex /var/log/nginx/access.log /etc/fail2ban/filter.d/nginx-site1-scrape.conf
```

If output shows the configuration with no syntax errors, restart Fail2Ban:

```bash
sudo systemctl restart fail2ban
```

---

## Manage the jail after activation

Check status and see banned IPs:

```bash
sudo fail2ban-client status nginx-site1-scrape
```

Unban yourself or a legitimate tool during testing:

```bash
sudo fail2ban-client set nginx-site1-scrape unbanip <THE_BANNED_IP>
```

---

## Customize further

- **Whitelist IPs** — home office, partner tools, or crawlers like Googlebot
- **Custom log format or Cloudflare** — adjust `failregex` if Nginx logs a non-standard format or traffic passes through a proxy
- **Email alerts** — notify on each ban via Fail2Ban action configuration
