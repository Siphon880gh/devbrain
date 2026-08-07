# Providers — Rotating Proxies (Direct HTTP Fetch)

Method: [[Method 1 - Direct HTTP Fetch]] · Quick ref: [[Quick Reference - All APIs by Method]]

Selection criteria: [[Choosing a good scraper and or proxy]] (residential vs datacenter, CAPTCHA, cost scaling)

---

Rotating proxies spread request volume across IPs so a single block does not kill your pipeline. Typical env pattern:

```
PROXY_URL="http://user:pass@proxy.example.com:8080"
```

| Provider | Tier | Best for |
|----------|------|----------|
| [Bright Data](https://brightdata.com) | Premium (~$500+/mo) | Enterprise-scale scraping, largest proxy pool |
| [Oxylabs](https://oxylabs.io) | Premium (~$300+/mo) | SERP + e-commerce at scale |
| [Webshare](https://webshare.io) | Budget (~$5+/mo) | Prototypes, low-volume BI jobs |

Also mentioned elsewhere in vault (Bright Data / Oxylabs): [[403 Forbidden During Scraping, Probably Cloudflare detected you]] · [[Scraping into Big Data]]

---

## In-vault proxy products (same role, different vendor)

- [[Crawlbase Proxy API]]
- [[Crawlbase Proxy API - Does not support images]]
- [[Product Smart Proxies]]
- [[Proxies - Setup on Local Scraper]]
- [[Proxies - Scraper presets that need proxies]]

Oxylabs also ships a managed scraper API (URL-in category): [[_PRIMER - Oxylabs Web Scraper API]] — that is [[Method 2 - URL Scraping API]], not raw proxy-only.
