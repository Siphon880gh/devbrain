Part of: [[_PRIMER - Four Ways to Scrape the Web]]

Companion: [[Choosing a good scraper and or proxy]] (pricing, UI vs code, CAPTCHA, sync/async)

---

| Situation | Recommended method |
|-----------|-------------------|
| Known public API spec URL | [[Method 1 - Direct HTTP Fetch]] |
| Known URL, bot-protected or JS-rendered | [[Method 2 - URL Scraping API]] (ScraperAPI, ZenRows; also [[_PRIMER - Crawlbase API|Crawlbase Crawling API]]) |
| Known URL, rate-limited, you want control | Direct Fetch + rotating proxy → [[Providers - Rotating Proxies]] |
| Open-ended market/competitor question | [[Method 3 - AI Search]] (Tavily, Exa, Linkup) |
| Keyword ranking / SERP tracking | [[Method 4 - Google Search API (SERP)]] (Serper, SerpAPI, Brave) |
| Scoped search within specific domains | Google Custom Search (CSE) — listed under [[Providers - Google SERP APIs]] |
| Full agent pipeline | AI Search → URL API → LLM extraction → [[Pipeline - Discover, Fetch, Extract, then Summarize]] |

Pick the method that matches the **failure mode you expect**, not the method your team set up first.
