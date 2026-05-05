
Want origin to take over cache control like 304 not modified so pull local cache? This prevents repeated pull of your cached request with the same visitor, and 304 shows up in their Network tab. Your Cloudflare security settings must bypass to the origin; refer to [[Cloudflare cache allow origin to take over]]

---

Want to harden against direct visits to your VPS IP? Allow only Cloudflare traffic to reach webhost. Refer to [[CloudPanel with Cloudflare - Only allow Cloudflare Traffic IP]]