Put your website behind Cloudflare before it ever goes public. Try not to expose a domain directly to your VPS or dedicated server first, because once your origin IP is visible, botnets can record it and later scan or attack the IP directly instead of going through your domain. If that already happened, whether you can rotate the IP without wiping or reprovisioning the server depends on your hosting provider. Some hosts make IP changes difficult, while others may offer it for an added fee.

Cloudflare helps because it has visibility across a large network of websites and can block many known bad IPs automatically. It can also challenge suspicious visitors to verify they are human. On top of that, it gives you country-level traffic insights and lets you block entire countries without manually tracking IP ranges. Many of these protections are available even on the free plan. Beyond security, Cloudflare also improves performance through features like caching.

Cloudflare also has a Zero Trust network that you can activate at free and paid tiers.

Refer to my Cloudflare notes.

---

In addition to putting your public domain early on Cloudflare:

**Checks:**
- Make sure you didn't turn off the default blocking AI training bots (at Overview), or the Bot flight mode (At Security -> Settings), any DDoS protections (same page)
- Make sure you have your DNS records proxied

**Harden:**
- Have Cloudflare block outside US traffic, referring to [[Countries - Restrict, block all other countries]]
- Set Cloudpanel to only accept Cloudflare traffic under the Traffic tab (Setting is at the very bottom). Refer to [[CloudPanel with Cloudflare - Only allow Cloudflare Traffic IP]]
- If you can see bot traffic still gets through Cloudflare, add **non-interactive Cloudflare challenge** on the app URL. If not good enough, you can add an **interactive Cloudflaer challenge**