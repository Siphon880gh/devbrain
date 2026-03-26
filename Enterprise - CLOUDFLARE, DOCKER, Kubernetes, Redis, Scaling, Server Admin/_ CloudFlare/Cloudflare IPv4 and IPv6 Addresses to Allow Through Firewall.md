## Setup Rules

Often times you want to block bot attacks by having Cloudflare with bot enabled and proxied to your website. So when bots visit your domain address, they never see your host's actual IP

But as a best practice, your hosting should be hardened by blocking all traffic other than SSH (so you can access terminal) and Cloudflare (so Cloudflare can send your website over to the client's web browser)

For that, your firewall should allow through also IPv4 and IPv6 Cloudflare addresses. They are published at:
- Official IPv4 and IPv6 addresses. Please note you may see the last updated as 2023 when it's 3/2026. This is normal. Cloudflare IPs tend to be very stable:
	- https://www.cloudflare.com/ips/
- If you need to dynamically script in the IPs, a more script friendly version is hitting these end points:
	- https://www.cloudflare.com/ips-v4
	- https://www.cloudflare.com/ips-v6

---

## Test hitting the server directly by IP

Using your VPS IP, test whether the site still responds when you bypass Cloudflare.

Basic test:

```bash
curl -I http://YOUR_ORIGIN_IP
curl -k -I https://YOUR_ORIGIN_IP
```

Then test with your domain as the Host header:

```bash
curl -I http://YOUR_ORIGIN_IP -H "Host: yourdomain.com"
curl -k -I https://YOUR_ORIGIN_IP -H "Host: yourdomain.com"
```

What this means:
- If this returns your real site, the origin is reachable directly.
- Ideally, direct IP access should fail, or return a deny page, or only allow Cloudflare IPs at the firewall/web server.

