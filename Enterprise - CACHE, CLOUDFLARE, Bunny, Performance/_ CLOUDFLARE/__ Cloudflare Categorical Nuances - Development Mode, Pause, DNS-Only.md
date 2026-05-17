Let's compare them by what gets bypassed, what still stays active, and when you’d use each during troubleshooting or migrations.

|Feature|Scope|What it bypasses|What still works|Best use case|
|---|--:|---|---|---|
|**Development Mode**|Whole site / zone|Cloudflare **edge cache** and Polish for about 3 hours|Cloudflare proxy, WAF, SSL/TLS, rules, security protections|You are editing CSS, JS, images, or cached pages and want to see changes immediately|
|**Pause Cloudflare**|Whole site / zone|Cloudflare’s **reverse proxy entirely**|DNS management still remains in Cloudflare|You want to test whether Cloudflare itself is causing a site-wide issue|
|**DNS-Only**|Individual DNS record|Cloudflare proxy for that hostname only|Cloudflare DNS still answers queries|You want one subdomain or record to go directly to origin, such as `upload.example.com` or a third-party validation record|

## 1. Development Mode

**Development Mode keeps Cloudflare in front of your site, but temporarily stops Cloudflare from serving cached static content.**

Cloudflare says Development Mode temporarily suspends edge caching and Polish features for three hours unless you disable it earlier. It helps you immediately see changes to cacheable content like images, CSS, and JavaScript. It does **not** purge cached files; it just bypasses cache temporarily. ([Cloudflare Docs](https://developers.cloudflare.com/cache/reference/development-mode/ "Development Mode · Cloudflare Cache (CDN) docs"))

Use this when:

```txt
You changed CSS/JS/images
Your WordPress theme changes are not showing
You want to test whether Cloudflare cache is the problem
```

Important: **Development Mode does not disable Cloudflare security.** Cloudflare specifically says it bypasses cache while preserving services like Rules, WAF, and SSL/TLS certificates. ([Cloudflare Docs](https://developers.cloudflare.com/fundamentals/manage-domains/pause-cloudflare/ "Pause Cloudflare · Cloudflare Fundamentals docs"))

So the traffic path is still:

```txt
Visitor → Cloudflare → Your origin server
```

**To toggle on/off Development Mode:**
Under Domains -> Overview, select your domain's ... menu -> Enable Development Mode
![[Pasted image 20260415054910.png]]

## 2. Pause Cloudflare

**Pause Cloudflare removes Cloudflare’s reverse proxy for the whole site.**

Cloudflare says pausing Cloudflare sends traffic directly to your origin web server instead of through Cloudflare’s reverse proxy. Paused domains cannot use Cloudflare services like Rules, WAF, and SSL/TLS certificates. ([Cloudflare Docs](https://developers.cloudflare.com/fundamentals/manage-domains/pause-cloudflare/ "Pause Cloudflare · Cloudflare Fundamentals docs"))

Traffic path becomes:

```txt
Visitor → Your origin server
```

Use this when:

```txt
You suspect Cloudflare proxy/security/SSL/rules are breaking the site
You need to test the origin directly
You want to quickly bypass Cloudflare without changing nameservers
```

Cloudflare says pausing usually takes five minutes or less and is preferable to changing nameservers, which can involve longer DNS propagation delays. ([Cloudflare Docs](https://developers.cloudflare.com/fundamentals/manage-domains/pause-cloudflare/ "Pause Cloudflare · Cloudflare Fundamentals docs"))

Big warning: if your origin only has a **Cloudflare Origin CA certificate**, visitors may get certificate errors when Cloudflare is paused, because Cloudflare Origin CA certificates are trusted between Cloudflare and your origin, not directly by browsers. ([Cloudflare Docs](https://developers.cloudflare.com/ssl/origin-configuration/origin-ca/troubleshooting/ "Troubleshooting Cloudflare origin CA · Cloudflare SSL/TLS docs"))

**To toggle Pause/Unpause:**
- Requirement: Your account then your domain already selected
- Under Overview -> Pause/Unpause Cloudflare (Bottom right under Advanced Actions)
![[Pasted image 20260517042542.png]]
## 3. DNS-Only

**DNS-Only turns off Cloudflare proxy for one specific DNS record.**

This is the gray cloud setting. Cloudflare DNS still manages the record, but Cloudflare does not proxy HTTP/HTTPS traffic for that hostname. Cloudflare says DNS-only records resolve to the actual origin IP address and do not route HTTP/HTTPS traffic through Cloudflare’s network. ([Cloudflare Docs](https://developers.cloudflare.com/dns/proxy-status/ "Proxy status · Cloudflare DNS docs"))

Example:

```txt
example.com          Proxied
www.example.com      Proxied
upload.example.com   DNS only
mail.example.com     DNS only
```

Traffic for `upload.example.com` becomes:

```txt
Visitor → Your origin server
```

But traffic for `www.example.com` can still be:

```txt
Visitor → Cloudflare → Your origin server
```

Use DNS-Only when:

```txt
A specific subdomain must bypass Cloudflare limits
A third-party service requires direct DNS validation
You are pointing a subdomain to another provider/CDN
You want an upload endpoint to avoid Cloudflare request size or timeout limits
```

The tradeoff: DNS-Only exposes your origin IP for that record. Cloudflare says DNS-only records return the actual origin IP address, which removes a layer of protection and prevents Cloudflare from providing HTTP/HTTPS analytics for those requests. ([Cloudflare Docs](https://developers.cloudflare.com/dns/proxy-status/ "Proxy status · Cloudflare DNS docs"))

**Toggling Proxy (therefore toggling DNS-Only):**
- Requirement: Your account then your domain already selected
- Under DNS -> Records
![[Pasted image 20260328054915.png]]

Then when editing a record, you can proxy or dns-only:
![[Pasted image 20260328055901.png]]

---

## Simple mental model

```txt
Development Mode = Keep Cloudflare on, bypass cache only.

Pause Cloudflare = Turn Cloudflare proxy off for the whole site.

DNS-Only = Turn Cloudflare proxy off for one DNS record.
```

## Which one should you use?

For most normal website edits, use:

```txt
Development Mode
```

For troubleshooting a full-site Cloudflare issue, use:

```txt
Pause Cloudflare
```

For bypassing Cloudflare on only one hostname, use:

```txt
DNS-Only
```

For your kind of server setup, the safer debugging order is usually:

```txt
1. Purge cache or enable Development Mode
2. Check Cloudflare Rules / WAF / SSL mode
3. Temporarily set only the affected subdomain to DNS-Only
4. Pause Cloudflare only if you need a full-site bypass
```

The most dangerous one from an origin-IP exposure standpoint is **DNS-Only** or **Pause Cloudflare**, because visitors connect directly to your server instead of Cloudflare. Development Mode is usually the safest because Cloudflare stays in front.