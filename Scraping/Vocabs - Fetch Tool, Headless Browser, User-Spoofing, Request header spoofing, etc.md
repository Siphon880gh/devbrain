  

A **fetch tool** is a **HTTP client** that sends requests directly to a server, similar to `curl`, Python `requests`, Axios, or `fetch()`. To a server meaning an URL with either a numeric IP or a domain address and it can be a full path like `https://example.com/something` 

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
