Part of: [[_PRIMER - Four Ways to Scrape the Web]]

**Question it answers:** "This URL is protected — fetch it for me"  
**Input:** Known URL  
**Output:** Rendered HTML / clean text

---

## What it is

You send a target URL; the provider handles IP rotation, CAPTCHA solving, browser rendering, and anti-bot bypass. You get content back.

```
curl "https://api.scraperapi.com?api_key=KEY&url=https://competitor.com/pricing"
```

This **inverts** the proxy problem vs [[Method 1 - Direct HTTP Fetch]] + self-managed proxies.

---

## When to choose this over manual fetch + proxy

- Target sites use aggressive bot detection — [[Bot Detections/_Directory - Websites with bot protection|_Directory - bot protection]] · [[Evade detection of headless bots]]
- Pages require JavaScript rendering (React/Vue SPAs)
- You need results fast without building a headless browser farm ([[Puppeteer]], [[_PRIMER - Scraper Libraries - Puppeteer, Scrapy, Selenium, Playwright|scraper libraries]])
- Your team wants **one API call**, not a proxy + parser + retry stack

---

## Typical BI use cases

- Competitor pricing tables behind JS rendering
- Review aggregator pages with session tokens
- Job board listings that block datacenter IPs
- PDF or document portals that gate on cookies

---

## Providers

→ [[Providers - URL Scraping APIs]] (ScraperAPI, ZenRows)

**Already deep in this vault (same category):**

- [[_PRIMER - Crawlbase API]] — URL-in / HTML-or-structured-out; proxies included in Crawling API
- [[_PRIMER - Oxylabs Web Scraper API]]
- [[_PRIMER - Crawlbase Crawler (Cursorily)|Crawlbase Crawler (wizard)]]
- Contrast: [[Crawlbase API vs Crawlbase Crawler]]

Env keys commonly used for ScraperAPI / ZenRows: `SCRAPER_API_KEY`, `ZENROWS_API_KEY`

---

## Related

- FAQ: [[FAQ - Web Collection Methods]] (URL API vs rotating proxy)
- Decision table: [[Decision Checklist - Which Collection Method]]
- Choosing criteria: [[Choosing a good scraper and or proxy]]
