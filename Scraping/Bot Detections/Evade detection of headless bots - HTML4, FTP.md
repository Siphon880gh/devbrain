HTML-based scraping typically requires downloading the full web page, including the `<head>` and `<body>`, and often waiting for JavaScript to render dynamic content. This can limit concurrency (e.g., to 4 pages at a time) to avoid triggering rate limits or being blocked.

In contrast, FTP allows direct access to files and supports parallel downloads (e.g., 10 or more files concurrently), making it a faster and more scalable option when available.

---

## 🕳️ Nonstandard Protocol & Legacy Tech Evasion Tactics

### 🧾 **1. HTML4 (and "minimalist" HTML)**

**Why it can help:**

- Many modern bot detectors rely on **JavaScript execution, fingerprinting APIs, and dynamic content detection**.
    
- An HTML4 or JS-free crawler **avoids triggering those scripts altogether**.
    
- No `<script>`, no `navigator`, no fingerprint entropy — just raw HTTP + HTML parsing.
    

**Used by:**

- Simple content scrapers that don’t need to interact with JavaScript-rendered pages.
    
- Tools like `wget`, `curl`, or custom HTTP clients that read plain HTML.
    

**Limitations:**

- Won’t work on modern SPAs or sites behind JS-based bot walls (e.g., Cloudflare JavaScript challenge).
    
- You’re limited to static or server-rendered content.
    

**Example tactic:**

```bash
curl -A "Lynx/2.8.9rel.1 libwww-FM/2.14 SSL-MM/1.4.1" https://target.com
```

Using a minimalist user-agent to blend in with legacy or accessibility tools.

---

### 📁 **2. FTP (File Transfer Protocol)**

**Why it can help:**

- **Bypasses HTTP/S** entirely.
    
- If a server or system exposes data via FTP (e.g., logs, public files, product feeds), there's no browser, JS, or fingerprinting involved.
    
- It’s raw file transfer — nothing to trigger bot protection.
    

**Used for:**

- **Passive data collection** (e.g., downloadable `.csv`, `.xml`, or `.zip` files)
    
- Backdoor access when a company hosts public datasets on FTP servers (e.g., public procurement, ecommerce feeds, archival content)
    

**Limitations:**

- Most websites don’t expose FTP anymore.
    
- No dynamic interaction; you're just downloading files.
    
- Unlikely to work on modern, secured applications.
    

**Example tactic:**

```bash
ftp ftp://ftp.example.com/public/data.zip
```

---

## ✅ Use Cases Where These Tactics Still Work

|Tactic|When It Helps|
|---|---|
|**HTML4-only requests**|When you want to avoid JS-based bot detection (basic scraping only)|
|**FTP access**|When large datasets are hosted outside the main HTTP infrastructure|
|**Legacy browser emulation**|To simulate screen readers or extremely low-feature clients|

---

## ⚠️ Caveats

- These aren't silver bullets — they **only work when the site or data is accessible in this format**.
    
- Most **modern bot protection assumes a JS-capable, modern browser** — so **being "too simple" can ironically help you** go unnoticed.
    
- Think of this as **"low-tech stealth"**: avoid detection by staying outside of the detection surface entirely.
    
=
---

Let me know if you want to test minimalist crawlers, simulate Lynx or cURL-only access, or build an "HTML4-mode" crawler script.=