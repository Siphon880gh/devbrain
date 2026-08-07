Part of: [[Method 1 - Direct HTTP Fetch]] · [[_PRIMER - Four Ways to Scrape the Web]]

---

**SSRF** (Server-Side Request Forgery) risk: an agent or scraper that can fetch **arbitrary URLs** may be tricked into hitting internal hosts (private IPs, cloud metadata endpoints, localhost services).

For production [[Method 1 - Direct HTTP Fetch|direct HTTP fetch]] systems:

- Block private / link-local IP ranges
- Block cloud metadata endpoints
- Prefer allowlisted hosts over open URL fetch
- Never let an agent fetch arbitrary internal URLs

URL Scraping APIs ([[Method 2 - URL Scraping API]]) move fetch off your network edge, but you still must not pass internal/private targets you are not entitled to reach.
