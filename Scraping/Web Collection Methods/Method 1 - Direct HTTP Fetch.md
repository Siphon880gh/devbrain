Part of: [[_PRIMER - Four Ways to Scrape the Web]]

**Question it answers:** "I have a URL — give me the raw page"  
**Input:** Known URL  
**Output:** HTML, JSON, OpenAPI spec

Overlaps vault vocab: [[Vocabs - Fetch Tool, Headless Browser, User-Spoofing, Request header spoofing, etc|fetch tool / HTTP client]]

---

## What it is

Your server (or agent runtime) sends a `GET` (or other HTTP verb) to a URL and reads the response body — `curl`, Python `requests`, Axios, `fetch()`, etc.

---

## When it works well

- Public API documentation (OpenAPI/Swagger JSON)
- Static marketing pages with no bot protection
- RSS feeds, sitemaps, and structured JSON endpoints
- Internal or partner APIs you are authorized to call

---

## When it breaks

- Rate limits tied to your IP
- Cloudflare, Akamai, or custom WAF challenges → [[403 Forbidden During Scraping, Probably Cloudflare detected you]] · [[Well known bot detection services]]
- JavaScript-rendered SPAs where the HTML shell is empty → [[Headed vs Headless Scraping]] or escalate to [[Method 2 - URL Scraping API]]
- Geo-restricted content

---

## Fork: manual fetch + rotating proxy vs URL API

### Option A — Manual direct fetch with rotating proxy

You control the HTTP client. Set `PROXY_URL` (or equivalent) so each request exits through a different residential or datacenter IP:

```
PROXY_URL="http://user:pass@proxy.example.com:8080"
```

Use when you want full control over headers, cookies, retry logic, and parsing — and can maintain that stack.

→ [[Providers - Rotating Proxies]]  
→ In-vault proxy products: [[Crawlbase Proxy API]] · [[Product Smart Proxies]]  
→ Selection criteria: [[Choosing a good scraper and or proxy]]

### Option B — Hand off to a URL Scraping API

→ [[Method 2 - URL Scraping API]]

---

## Security: SSRF

Always enforce [[Vocab - SSRF Protection (on Direct Fetch)]] on direct fetches in production agent systems — block private IPs, metadata endpoints, and non-allowlisted hosts. Never let an agent fetch arbitrary internal URLs.
