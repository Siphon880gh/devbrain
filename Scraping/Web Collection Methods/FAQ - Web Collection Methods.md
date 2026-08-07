Primer: [[_PRIMER - Four Ways to Scrape the Web]]

Useful for schema markup / FAQ blocks in the published article draft.

---

## What is the difference between AI search and Google SERP API?

AI search APIs accept natural-language questions and return citation-ready snippets optimized for LLM workflows ([[Method 3 - AI Search]]).

Google SERP APIs return keyword-ranked search engine results (organic listings, maps, shopping) for competitive ranking analysis ([[Method 4 - Google Search API (SERP)]]).

---

## When should I use a URL scraping API instead of a rotating proxy?

Use a [[Method 2 - URL Scraping API|URL scraping API]] when targets have bot protection, require JavaScript rendering, or when you want a single API call without managing proxies, headless browsers, and retry logic yourself.

Use [[Method 1 - Direct HTTP Fetch]] + [[Providers - Rotating Proxies|rotating proxy]] when you want full control over headers, cookies, retries, and parsing.

---

## How do AI-powered scrapers combine these methods?

Typical flow ([[Pipeline - Discover, Fetch, Extract, then Summarize]]):

**AI Search or Google SERP API** (discovery) → **Direct Fetch or URL Scraping API** (retrieval) → **LLM** (structured extraction) → report or alert output.
