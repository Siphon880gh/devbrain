
**With Cloudflare Flexible SSL, your origin website certificate can expire and public visitors may still see HTTPS working**.

But it is **not recommended**.

Cloudflare Flexible means:

```txt
Visitor → Cloudflare: HTTPS
Cloudflare → Your server: HTTP only
```

So Cloudflare does **not require an SSL certificate on your origin server** in Flexible mode. Cloudflare’s docs say Flexible makes the site only “partially secure” because the connection from Cloudflare to your origin uses HTTP, and “an SSL certificate is not required on your origin.” ([Cloudflare Docs](https://developers.cloudflare.com/ssl/origin-configuration/ssl-modes/flexible/?utm_source=chatgpt.com "Flexible - SSL/TLS encryption modes"))

## Why you probably should not rely on Flexible

Flexible can work, but it has problems:

1. **Cloudflare-to-server traffic is not encrypted.**  
    Anyone between Cloudflare and your VPS network path could theoretically inspect or tamper with that traffic.
    
2. **It can cause redirect loops.**  
    Your origin receives HTTP, while the visitor sees HTTPS. Apps like WordPress, Laravel, Express, and PHP apps may get confused and keep redirecting.
    
3. **It weakens your security model.**  
    Cloudflare itself recommends using **Full** or **Full (strict)** when possible to protect the connection to your origin. ([Cloudflare Docs](https://developers.cloudflare.com/ssl/origin-configuration/ssl-modes/?utm_source=chatgpt.com "Encryption modes - SSL/TLS"))
    

## Better setup for your case

Since you do **not** want to expose your VPS IP because of bots, do this instead:

```txt
Cloudflare proxy: ON
Cloudflare SSL mode: Full (strict)
Origin certificate: Cloudflare Origin Certificate
CloudPanel: import that cert
CloudPanel/nginx: allow Cloudflare IPs only
```

Cloudflare Origin CA certificates are made exactly for this: encrypting traffic between Cloudflare and your origin, and they work with Strict SSL mode. ([Cloudflare Docs](https://developers.cloudflare.com/ssl/origin-configuration/origin-ca/?utm_source=chatgpt.com "Cloudflare origin CA - SSL/TLS"))

## Practical answer

You **can** let the CloudPanel / Let’s Encrypt cert expire **only if**:

```txt
Cloudflare is orange-cloud proxied
Cloudflare SSL mode is Flexible
You do not care about origin HTTPS
No one accesses the origin directly
```

But the better move is:

```txt
Do not use Flexible long term.
Use Cloudflare Origin Certificate instead.
Set Cloudflare SSL/TLS to Full (strict).
```

That way, your public visitors still go through Cloudflare, your origin IP stays hidden in DNS, and the Cloudflare-to-origin connection is encrypted.