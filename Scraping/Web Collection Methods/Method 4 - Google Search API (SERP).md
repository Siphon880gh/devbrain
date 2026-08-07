Part of: [[_PRIMER - Four Ways to Scrape the Web]]

**Question it answers:** "What does Google rank for keyword Y?"  
**Input:** Keyword query  
**Output:** SERP JSON (organic, maps, shopping, scholar, etc. depending on provider)

---

## What it is

Google SERP APIs return **traditional search engine results** — organic listings, snippets, sometimes Maps, Shopping, or Scholar. Use them when you need keyword-ranked competitive intelligence, **not** semantic / natural-language discovery ([[Method 3 - AI Search]]).

---

## AI Search vs Google Search

| Need | Use |
|------|-----|
| Open-ended research question | AI Search (Tavily, Exa, Linkup) |
| "Who ranks #1–10 for `[keyword]`?" | Google Search API (Serper, SerpAPI) |
| Track SERP movement week over week | Google Search API |
| Find niche technical documentation | AI Search (Exa) or Google CSE scoped to docs domains |
| Avoid Google dependency entirely | Brave Search API |

→ [[FAQ - Web Collection Methods]]

---

## Two ways this vault already touched SERPs (different mechanism)

| Approach | What you get | Notes in vault |
|----------|--------------|----------------|
| **Dedicated SERP API** (this method) | Structured SERP JSON from Serper, SerpAPI, etc. | [[Providers - Google SERP APIs]] |
| **Scrape Google HTML** via URL scraper | HTML (or preset-parsed JSON) by fetching `google.com/search?...` | [[_PRIMER - Crawlbase API]] · [[Google SERP Url Optimization for Scraping]] · [[Quirk - Google SERP Captchas]] · [[Troubleshooting - Google SERP Captcha page html got scraped instead]] · [[Google SERP - Multiple pages]] (LocalScraper) |

Prefer official / dedicated SERP APIs when they cover the use case; HTML scraping Google is brittle (CAPTCHA pages, layout changes).

---

## Providers

→ [[Providers - Google SERP APIs]]

| Provider | Pricing (approx.) | Strength |
|----------|-------------------|----------|
| [Serper](https://serper.dev) | 2.5k free · $1/1k | Fast Google SERP JSON; cheapest raw Google results |
| [SerpAPI](https://serpapi.com) | $75/mo · 5k searches | 80+ engines and verticals (Maps, Shopping, Scholar, News) |
| [Brave Search](https://brave.com/search/api) | ~$5/1k | Independent index; no Google scraping dependency |
| [Bing Web Search](https://www.microsoft.com/en-us/bing/apis/bing-web-search-api) | ~$7/1k | Enterprise-friendly; Azure stack integration |
| [DataForSEO](https://dataforseo.com) | ~$0.60/1k | Pay-as-you-go SERP + SEO tooling suite |
| [SearchAPI.io](https://www.searchapi.io) | ~$4/1k | Multi-engine SERP (Google, Bing, YouTube) |
| [Scrapingdog](https://www.scrapingdog.com) | ~$1/1k | Budget Google SERP scraper; AI Overview support |
| [Google Custom Search (CSE)](https://developers.google.com/custom-search/v1/overview) | 100 free/day | Official Google API; requires `GOOGLE_CSE_API_KEY` + `GOOGLE_CSE_CX` |

**Environment variables:** `SERPER_API_KEY`, `SERP_API_KEY`, `BRAVE_API_KEY`, `BING_API_KEY`, `DATAFORSEO_LOGIN` + `DATAFORSEO_PASSWORD`, `SEARCHAPI_IO_KEY`, `SCRAPINGDOG_API_KEY`, `GOOGLE_CSE_API_KEY`, `GOOGLE_CSE_CX`

---

## BI scenarios

- **Share-of-voice tracking** — who owns page-one for your category terms
- **Competitor content gap analysis** — which topics they rank for that you do not
- **Local market mapping** — Maps results for geo-targeted service businesses
- **Review/reputation monitoring** — brand + "reviews" SERP snapshots
