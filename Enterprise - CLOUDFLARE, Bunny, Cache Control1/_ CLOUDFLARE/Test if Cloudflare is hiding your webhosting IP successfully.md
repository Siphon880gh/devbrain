One reason people use Cloudflare is to hide the IP address of their web host. This helps reduce direct attacks from scrapers, bots, and hackers. Cloudflare can also filter and block a lot of that bad traffic before it reaches your server.

But if attackers can still discover your web host’s real IP, they can bypass Cloudflare and attack the server directly instead of going through your domain. That would defeat a big part of the reason for using Cloudflare in the first place.

**How to test whether hackers can still find your web host IP:**

---

The main test is: **can anything outside Cloudflare still resolve or reach your origin directly?**

After putting a site behind Cloudflare, hackers usually still find the origin IP through one of these paths:
1. a **DNS-only** record still pointing to the same server
2. an **MX/mail** record on the same IP as the website
3. an old subdomain like `direct`, `origin`, `cpanel`, `server`, `dev`, etc.
4. the server still answering requests sent **straight to the origin IP** instead of only from Cloudflare’s IP ranges

Cloudflare’s docs are clear that only certain records are proxied, and that DNS-only records can expose the origin. They also note that if your mail server is on the same IP as the web server, the MX setup can reveal it. ([Cloudflare Docs](https://developers.cloudflare.com/dns/proxy-status/?utm_source=chatgpt.com "Proxy status - DNS"))

## What you should test

### 1) Confirm your public hostname resolves to Cloudflare, not your host IP

Run:

```bash
dig +short yourdomain.com
dig +short www.yourdomain.com
```

If Cloudflare is proxying properly, these should return **Cloudflare IPs**, not your VPS IP. Cloudflare proxies A, AAAA, and CNAME records when proxy status is enabled. ([Cloudflare Docs](https://developers.cloudflare.com/dns/proxy-status/?utm_source=chatgpt.com "Proxy status - DNS"))

You can also check with:

```bash
nslookup yourdomain.com
nslookup www.yourdomain.com
```

## 2) Look for DNS records that may still expose the origin

Check common subdomains:

```bash
for h in yourdomain.com www mail ftp cpanel webmail direct origin server dev staging api blog shop; do
  echo "=== $h.yourdomain.com ==="
  dig +short $h.yourdomain.com
done
```

Or, if `yourdomain.com` is already the root, use:

```bash
for h in yourdomain.com www.yourdomain.com mail.yourdomain.com ftp.yourdomain.com cpanel.yourdomain.com webmail.yourdomain.com direct.yourdomain.com origin.yourdomain.com server.yourdomain.com dev.yourdomain.com staging.yourdomain.com api.yourdomain.com blog.yourdomain.com shop.yourdomain.com; do
  echo "=== $h ==="
  dig +short $h
done
```

What you are looking for:

- if a hostname returns a **non-Cloudflare IP**
    
- and that IP is your VPS/origin IP
    
- then that hostname is leaking the origin
    

Cloudflare specifically warns that a DNS-only record pointing to the same origin as a proxied site exposes the origin IP. ([Cloudflare Docs](https://developers.cloudflare.com/dns/manage-dns-records/troubleshooting/exposed-ip-address/?utm_source=chatgpt.com "Exposed IP addresses - DNS records"))

## 3) Check MX and mail records

This is one of the biggest leak paths.

Run:

```bash
dig MX yourdomain.com +short
dig A mail.yourdomain.com +short
dig AAAA mail.yourdomain.com +short
```

If `mail.yourdomain.com` points to the **same IP as your web server**, then your origin is exposed through mail. Cloudflare documents this directly. ([Cloudflare Docs](https://developers.cloudflare.com/dns/manage-dns-records/how-to/email-records/?utm_source=chatgpt.com "Set up email records · Cloudflare DNS docs"))

## Important note

Even if nobody can discover the IP from DNS now, attackers may still know it from before. So the real protection is not just hiding the IP. The real protection is:
- do not expose origin through DNS
- do not put mail on the same IP as the web app
- restrict 80/443 to Cloudflare IPs only
- rotate the origin IP if it was already exposed before. If your webhosting provider doesnt allow to rotate your IP, the only other way is to reprovision/reformat your webhosting, wiping away the files and database