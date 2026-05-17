
**Incident Report**

The website will not load, and I am also unable to access CloudPanel through its URL. When I checked Hostinger hPanel, I saw that CPU usage was at 100%. I was still able to access the server through SSH, where I observed two Nginx processes consuming 100% CPU.

At first, I believed the domain itself was being attacked by bots. Because of that, I signed up for Cloudflare and enabled its free protection features to help block malicious bot traffic. This assumption was based on reviewing Nginx behavior by first identifying the high-CPU process with `ps aux`, then tracing it with `strace` and writing the output to a log file for analysis.

However, Cloudflare did not resolve the issue. The server continues to receive repeated bot traffic directly to the VPS public IP address, causing CPU usage to spike to 100% for extended periods. This traffic bypasses Cloudflare entirely. Since I am already using Cloudflare, the problem does not appear to be traffic coming through the domain itself. The likely issue is that the VPS public IP has been exposed and is being targeted directly.

I have already tried several mitigation methods using firewall rules through `iptables`, UFW, and `nftables`. However, the request volume has been so high that the server still becomes overwhelmed processing and filtering the traffic, which results in timeouts. Even `nftables`, which is more efficient than UFW or `iptables`, has not been sufficient under this level of load when used to filter incoming requests. At one point, I observed approximately 270,000 bot hits within a single hour.

**Impact**

- Website unavailable
- CloudPanel inaccessible through URL
- CPU pinned at 100%
- Two Nginx processes consuming full CPU
- Server performance degraded to the point of repeated timeouts

**Ideal Resolution**  
The ideal resolution would be for Hostinger to assign a new VPS public IP without requiring a reinstall, server wipe, or full rebuild. Because the domain is now behind Cloudflare, a new origin IP would allow the server to remain hidden going forward, which should prevent direct bot traffic from continuing to hit the exposed IP address.

It is also important to note that my **MX records point to a mail server (rather than the VPS also acting as a mail server)**, so changing the VPS public IP for the web server should not affect mail routing. Since Cloudflare does not proxy MX records, those records will continue to point directly to the mail server as they already do. **TXT records also do not expose the VPS origin IP**, so they are not part of this issue.

**Current Limitation**  
My understanding is that Hostinger’s VPS platform may not support changing the public IP on an existing instance without reinstalling the operating system or creating a new VPS. Then this platform limitation makes it difficult to resolve an exposed-origin attack cleanly while keeping the current server intact.

I am asking because some VPS providers, such as RackNerd, appear to allow paid IP rotation or reassignment for a small fee. I would prefer to remain with Hostinger if there is any comparable option your team can provide.

**Less Optimal Workaround**  
Since a direct IP change is not possible, then the less optimal solution would be to provision a new VPS, migrate the content and services to that new server, and once the migration is complete, shut down or disconnect the old server. After that, I would update Cloudflare so the proxied DNS records point to the new VPS public IP, allowing the new origin to remain hidden behind Cloudflare protection.

That approach is possible, but it is more disruptive and time-consuming than simply rotating the public IP on the current VPS.

**Learning/Conclusion**  
To harden, if your VPS provider supports it, purchase the new IP rotation, then hide it under Cloudflare. If the VPS provider doesn’t support IP change requests (Hostinger as of 3/2026), perhaps consider another provider that does. 

Regardless, the new VPS should be placed behind Cloudflare immediately after setup—before any website is launched or allowed to be indexed. This helps keep the server’s public IP hidden from the start. Email should also be hosted on a separate server, since Cloudflare does not proxy MX records and therefore cannot prevent a mail server’s IP from being exposed.

---

So I decided to switch to a webhost that allows you to change IP or allows you to add floating IP. Regardless, Im going to never put the new IP on a DNS only record - and will put the new IP directly in a proxy record at Cloudflaer

[[Providers that allow you to change IP without wiping files]]