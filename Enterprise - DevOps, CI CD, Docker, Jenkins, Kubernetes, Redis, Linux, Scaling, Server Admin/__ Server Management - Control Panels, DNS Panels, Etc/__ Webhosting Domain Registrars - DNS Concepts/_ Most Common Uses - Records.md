## Cloudflare - Domain, Subdomains, and CNames:
- Make all Proxied
- Blurred out is my web-host's IP. Same IP for subdomain and domain because I don't want to buy two separate web-host subscriptions.
![[Pasted image 20260328054915.png]]
- In addition, you may want these records too:
![[Pasted image 20260328055325.png]]

Note did not include AAAA records for IPv6. But if you were to do that, create AAAA records for subdomain(s) and domain, and use the IPv6 numerical address that your web-host provides.
## Cloudflare - Emails:
- Proxied not supported. Use DNS only
![[Pasted image 20260328055927.png]]

---

## Not Cloudflare?

**Why?!** Why don't you delegate your Domain Registrar (Namecheap, GoDaddy, etc) to Cloudflare? Cloudflare offers free web-host IP hiding, bot protection, and edge cache!

**But if you decide not to use Cloudflare:**
- **The records are all the same as above**. You just don't have control of Proxy or DNS only.
