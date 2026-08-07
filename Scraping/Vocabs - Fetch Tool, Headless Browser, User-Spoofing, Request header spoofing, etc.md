  

A **fetch tool** is a **HTTP client** that sends requests directly to a server, similar to `curl`, Python `requests`, Axios, or `fetch()`. To a server meaning an URL with either a numeric IP or a domain address and it can be a full path like `https://example.com/something` 


Maps to BI Method 1: [[Method 1 - Direct HTTP Fetch]]. When the target is protected/JS-heavy, escalate to [[Method 2 - URL Scraping API]] instead of only spoofing headers. Discovery (finding URLs) is a different layer: [[Vocab - Discover vs Fetch]] · [[Method 3 - AI Search]] · [[Method 4 - Google Search API (SERP)]]. Agent fetch stacks should also enforce [[Vocab - SSRF Protection (on Direct Fetch)]].

---

A **headless browser** is different: it runs a real browser engine—such as Chromium—without displaying a visible window. Examples include:

- Playwright
- Puppeteer
- Selenium with headless Chrome
- Browserless

It can execute JavaScript, accept cookies, maintain sessions, render pages, and interact with buttons or forms. It’s used when you need to automate interactions without an API access or you need to automate interactions to reach where the information you need to scrape is at

---

When a non-browser tool like fetch tool, while merely tries to look like a browser, the common terms are:

- **User-agent spoofing** — sending a Chrome or Safari `User-Agent` header.
- **Browser impersonation** — imitating a browser’s broader network behavior, headers, TLS fingerprint, HTTP/2 settings, and request order.
- **Browser emulation** — reproducing some browser capabilities without necessarily running a complete browser.
- **Request/header spoofing** — copying headers such as `Accept`, `Accept-Language`, `Referer`, and client hints.

So the distinction is:

> **HTTP fetcher:** directly downloads the response.  
> **Browser-like fetcher:** spoofs browser headers or fingerprints.  
> **Headless browser:** actually runs a browser engine invisibly.
>
