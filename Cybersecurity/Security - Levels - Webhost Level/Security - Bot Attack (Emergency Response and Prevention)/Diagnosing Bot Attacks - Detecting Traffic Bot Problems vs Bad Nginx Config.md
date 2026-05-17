# Diagnose Nginx High CPU: Bot Attack or Bad Nginx Config?

If your Nginx worker processes are using 80–100% CPU, the goal is to figure out whether the load is coming from:

1. **External traffic hitting your public web ports**, such as bots, scrapers, or a DDoS-style flood
    
2. **A bad Nginx config**
    
3. **A broken Nginx module/build issue**
    

The fastest way to diagnose this is to simplify Nginx step by step and see when the CPU calms down.

---

# Step 1: Test a Minimal Public Nginx Config

First, replace your main Nginx config with a very simple config that listens publicly on port `80`.

Put this in:

```bash
/etc/nginx/nginx.conf
```

Use:

```nginx
user root;
worker_processes 2;

events {
    worker_connections 1024;
}

http {
    access_log off;
    error_log /var/log/nginx/error.log notice;

    server {
        listen 80 default_server;
        server_name _;
        return 444;
    }
}
```

This config does a few useful things:

- Avoids SSL entirely
    
- Disables access logs
    
- Avoids proxying, PHP, redirects, cache rules, and complex server blocks
    
- Immediately closes public HTTP requests with `444`
    

Then test and restart Nginx:

```bash
nginx -t && systemctl restart nginx
```

Watch the Nginx CPU usage:

```bash
pidstat -p $(pgrep -d, nginx) 1
```

---

# How to Read This First Test

If CPU drops after using the minimal public config, your original Nginx config was probably causing the problem.

Possible causes include:

- Bad rewrite rules
    
- Redirect loops
    
- Heavy logging
    
- Expensive proxy behavior
    
- Too many included config files
    
- Misconfigured SSL/server blocks
    
- A backend app causing Nginx to work too hard
    

But if Nginx worker CPU is still high even with this minimal config, then the next question is:

> Is the CPU spike caused simply by exposing Nginx to the public internet?

To answer that, do the localhost-only test.

---

# Step 2: Test a Localhost-Only Nginx Config

Now remove public exposure completely.

Replace `/etc/nginx/nginx.conf` with:

```nginx
user root;
worker_processes 2;

events {
    worker_connections 1024;
}

http {
    access_log off;
    error_log /var/log/nginx/error.log notice;

    server {
        listen 127.0.0.1:8088;
        server_name _;
        return 200 "ok\n";
    }
}
```

Then run:

```bash
nginx -t && systemctl restart nginx
```

Watch CPU again:

```bash
pidstat -p $(pgrep -d, nginx) 1
```

This test is more decisive because Nginx is no longer listening on public port `80` or `443`.

It only listens locally on:

```txt
127.0.0.1:8088
```

External bots cannot hit that listener.

---

# How to Read the Localhost-Only Test

## If CPU is low now

The cause is almost certainly **external public traffic**.

That means your Nginx CPU spike is probably from bots, scrapers, a flood of requests, or some other public traffic hitting your server.

In plain English:

> When Nginx was public, CPU spiked.  
> When Nginx was localhost-only, CPU calmed down.  
> Therefore, the problem is likely outside traffic.

## If CPU is still high now

Then the problem is probably not normal public traffic.

At that point, look deeper into:

- Nginx itself
    
- Compiled modules
    
- A broken package/build
    
- Something unusual in the Nginx install
    
- Another process being mistaken for Nginx load
    
- Hidden included configs still being loaded
    

Run:

```bash
nginx -V 2>&1
```

That shows how Nginx was built and which modules are enabled.

---

# If Localhost-Only Is Calm

If the localhost-only config fixes the CPU spike, then public traffic is the likely cause.

Now you can prove it further by temporarily blocking public web traffic.

## Option A: Temporarily Block Public Web Traffic

With UFW:

```bash
ufw deny 80/tcp
ufw deny 443/tcp
```

Or with iptables:

```bash
iptables -I INPUT -p tcp --dport 80 -j DROP
iptables -I INPUT -p tcp --dport 443 -j DROP
```

Then watch CPU again.

If CPU drops after blocking ports `80` and `443`, you have strong proof that external traffic is causing the load.

Later, remove those temporary rules when you are done testing.

---

# Longer-Term Fixes If Bots Are the Cause

Once you prove that external traffic is the problem, then you can decide how to protect the server.

## Option A: Put Cloudflare or Another WAF in Front

A proxy/WAF like Cloudflare can help filter bad traffic before it reaches your server.

However, there is one important warning:

If bots are attacking your server by its **direct IP address**, Cloudflare cannot fully protect you unless the origin IP is hidden or changed.

Cloudflare protects traffic that goes through Cloudflare. But if attackers already know your server IP, they can keep hitting it directly.

In that case, you may need to:
- Move to a new server IP
- Use a floating IP if your host supports it. But note adding floating IP to A record does not mean the original IP won't work. Floating IP's are additional IPs, not IPs that swap the original IP.
- Firewall the origin so only Cloudflare IP ranges can reach ports `80` and `443`
- Avoid exposing the real origin IP in DNS records

## Option B: Add Rate Limiting

After proving traffic is the cause, you can add Nginx rate limits.

For example, later you may use:

```nginx
limit_req_zone $binary_remote_addr zone=req_limit:10m rate=5r/s;
```

Then apply it inside a server or location block.

But do not start here.

First, prove whether the traffic is actually the cause.

## Option C: Review Access Logs Temporarily

Since access logs were disabled during testing, you may later re-enable them briefly to inspect traffic patterns.

Look for things like:
- Many requests from the same IP
- Random paths
- WordPress exploit scans
- `.env` scans
- `wp-login.php` floods
- Suspicious user agents
- Requests to domains that should not be hitting this server

---

# If Localhost-Only Still Spikes

If Nginx still burns CPU while only listening on `127.0.0.1:8088`, then the issue is probably inside the Nginx installation or runtime environment.

Run:

```bash
nginx -V 2>&1
```

Then check:

```bash
nginx -T
```

Also check whether Nginx is still loading unexpected config files:

```bash
grep -R "include" /etc/nginx/nginx.conf /etc/nginx/
```

Possible causes include:

- Unexpected included configs
    
- A bad third-party module
    
- A broken Nginx package
    
- Nginx loaded from a custom build
    
- A service manager restarting Nginx repeatedly
    
- Another monitoring or security tool interacting badly with Nginx
    

---

# Simple Diagnostic Flow

Use this order:

```txt
1. Test minimal public Nginx config on port 80
   ↓
2. If CPU is still high, test localhost-only config on 127.0.0.1:8088
   ↓
3. If localhost-only is calm, public traffic is the problem
   ↓
4. If localhost-only still spikes, investigate Nginx build/modules/config includes
```

The key test is this:

```txt
Public listener high CPU + localhost-only low CPU = external traffic problem
```

But:

```txt
Localhost-only high CPU = internal Nginx/module/config problem
```

This gives you a clean way to separate a bot attack from a bad Nginx setup.