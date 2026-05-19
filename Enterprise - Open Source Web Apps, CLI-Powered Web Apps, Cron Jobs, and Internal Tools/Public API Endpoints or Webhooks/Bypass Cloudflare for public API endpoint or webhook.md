## How to bypass

**Behind Cloudflare?** You may need to create a bypass rule for that specific public API endpoint or webhook URL. See bypass instructions at [[Common - Turn off Cloudflare for a specific URL]] and your specific URL will be your public api or webhook

---

## Security Note
The tradeoff is that bypassing Cloudflare can expose your origin server’s real IP address. Once that IP is discovered, it can be added to botnet scan lists and targeted directly.

A safer approach is to use a **floating IP** if your hosting provider supports it. For example, providers like Hetzner offer floating IPs for a small monthly cost.

This gives you more flexibility if the exposed IP starts getting scraped, scanned, or attacked at high volume. If CPU usage ramps up because bots are hitting that IP directly, you can swap out the floating IP instead of exposing or replacing the server’s main IP.

This matters because replacing the main server IP can be disruptive. Depending on the provider, it may require reprovisioning the server, reinstalling Linux, or updating several DNS records.

It is even better if your public API server or webhook server is separate from your main website server, ideally on a completely different domain. That way, if you need to swap the floating IP, it does not disrupt your homepage, main website, or primary DNS setup.

You can take this even further by automating the recovery process. If your hosting provider supports it, you could write an automation script that purchases or attaches a new floating IP, updates the server/network configuration, and then updates the DNS records through an admin API.

The Cloudflare API fully supports creating and changing DNS records. You can automate this process using HTTP methods such as `POST`, `PATCH`, `PUT`, and `DELETE`, depending on whether you are creating a new DNS record, updating an existing one, replacing a record, or removing an old one.

For example, an automation workflow could swap the floating IP at the hosting provider, then use the Cloudflare API to update the related DNS record so the API or webhook domain points to the new IP. This gives you a faster response path if the exposed endpoint IP gets added to botnet scan lists.

This is not perfect protection, but it gives you an extra layer of flexibility when Cloudflare has to be bypassed for a public API endpoint or webhook.