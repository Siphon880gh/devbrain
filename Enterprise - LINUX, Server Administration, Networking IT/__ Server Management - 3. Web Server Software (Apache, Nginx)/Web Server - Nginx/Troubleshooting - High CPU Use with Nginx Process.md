If you ran htop or top or ps aux... and found high cpu use degrading your server is due to nginx, there are several nginx related causes that need to be fixed.

---

**A lot of IP hits / traffic**. Are bots attacking you or you're getting DDoS? Diagnose with [[Diagnosing Bot Attacks - Detecting Traffic Bot Problems vs. Other Causes]]

**SSL/TLS Handshakes:** Encrypting and decrypting traffic is the most common reason for CPU consumption in Nginx. Perform a strace on the nginx process' PID to see if it's SSL/TLS related. You can copy the output to ChatGPT to ask. Malformed SSL configurations or issues with session ticket keys can cause the CPU to spike as it repeatedly fails and retries cryptographic operations.

**Logging**: Highly verbose access logs (e.g., main format with detailed metrics) can increase I/O and CPU overhead. 
- Update your one or more `log_format`'s in  `/etc/nginx/nginx.conf` to include `$request_time` and `$upstream_response_time`. This helps pinpoint slow URLs or resource-heavy SSL ciphers. Also you may consider simplifying the log format if it's writing too much
- Check your log files, which you can find the access and error log file paths for at `/etc/nginx/sites-enabled/*.conf`. Are they too large in file size? Maybe it's time to reset them. Also you may want to configure Nginx to create logs based on the date, if not done already.

**Bad looping config files**: Check your nginx config files from the `etc/nginx/nginx.conf` to your site's vhost `/etc/nginx/sites-enabled/*.conf` and any other conf files that your site's vhost has included with `include`. If it is consuming high CPU, it may be stuck in a loop attempting to reload a faulty configuration or repeatedly restarting failing worker processes. Copy the vhost/conf to ChatGPT to check for loops or bad config that can inflate the CPU use.

**Upstream Retries & Timeouts:** NGINX may consume significant CPU cycles if it is repeatedly attempting to connect to an unresponsive or crashing upstream server (like PHP-FPM or a database). Even without external traffic, internal health checks or retry loops can spike usage.

**Optimize Worker Processes**: Ensure worker_processes is set to auto or matches your number of CPU cores. Setting this too high can cause unnecessary context switching. 

**Container Limits:** In Kubernetes or Docker, if NGINX detects more cores on the host than are assigned to its container, it may attempt to rotate workers inefficiently, leading to 100% usage spikes.

**Microservices**: Your gunicorn should be optimized to match the traffic or the kind of processing your web app or api is performing, eg. concurrency or cpu-bound

 **CPU Steal?** Does your VPS provider like to steal your CPU's resources and spread them to other customers? Read Reddit for those reports. You'd talk to chat support to migrate to another node, or you can upgrade to dedicated server, or choose another webhost provider.

---

There are ways to improve CPU efficiency with Nginx, but they are **NOT the main fixes for high CPU use**. They are just good practices for performance and low CPU use:
- compression
- throttling
- caching. 
	- Though with compression, you may want a low level of compression if the CPU is not the strongest.