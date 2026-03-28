You may suspect bot attacks if you found out CPU use spike or see a lot of traffic at a dashboard.

If Nginx CPU is high, the first job is to tell whether the server is being overwhelmed by real incoming traffic, bot/scanner traffic, or an internal config/app problem (especially after a forced server update). The checks below help separate those cases.

You may not be able to access cpanel/cloudpanel/etc web panels because the server is overwhelmed and those are usually at a url. You can access web panels that are outside your server. Let's say you’re on a provider’s dashboard like Hostinger, then you could see, for example:
![[Pasted image 20260321054831.png]]
![[Pasted image 20260321054936.png]]


See if Cloudflare had bots blocked as a setting. Turn on bot blocking if not on.

At Cloudflare, you could see bot attacks:
![[Pasted image 20260325052302.png]]
Then an hour later:
![[Pasted image 20260325052312.png]]

But it's also possible Cloudflare won't reveal these attacks, IF the attacker is going after your hosting's IP address directly instead of the domain name.

Next steps is going down to the nginx web server software level at a SSH session.

---

1. Confirm nginx is actually the hot process
   Use process-level checks first to verify whether nginx workers are consuming CPU.

	**1a**. Snapshot:
	ps aux --sort=-%cpu | head -25
	
	This is a positive we have a problem:
	![[Pasted image 20260321055000.png]]
  
	**1b**. Polling:
	```
	pidstat -p $(pgrep -d, nginx) 1
	```
	
	If one or more nginx worker processes are consistently near the top of CPU usage, the next question becomes: **are they busy serving traffic, or stuck doing something else?**

### 2. Check what the hot nginx workers are doing

Attach `strace` briefly to a busy nginx worker.
```
sudo strace -tt -T -p <PID> -o /tmp/nginx-PID.strace
```

Let it run for 5–10 seconds, stop it with `Ctrl+C`, then inspect the output:
```
tail -100 /tmp/nginx-PID.strace
```

How to interpret it:

- Repeated `accept4`, `recvfrom`, `sendfile`, or `writev` usually points to **heavy incoming request traffic**.
- Repeated `epoll_wait` usually means the worker is mostly **idle**, so nginx may not be the real bottleneck.
- Repeated `open`, `stat`, or file-path lookups can suggest a **bad file/path pattern**, rewrite problem, or recursive filesystem behavior.
- Repeated upstream socket reads/writes can indicate a **proxy/backend issue** rather than raw bot traffic.

### 3. Follow access and error logs live

Logs help determine whether requests are actively hitting the server and what paths they are requesting.
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

### 4. Look for obvious bot or scanner requests

Suspicious requests often point to internet scanning rather than legitimate user traffic. For example:
```
GET /.env HTTP/1.1
```

Requests for files like `.env`, `.git`, WordPress paths, phpMyAdmin, or other common probe targets are strong signs of **automated scanning/bot activity** rather than normal visitors. Another obvious sign is if multiple pages are fetched in quick succession (although legitimate crawlers for AI and search is possible, we’ve correlated with high CPU use so the volume of traffic is much higher and not throttled courteously as it would with legate scanning)

### 6. Count active HTTPS connections

A quick way to judge whether nginx is under real network pressure is to count established TLS connections.
```
sudo ss -Htan state established sport = :443 | wc -l
```

A large number of simultaneous established connections suggests nginx is handling **live network load**, not just spinning on an internal config issue.

### 7. Snapshot the client IPs hitting port 443

To see whether load is coming from a few sources or many distributed addresses, inspect connected client IPs.
```
sudo ss -Htan state established sport = :443 | awk '{
  for (i=1;i<=NF;i++) {
    if ($i ~ /^[0-9a-fA-F.:]+:[0-9]+$/ || $i ~ /^\[[0-9a-fA-F:]+\]:[0-9]+$/) {
      if ($i !~ /:443$/) print $i
    }
  }
}' | sed -E 's/^\[([^]]+)\]:[0-9]+$/\1/; s/^([0-9.]+):[0-9]+$/\1/' | sort | uniq -c | sort -rn | head -20
```

How to interpret it:
- It's a tab separated values on multiple lines outputted to the terminal. The first column is the number of hits from the ip. The right column is the ip.
- A few IPs with very high counts may indicate a **small number of abusive clients**.
- Many different IPs with low counts each can indicate **distributed bot/scanner traffic**.
	- But at a high volume traffic with instant 75-100% CPU usage, then your server’s IP address is likely listed on a public scanning botnet for scraping or is experiencing a targeted DDoS (Distributed Denial of Service) attack. 
- Simply being online and reachable is often enough for it to be discovered, recorded, and reused by automated systems.
- A wide spread of apparently real public IPs is more consistent with **broad internet scanning or distributed HTTPS load** than with one broken browser or one friendly crawler.

Example output. Here’s me being attacked by a botnet:
![[Pasted image 20260321055221.png]]

Discussion:
Based on the sustained volume and repeated requests, it may be consistent with one or more of the following: aggressive scraping of a high-information website, denial-of-service style abuse, malicious competitor activity, or automated data collection/training activity by unknown third parties. 

Looking at the shape, a high volume of many different IPs with 12-22 requests each is likely your domain or IP is now listed on a public scanning botnet for scraping or you are experiencing a targeted DDoS (Distributed Denial of Service) attack. Looking at the ramp up from 12 to 13 to 14... to 22, it's clear this is a sophisticated attack where an automated system pushes the limits to see if it can continue attacking or scraping without crashing your server, and when your server does crash, it will likely wait then restart the scraping effort, knowing the limit of requests. 

Regardless of motive, the effect has been the same: sustained resource exhaustion, service instability, and loss of access to critical systems.
### 8. Dump full nginx config to inspect for non-traffic causes

If traffic evidence is weak, inspect nginx config for loops or bad includes.

nginx -T > nginx.full.txt
vi /etc/nginx/nginx.conf

Things to look for:
- bad `include` directives
- redirect loops
- internal rewrite loops
- `try_files` loops
- bad `index`, `root`, or `alias` use
- recursive file path traversal
- symlink/path weirdness

These point more toward a **configuration problem** than a traffic problem.

Could look like (this is showing bots scraping my coder notes that are linked md files):
![[Pasted image 20260321055237.png]]

### 9. Reload safely when testing config

Config includes the website’s vhost and any conf files that the vhost reference. It also includes sites-available or sites-enabled or the default nginx.conf

Before reloading nginx, validate config syntax.
```
sudo nginx -t && sudo systemctl reload nginx
```

If nginx needs to be fully stopped for isolation:
```
sudo systemctl stop nginx
```

Use reload/**start**/stop carefully during testing so you can tell whether the spike is caused by **incoming traffic resuming** or by **the config state itself**.

---

## Practical interpretation

A pattern like this usually points to **traffic or bot pressure**:

- nginx workers are the top CPU consumers
- `strace` shows `accept4` / `recvfrom` / `sendfile`
- there are many established `:443` connections
- IPs are spread across many real public addresses
- logs show junk-path probing such as `/.env`

A pattern like this points more to **something else**:

- `strace` shows repeated file/path operations
- there are few real client connections
- logs are quiet or inconsistent
- config dump shows bad includes, rewrite loops, or path recursion
- one specific site/path causes CPU without corresponding external traffic volume

---

## Bottom line

To distinguish **bot traffic** from **internal nginx/app issues**, combine:

- process CPU checks
- `strace` on a hot worker
- live connection counts
- IP distribution snapshots
- access/error log inspection
- config dump review

That gives enough evidence to decide whether the problem is mainly **external request pressure** or **a misconfiguration / backend behavior problem**.

If you want, I can also turn this into a more formal **incident-analysis section** with headings like **Evidence of traffic-based overload**, **Evidence against config-loop theory**, and **Recommended next checks**.