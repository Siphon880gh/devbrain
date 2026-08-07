Companion quick ref: [[Quick Reference - All APIs by Method]] · FAQ: [[FAQ - Web Collection Methods]]

Related in this vault: [[Choosing a good scraper and or proxy]] · [[Vocabs - Fetch Tool, Headless Browser, User-Spoofing, Request header spoofing, etc]] · [[_PRIMER - Crawlbase API]] · [[Scraping into Big Data]] · [[__Scraping - Disclaimer - READ FIRST]]

---

## Why scraping still matters for business intelligence

Competitive intelligence is not guesswork. Pricing pages change overnight. Job postings signal product direction. Review sites reveal positioning gaps. SERP rankings tell you who owns the narrative in your category.

The hard part is not *knowing* you need data. It is choosing the right **collection method** for each job. A Fortune 500 pricing audit, a weekly competitor blog monitor, and a one-off market sizing report each call for different tooling.

Modern AI agents collapse this into a repeatable pipeline: **discover → fetch → extract → summarize**. See [[Pipeline - Discover, Fetch, Extract, then Summarize]]. But discovery and fetch are not the same operation — see [[Vocab - Discover vs Fetch]]. Treating them as the same is where most scrapers fail silently.

This primer breaks down the four methods every serious BI stack needs — and lists the APIs that power each one.

---

## The four-method framework

Think of web data collection in four layers:

| Method | Question it answers | Input | Output | Note |
|--------|---------------------|-------|--------|------|
| **Direct HTTP Fetch** | "I have a URL — give me the raw page" | Known URL | HTML, JSON, OpenAPI spec | [[Method 1 - Direct HTTP Fetch]] |
| **URL Scraping API** | "This URL is protected — fetch it for me" | Known URL | Rendered HTML / clean text | [[Method 2 - URL Scraping API]] |
| **AI Search** | "What exists on the web about X?" | Natural-language query | Ranked URLs + snippets | [[Method 3 - AI Search]] |
| **Google Search API** | "What does Google rank for keyword Y?" | Keyword query | SERP JSON (organic, maps, etc.) | [[Method 4 - Google Search API (SERP)]] |

Search methods **find** pages. Fetch methods **retrieve** them. AI-powered scrapers chain both.

**Decision table:** [[Decision Checklist - Which Collection Method]]

---

## Method 1: Direct HTTP Fetch

→ Full note: [[Method 1 - Direct HTTP Fetch]]

Direct HTTP fetch is the baseline: your server (or agent runtime) sends a `GET` request to a URL and reads the response body. Same family as the vault’s [[Vocabs - Fetch Tool, Headless Browser, User-Spoofing, Request header spoofing, etc|fetch tool]].

### When it works well

- Public API documentation (OpenAPI/Swagger JSON)
- Static marketing pages with no bot protection
- RSS feeds, sitemaps, and structured JSON endpoints
- Internal or partner APIs you are authorized to call

### When it breaks

- Rate limits tied to your IP
- Cloudflare, Akamai, or custom WAF challenges — see [[Bot Detections/403 Forbidden During Scraping, Probably Cloudflare detected you|Cloudflare 403]] and [[How to know if a website uses bot protection - Cloudflare]]
- JavaScript-rendered SPAs where the HTML shell is empty — often needs [[Headed vs Headless Scraping|headless]] or a [[Method 2 - URL Scraping API|URL Scraping API]]
- Geo-restricted content

### The fork: manual fetch vs. managed URL API

**Option A — Manual direct fetch with a rotating proxy**

You control the HTTP client. You add a `PROXY_URL` (or equivalent) so each request exits through a different residential or datacenter IP:

```
PROXY_URL="http://user:pass@proxy.example.com:8080"
```

Rotating proxies spread request volume across IPs so a single block does not kill your pipeline. Right path when you want full control over headers, cookies, retry logic, and parsing — and have engineering capacity to maintain it.

Providers: [[Providers - Rotating Proxies]] (Bright Data, Oxylabs, Webshare). Also in-vault: [[Crawlbase Proxy API]], [[Product Smart Proxies]].

**Option B — Web Scraping URL API** → [[Method 2 - URL Scraping API]]

### Security note

Production systems should always enforce **SSRF protection** on direct fetches — see [[Vocab - SSRF Protection (on Direct Fetch)]].

---

## Method 2: URL Scraping API (Web Scraping URL API)

→ Full note: [[Method 2 - URL Scraping API]]

A URL scraping API inverts the proxy problem. You send a target URL; the provider handles IP rotation, CAPTCHA solving, browser rendering, and anti-bot bypass. You get content back.

```
curl "https://api.scraperapi.com?api_key=KEY&url=https://competitor.com/pricing"
```

In this vault, [[_PRIMER - Crawlbase API|Crawlbase Crawling API]] is the same *category* (URL-in → content-out, proxies included). Also: [[_PRIMER - Oxylabs Web Scraper API]].

Providers catalog: [[Providers - URL Scraping APIs]]

### When to choose this over manual fetch + proxy

- Target sites use aggressive bot detection
- Pages require JavaScript rendering (React/Vue SPAs)
- You need results fast without building a headless browser farm
- Your team wants **one API call**, not a proxy + parser + retry stack

### Typical BI use cases

- Competitor pricing tables behind JS rendering
- Review aggregator pages with session tokens
- Job board listings that block datacenter IPs
- PDF or document portals that gate on cookies

---

## Method 3: AI Search

→ Full note: [[Method 3 - AI Search]]

AI search APIs are built for **LLM workflows**. You send a natural-language question; you get back citation-ready results — titles, URLs, and snippets optimized for downstream summarization.

This is not the same as pasting a URL into a fetch call. AI search answers: *"Who are the top coworking operators in Austin and what do they charge?"*

Providers: [[Providers - AI Search APIs]] (Tavily, Exa, You.com, Linkup, Perplexity, Jina)

How it powers an AI scraper: [[Pipeline - Discover, Fetch, Extract, then Summarize]]

---

## Method 4: Google Search via API

→ Full note: [[Method 4 - Google Search API (SERP)]]

Google SERP APIs return **traditional search engine results** — organic listings, snippets, sometimes Maps, Shopping, or Scholar depending on the provider. Use them when you need keyword-ranked competitive intelligence, not semantic discovery.

**Different from** scraping Google HTML via Crawlbase (`scraper=google-serp`) — see [[Google SERP Url Optimization for Scraping]] and [[Troubleshooting - Google SERP Captcha page html got scraped instead]]. Dedicated SERP APIs return structured SERP JSON without you owning the Google HTML scrape.

Providers: [[Providers - Google SERP APIs]]

### AI Search vs. Google Search — when to use which

| Need | Use |
|------|-----|
| Open-ended research question | AI Search (Tavily, Exa, Linkup) |
| "Who ranks #1–10 for `[keyword]`?" | Google Search API (Serper, SerpAPI) |
| Track SERP movement week over week | Google Search API |
| Find niche technical documentation | AI Search (Exa) or Google CSE scoped to docs domains |
| Avoid Google dependency entirely | Brave Search API |

### BI scenarios for Google SERP APIs

- **Share-of-voice tracking** — who owns page-one for your category terms
- **Competitor content gap analysis** — which topics they rank for that you do not
- **Local market mapping** — Maps results for geo-targeted service businesses
- **Review/reputation monitoring** — brand + "reviews" SERP snapshots

---

## Putting it together

See [[Pipeline - Discover, Fetch, Extract, then Summarize]] and [[Decision Checklist - Which Collection Method]].

The method you pick at each stage should match the failure mode you expect — not the method your team happened to set up first.

---

## Compliance and responsible collection

→ [[Compliance - Responsible Collection]] · [[__Scraping - Disclaimer - READ FIRST]]

---

## Agent infrastructure angle (FlexAgents)

At **FlexAgents**, internet access is first-class agent configuration — not an afterthought script. Operators configure:

- **Preferred URL fetch method** — Direct HTTP vs. Web Scraping URL API
- **Rotating proxy** — optional `PROXY_URL` for manual fetch paths
- **AI Search providers** — priority-ordered fallback across six agent-native APIs
- **Google Search providers** — eight SERP APIs with env-based key management

Agents do not guess how to reach the web. They inherit a governed, auditable stack: discover with search, retrieve with the right fetch layer, extract with the model, report with citations.
