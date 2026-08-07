# Providers — Google / Search Engine SERP APIs

Method: [[Method 4 - Google Search API (SERP)]] · Quick ref: [[Quick Reference - All APIs by Method]]

---

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

## Alternate path already in vault: scrape Google HTML

Not the same as a dedicated SERP API — you fetch `google.com/search?...` through a URL scraper:

- [[Google SERP Url Optimization for Scraping]]
- [[Quirk - Google SERP Captchas]]
- [[Troubleshooting - Google SERP Captcha page html got scraped instead]]
- [[Google SERP - Multiple pages]]
- Crawlbase preset `scraper=google-serp` in [[_PRIMER - Crawlbase API]]

Prefer official / dedicated SERP APIs when they cover the use case ([[Compliance - Responsible Collection]]).
