Put your website behind Cloudflare before it ever goes public. Try not to expose a domain directly to your VPS or dedicated server first, because once your origin IP is visible, botnets can record it and later scan or attack the IP directly instead of going through your domain. If that already happened, whether you can rotate the IP without wiping or reprovisioning the server depends on your hosting provider. Some hosts make IP changes difficult, while others may offer it for an added fee.

Cloudflare helps because it has visibility across a large network of websites and can block many known bad IPs automatically. It can also challenge suspicious visitors to verify they are human. On top of that, it gives you country-level traffic insights and lets you block entire countries without manually tracking IP ranges. Many of these protections are available even on the free plan. Beyond security, Cloudflare also improves performance through features like caching.

Cloudflare also has a Zero Trust network that you can activate at free and paid tiers.

Refer to my Cloudflare notes.