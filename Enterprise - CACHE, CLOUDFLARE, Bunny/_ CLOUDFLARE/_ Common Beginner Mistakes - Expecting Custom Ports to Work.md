Let's say you develop apps at port 3000's or 5000's on your VPS or dedicated server. Your website is behind Cloudflare.

You can't simply expect domain.tld:5000 to work. Cloudflare just won't allow custom ports to work! No settings around it.

---

When you try IP: X.XX.XX.XX:5000 then it works because it's going to your webhost directly rather than through Cloudflare's Proxied DNS.

---

**Cloudflare is proxying the domain**  
Cloudflare only proxies certain ports, and **5000 is not one of them**. Supported HTTP proxy ports include 80, 8080, and 8880; supported HTTPS proxy ports include 443 and 8443 (PHPMyAdmin.. https://domain.tld:8443/pma.). Port 5000 is not on that list and you cannot make 5000 available on Cloudflare in Proxy mode (the benefit of hiding your web host’s IP).

  
Instead, use one of these faster paths:
- **Best dev workflow:** keep your Flask app on `127.0.0.1:5000`, then put **Nginx** in front of it on **80, 443, in other words do a reverse proxy / proxy bypass**.
- Another way use **Cloudflare Tunnel**. Cloudflare Tunnel is specifically meant to expose a server’s locally running app for development without opening inbound public ports, and Cloudflare has a guide for previewing local projects that way. The `cloudflared` daemon makes outbound-only connections to Cloudflare instead of requiring direct inbound exposure. For how to setup Cloudflare Tunnel, refer to: [[_ Common Need - Cloudflare Tunneling]]