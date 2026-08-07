# Primer — Oxylabs Web Scraper API

Category: [[Method 2 - URL Scraping API]] (URL-in → managed fetch/render)  
Also sells rotating proxies: [[Providers - Rotating Proxies]]  
Framework: [[_PRIMER - Four Ways to Scrape the Web]]

---

Oxylabs sits in two places in the four-method model:

1. **Web Scraper API** — managed URL scraping (handles proxies / anti-bot / rendering for you). Same *job* as ScraperAPI, ZenRows, and [[_PRIMER - Crawlbase API|Crawlbase Crawling API]].
2. **Proxy / residential network** — for [[Method 1 - Direct HTTP Fetch]] when you keep the HTTP client yourself.

From the BI provider tables (approx. pricing as of the Untitled draft):

| Role | Tier / note | Best for |
|------|-------------|----------|
| Rotating proxy | Premium (~$300+/mo) | SERP + e-commerce at scale |
| Web Scraper API | Trial / free credits called out in [[Choosing a good scraper and or proxy]] (as of 6/2025) | Sync vs async jobs; job_id + result endpoints |

Choosing criteria (rate limits, sync/async, CAPTCHA, residential vs datacenter): [[Choosing a good scraper and or proxy]]

Quick catalog: [[Providers - URL Scraping APIs]] · [[Quick Reference - All APIs by Method]]
