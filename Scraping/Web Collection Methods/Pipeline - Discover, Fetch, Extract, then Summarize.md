Part of: [[_PRIMER - Four Ways to Scrape the Web]]

Also see: [[Vocab - Discover vs Fetch]] · [[Scraping is usually automated - Fundamental]] · [[Scraping into Big Data]]

---

## Composition

```
Business question
       ↓
  [AI Search or Google SERP API]  ← discovery
       ↓
  Ranked URLs + snippets
       ↓
  [Direct Fetch OR URL Scraping API]  ← retrieval
       ↓
  Full page content
       ↓
  [LLM extraction + validation]
       ↓
  Structured BI report
```

| Stage | Methods |
|-------|---------|
| Discovery | [[Method 3 - AI Search]] or [[Method 4 - Google Search API (SERP)]] |
| Retrieval | [[Method 1 - Direct HTTP Fetch]] or [[Method 2 - URL Scraping API]] |
| Extract / summarize | LLM (outside pure scrape tooling; feeds [[Scraping into Big Data|storage / BI]]) |

Search methods **find** pages. Fetch methods **retrieve** them. AI-powered scrapers chain both.

---

## Example — weekly competitor pricing monitor

1. Google SERP API: confirm competitor pricing page still ranks for brand + "pricing"
2. URL Scraping API: fetch rendered pricing table (JS-heavy site)
3. LLM: extract plan names, prices, feature bullets into JSON
4. Diff against last week; alert on changes

---

## Example — new market entry research

1. AI Search: *"Top B2B SaaS competitors in [vertical] with public pricing"*
2. Direct Fetch: pull `/pricing` and `/about` for each discovered domain
3. LLM: synthesize positioning matrix
4. Google SERP API: validate which players actually rank for buyer-intent keywords

---

## Failure modes

- Discovery without fetch → summaries without primary-source verification
- Fetch without discovery → only works if every URL is already known (monitoring, not open-ended research)
- Wrong fetch layer → silent empty shells (SPA) or CAPTCHA HTML mistaken for content — see Crawlbase SERP CAPTCHA troubleshooting notes under [[Method 4 - Google Search API (SERP)]]
