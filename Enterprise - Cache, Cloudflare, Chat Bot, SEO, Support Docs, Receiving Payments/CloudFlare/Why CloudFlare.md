Many companies take advantage of Cloudflare’s free features, including SSL certificates, basic DDoS protection, IP blocking, and human verification (to prevent automated bots from scraping your content). Even on the free plan, Cloudflare provides basic analytics—showing total visits, unique visitors, and the countries they’re coming from.

- For a table comparison of the types of visitor stats among the free versus paid tiers, refer to [[Cloudflare Visitor Statistics - Free vs Paid Plans]]

Larger businesses often upgrade to paid plans to unlock features like regional caching, though basic caching is available on all tiers. If you're on the **Pro Plan**, Cloudflare’s **Polish** feature can automatically optimize and compress images—using either **lossless** or **lossy** compression—to reduce file sizes, save bandwidth, and improve page load times.

Additionally, Cloudflare maintains a global IP reputation system. If an IP address has already been verified as safe on another Cloudflare-protected site, that trust can carry over—streamlining access and reducing friction for legitimate users. At the same time, it helps flag suspicious behavior such as VPN usage or rapid IP rotation often associated with scraping or attacks.

---

In your own experience of visiting many websites, you may encounter a Human Verification page from Cloudflare:

![[Pasted image 20250513051753.png]]

---

And relatedly to that, instead of verifying for a human, Cloudflare can straight up block bots from scraping - or from hacking.

You gain protection against automated bots scanning for vulnerabilities. Cloudflare uses data from millions of connected sites to detect and block malicious IPs before they reach your server.


---

The SiteGround WordPress plugin keeps showing the same IP address repeatedly attempting to access wp_login or other parts of WordPress. If you were using Cloudflare, that IP likely would’ve already been blocked—because Cloudflare monitors malicious activity across millions of websites (free and paid Cloudflare users alike). When hackers use services that rotate IPs, those addresses often get flagged quickly due to repeated attack patterns seen across the network.

---

Rumors are they will be aggressive about contacting you to upgrade to enterprise

[https://youtu.be/8zj7ei5Egk8](https://youtu.be/8zj7ei5Egk8)