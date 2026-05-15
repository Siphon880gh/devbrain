Cloudflare is very generous, especially on the free plan. By turning on the **proxied** orange-cloud setting for your DNS records, you can get access to useful features such as caching, bot protection, suspicious IP blocking, DDoS protection, WAF rules, redirects, and traffic analytics.

However, there is an important tradeoff: when your website traffic is routed through Cloudflare’s proxy, Cloudflare sits between the visitor and your origin server. That means uploads, downloads, and long-running requests have to follow Cloudflare’s proxy limits. Cloudflare’s own docs state that proxied records allow Cloudflare to optimize, cache, and protect traffic, while DNS-only records send traffic directly to the origin server instead. ([Cloudflare Docs](https://developers.cloudflare.com/dns/proxy-status/ "Proxy status · Cloudflare DNS docs"))

One common issue is **large file uploads**. On Cloudflare Free and Pro plans, the max upload size is **100 MB**. Business allows **200 MB**, and Enterprise allows **500+ MB**. Cloudflare also notes that these limits cannot be bypassed while the traffic is proxied. ([Cloudflare Docs](https://developers.cloudflare.com/cache/concepts/default-cache-behavior/ "Default Cache Behavior · Cloudflare Cache (CDN) docs"))

Another issue is request time. Cloudflare has a **Proxy Read Timeout** of **120 seconds** between Cloudflare and your origin server. If your server does not send a response within that time, Cloudflare can return a **524 timeout error**. Cloudflare says this timeout is configurable only for Enterprise zones. ([Cloudflare Docs](https://developers.cloudflare.com/fundamentals/reference/connection-limits/ "Connection limits · Cloudflare Fundamentals docs"))

So if your website lets users upload large files, such as videos, ZIP files, backups, or media files, you need to design around these limits. One use case that is problematic is Wordpress Migrations All-in-One because a simple one page scroller web developer website is already over 250mb and takes more than 120 seconds to restore/import from a backup file. This is less of a problem on the paid Wordpress Migrations All-in-One where you can bypass uploading through the web interface and just use FTP/SFTP.

A common workaround is **chunked uploads**. Instead of uploading one large 500 MB file in a single request, the browser splits it into smaller chunks, such as 10 MB, 25 MB, or 50 MB pieces. Each chunk is uploaded separately in the background, and then your server combines the chunks back into the original file. This does not make the user’s internet faster, but it makes the upload more reliable, easier to resume, and less likely to hit Cloudflare’s upload limit.

For information on this approach of chunked uploads, refer to:
- [[Performance Perceived - Split large file upload at client side]]
- [[Performance Perceived - Long Acting Tasks Should Not Block Website Experience (SSE or Web Socket)]]
- ^While the above articles focus on improving the user's perception of website performance, it coincidentally ties to more efficient use of uploading/fetching that can workaround the free Cloudflare's limitations.

Another option is to upload large files through a separate **DNS-only** subdomain, such as:

```txt
upload.example.com
```

That subdomain can point directly to your origin server instead of going through Cloudflare’s proxy.

The tradeoff is that this can expose your server’s real IP address. Once bots know your real VPS or dedicated server IP, they may attack it directly and bypass Cloudflare completely.

Even if you have a **server-side firewall**, your server can still get overwhelmed. The firewall may block bad requests, but your server still has to spend CPU and network resources processing those connections. If the traffic is heavy enough, your CPU can spike, **your server can still slow down.** 

With the high CPU use, your hosting provider may flag or suspend the server for abuse, suspicious activity, or “fraud” and they might not look into the proof you have that you're being attacked/scraped. And with the high CPU use that leads to a slow website, your business' reputation may be ruined, users might bounce back to Google search results and down affect your SEO, and your website could just crash for everyone else.

One possible workaround is to use a **floating IP**, if your hosting provider supports it (usually $1-2 more a month). Instead of pointing DNS records to your server’s main IP address (best if you have never done that alas you end up on a botnet's saved IPs list), you point them to the floating IP. That way, your real server IP is not exposed.

However, this is not perfect protection. You still need to watch for CPU spikes and unusual traffic. If bots start targeting your floating IP, you may be able to **replace it with another floating IP**. But this may only be a temporary fix. The botnet can rescan your website, discover the new IP, and add it back to its attack or scraping list.

You can also **upgrade your Cloudflare plan**, but even higher-tier plans still have limits. Upgrading gives you larger limits, not unlimited uploads. For example, Business increases the max upload size to 200 MB, while Enterprise starts at 500+ MB. ([Cloudflare Docs](https://developers.cloudflare.com/cache/concepts/default-cache-behavior/ "Default Cache Behavior · Cloudflare Cache (CDN) docs"))

The main lesson is:

```txt
Cloudflare’s proxy gives you powerful protection and performance features,
but proxied traffic must follow Cloudflare’s upload and timeout limits.
```

For normal websites, this is usually not a problem. But for apps that handle large uploads, long imports, video processing, backups, or file conversions, you should plan the upload architecture early. Use chunked uploads, background processing, direct-to-storage uploads, or a separate unproxied upload endpoint when needed.