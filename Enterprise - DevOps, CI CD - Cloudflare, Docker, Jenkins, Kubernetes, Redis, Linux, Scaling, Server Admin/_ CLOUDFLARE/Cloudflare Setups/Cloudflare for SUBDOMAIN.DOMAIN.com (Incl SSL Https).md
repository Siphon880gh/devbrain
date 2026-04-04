 This puts the **SUBDOMAIN** hostname behind Cloudflare’s proxy so TLS and most junk traffic terminate at Cloudflare instead of tying up your Hostinger nginx workers.

The tutorial also covers setting up the **DOMAIN** and **SSL/https for both domain and subdomain**

## Prerequisites

- A **Cloudflare** account ([dash.cloudflare.com](https://dash.cloudflare.com)).
- The **zone** for your domain must be on Cloudflare. Subdomains like `SUBDOMAIN.DOMAIN.com` live under the parent zone **`DOMAIN.com`** (you do **not** add a separate zone for the subdomain).
- Your **origin** server still runs nginx + PHP as today; Cloudflare only sits in front of DNS/HTTP.

## 1. Add or use the `DOMAIN.com` zone

- If **`DOMAIN.com` is already on Cloudflare**: go to **DNS → Records** and skip to step 2.
- If the domain is **only** on Hostinger DNS today:
1. In Cloudflare: **Add a site** → enter `DOMAIN.com`.
2. Cloudflare will scan existing records; **review** them so mail (MX), root domain, and other subdomains still point where they should.
3. Cloudflare will recommend adding two nameservers. At your **registrar** (or Hostinger), change **nameservers** to the two Cloudflare nameservers shown (e.g. `xxx.ns.cloudflare.com`). The instructions look like (your exact nameservers might vary):
   ![[Pasted image 20260328054253.png]]
     And in the case of Namecheap (yours could be GoDaddy, Hostinger, or any other DNS Registrar):
   ![[Pasted image 20260328054403.png]]
   
	Failure at this step looks like:
	![[Pasted image 20260328054539.png]]
	
**Wait for DNS propagation** (this can take anywhere from a few minutes to 48 hours). Until propagation finishes, Cloudflare proxying for newly added or changed records may not work everywhere yet.

You can check nameservers went thru anytime at CloudFlare:
![[Pasted image 20260328053736.png]]

> **Important:** Moving the whole domain to Cloudflare affects **all** DNS for `DOMAIN.com`. Plan so you don’t break email or other subdomains. You can add **all** current Hostinger DNS records into Cloudflare first, then switch nameservers.


## 2. DNS record for `DOMAIN.com` if not present

1. Cloudflare -> **your zone** `DOMAIN.com` -> **DNS** -> **Records**.
2. **Add record**:
- **Type:** `A` (or `AAAA` if you only have IPv6 on the server; often `A` is enough).
- **Name:** `@` (this means the root / apex domain `DOMAIN.com`).
- **IPv4 address:** your **server's public IP** (same one Hostinger uses for this VPS).
- **Proxy status:** **Proxied** (orange cloud **ON**).  
- **DNS only** (grey cloud) = traffic goes straight to your server; **no** protection from this guide.
1. Save.

Optional: remove or avoid a **duplicate** apex `A`/`CNAME` for `DOMAIN.com` elsewhere (e.g. old Hostinger DNS panel) once nameservers point to Cloudflare, so only Cloudflare's record matters.

## 3. DNS record for `SUBDOMAIN`

- Important: Subdomain setup happens in the same Cloudflare zone as the domain.
  
1. Cloudflare → **your zone** `DOMAIN.com` → **DNS** → **Records**.
2. **Add record**:
	- **Type:** `A` (or `AAAA` if you only have IPv6 on the server; often `A` is enough).
	- **Name:** `SUBDOMAIN` (Cloudflare fills in `SUBDOMAIN.DOMAIN.com`).
	- **IPv4 address:** your **server’s public IP** (same one Hostinger uses for this VPS).
	- **Proxy status:** **Proxied** (orange cloud **ON**).  
	- **DNS only** (grey cloud) = traffic goes straight to your server; **no** protection from this guide.
3. Save.

Optional: remove or avoid a **duplicate** `A`/`CNAME` for `SUBDOMAIN` elsewhere (e.g. old Hostinger DNS panel) once nameservers point to Cloudflare, so only Cloudflare’s record matters.
## 4. Spot Check

Cloudflare's DNS records could look like:
- Blurred out is my web-host's IP. Same IP for subdomain and domain because I don't want to buy two separate web-host subscriptions.
![[Pasted image 20260328054915.png]]

In addition, you may want these records too:
![[Pasted image 20260328055325.png]]

Note did not include AAAA records for IPv6. But if you were to do that, create AAAA records for subdomain(s) and domain, and use the IPv6 numerical address that your web-host provides.
## 5. SSL/TLS on Cloudflare (origin still uses your cert)

Traffic path: **Browser ↔ Cloudflare (HTTPS)** and **Cloudflare ↔ your nginx (HTTPS or HTTP)**.

1. Cloudflare → **SSL/TLS** → **Overview**.
2. Set mode to **Full** or **Full (strict)**:
- **Full:** origin can use a **self-signed** or any cert (less strict). In otherwords, at your webhost (eg. Hostinger) -> VPS -> CloudPanel, you could create a Let's Encrypt certificate, and Cloudflare will respect it.
- **Full (strict):** origin must present a cert **valid for the hostname** (e.g. Let’s Encrypt for `SUBDOMAIN.DOMAIN.com` or a SAN that includes it).  
   Your current vhost using the `DOMAIN.com` cert may work if the cert **covers** `SUBDOMAIN.DOMAIN.com`; otherwise issue a cert that includes the subdomain (CloudPanel / Hostinger / certbot).

If you use **Full** and the origin only listens on **443** with a valid LE cert, **Full (strict)** is the better choice once the hostname matches the certificate.

## 6. Quick checks after DNS propagates

From your laptop:

```bash
dig +short DOMAIN.com
dig +short SUBDOMAIN.DOMAIN.com
```

You should see **Cloudflare anycast** IPs (not your raw VPS IP) when the record is **proxied**.

```bash
curl -sI https://DOMAIN.com/ | head -5
curl -sI https://SUBDOMAIN.DOMAIN.com/ | head -5
```

Look for headers like **`cf-ray`**, **`server: cloudflare`** — confirms the request went through Cloudflare.

## 7. Origin nginx / Hostinger

- **No change required** to your subdomain vhost **logic** for basic operation: origin still receives `Host: SUBDOMAIN.DOMAIN.com` (Cloudflare forwards it).
- **Real client IP** in nginx access logs will be Cloudflare’s unless you restore the visitor IP. CloudPanel often documents **“real IP from Cloudflare”**; typically you set `set_real_ip_from` / `real_ip_header CF-Connecting-IP` (or use the panel toggle if present).
- Optional: firewall **allow 443 only from [Cloudflare IP ranges](https://www.cloudflare.com/ips/)** so random clients can’t bypass the proxy by hitting your origin IP directly (advanced; skip at first).

## 8. If something breaks

- **525** SSL handshake failed (origin): fix cert on nginx or use **Full** instead of **Full (strict)** temporarily.
- **526** invalid cert on origin: same as above.
- **Too many redirects:** check **SSL/TLS** mode and nginx **HTTP→HTTPS** rules; avoid **Flexible** if origin forces HTTPS (can cause redirect loops).

## 9. What you should see on the server after this

- **`ss` established on :443** on the **origin** should **drop** a lot (Cloudflare holds most client connections).
- **Nginx worker CPU** should be **much lower** under the same internet noise, because junk mostly hits Cloudflare’s edge.

---

## Checklist (short)

| Step | Action |
|------|--------|
| 1 | `DOMAIN.com` zone on Cloudflare; nameservers updated if needed |
| 2 | `A` record `SUBDOMAIN` → VPS IP, **Proxied** (orange) |
| 3 | SSL/TLS = **Full** or **Full (strict)**; origin cert matches hostname if strict |
| 4 | Verify `cf-ray` / Cloudflare via `curl -sI` |
| 5 | (Optional) Restore real client IP in nginx / panel |