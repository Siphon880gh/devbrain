Part of: [[_PRIMER - Four Ways to Scrape the Web]] · [[Pipeline - Discover, Fetch, Extract, then Summarize]]

---

**Search / discover** methods **find** pages:

- [[Method 3 - AI Search]] — natural-language → ranked URLs + snippets
- [[Method 4 - Google Search API (SERP)]] — keyword → SERP JSON

**Fetch / retrieve** methods **retrieve** known URLs:

- [[Method 1 - Direct HTTP Fetch]] — your HTTP client hits the URL
- [[Method 2 - URL Scraping API]] — provider fetches (and often renders) the URL for you

Treating discovery and fetch as the same operation is where most scrapers fail silently (snippets without verification, or empty shells because you skipped the right retrieval layer).

Related vault vocab: [[Vocabs - Fetch Tool, Headless Browser, User-Spoofing, Request header spoofing, etc]]
