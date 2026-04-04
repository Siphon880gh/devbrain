Proxied means it will show Cloudflare IP if your domain is looked up. Thus attacks won’t hit your web-host directly causing CPU spike and website crash. Instead it will hit Cloudflare who has an extensive list of suspicious IPs and can immediately block them at the edge before ever reaching your web-host. Unfortunately if your web host’s IP is mined before you added Cloudflare, then you still need to change web host IP (and hopefully the web host provider makes it easy for you to simply rotate IP without having to reformat all your files).

DNS only does not have that protection. Your web host IP shows right away when your domain is scanned.

Unfortunately not all record types can support proxy. For example, MX can only support DNS-only, and therefore you want your email servers to have a separate IP than your web host IP.

Downside or proxied is you can’t have custom ports working on the web browser / curl / etc. For custom ports (eg. [https://domain.com:12345/),](https://domain.com:12345/\),) you’ll have to stick with DNS only.

---

**Example Proxied:**
![[Pasted image 20260328054915.png]]

And more:
![[Pasted image 20260328055325.png]]

Note did not include AAAA records for IPv6. But if you were to do that, create AAAA records for subdomain(s) and domain, and use the IPv6 numerical address that your web-host provides.

---

**Toggling Proxy on and off (therefore DNS-Only):**
![[Pasted image 20260328055901.png]]

---

**Example DNS-Only:**
![[Pasted image 20260328055927.png]]