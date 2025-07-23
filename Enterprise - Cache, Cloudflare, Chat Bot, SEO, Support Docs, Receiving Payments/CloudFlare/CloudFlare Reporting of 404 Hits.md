## ❓ Can Cloudflare Track 404 Errors? (And What Does “Top Path” Mean?)

Cloudflare is a powerful CDN and security platform — but if you’re trying to monitor **404 errors**, especially to see what broken or mistyped URLs visitors are hitting, you might run into limitations depending on your plan.

Here’s what you need to know:

---

## ✅ Can Cloudflare Report 404 Hits?

**Yes — but with limitations.**  
Cloudflare **does not** natively show detailed 404 logs (like full URL lists) on the **free plan** or even in most standard dashboards.

---

## 🔍 What “Top Paths” Actually Shows (Free Plan Web Analytics)

If you're using **Cloudflare Web Analytics**, it shows basic site metrics like:

- Top referrers
- Top paths
- Browser/device data
- Aggregate status codes (e.g. how many 404s total)

But what does “**top paths**” actually mean?

### ➕ “Top Path” = Path Only (No Parameters)

It refers to the part of the URL **after the domain**, excluding any query strings or anchors.

#### Example:

|Visitor URL|Top Path (Reported)|
|---|---|
|`https://example.com/about`|`/about`|
|`https://example.com/products?id=123`|`/products`|
|`https://example.com/blog/article#section2`|`/blog/article`|

You **won’t see query parameters** like `?id=123` or anchors like `#section2`.

---

## 🛑 What You Won’t Get on Free Plan

- ❌ Full URLs with query strings
    
- ❌ A list of all URLs that returned 404
    
- ❌ Per-visitor or per-error traceability
    
- ❌ Referrer tracking on 404s
    

Cloudflare may show that some traffic landed on `/nonexistent-page`, but that’s only if it becomes one of your **most visited paths** — and even then, you won't know where those visitors came from.

---

## 🛠 Workarounds to Track 404s Properly

If you want more detailed insights, here are your options:

### 1. **Use Cloudflare Workers for Custom Logging**

You can deploy a [Cloudflare Worker](https://developers.cloudflare.com/workers/) that wraps the fetch call to your origin and logs requests that return a `404`.

#### Sample logic:

```js
addEventListener('fetch', event => {
  event.respondWith(handleRequest(event.request));
})

async function handleRequest(request) {
  const response = await fetch(request);
  if (response.status === 404) {
    // Send to logging service like Logtail, Loggly, etc.
    fetch('https://your-log-endpoint.com', {
      method: 'POST',
      body: JSON.stringify({ url: request.url, time: Date.now() }),
      headers: { 'Content-Type': 'application/json' }
    });
  }
  return response;
}
```

### 2. **Add Analytics or Logging to Your 404 Page**

If you control the 404 page content, you can:

- Add **Google Analytics or Plausible** event tracking
    
- Send the 404 URL to your own backend or logging service
    

```html
<script>
  fetch("https://your-logger.com/log-404", {
    method: "POST",
    body: JSON.stringify({ url: window.location.href }),
    headers: { "Content-Type": "application/json" }
  });
</script>
```

This way, you get **full visibility** into what broken links users are hitting.

### 3. **Use Enterprise Logs (Paid Only)**

If you're on the **Cloudflare Enterprise plan**, you can stream full logs — including URLs, user agents, and response codes — to a logging platform (like Datadog, Splunk, or your own system).

---

## 🧠 Bonus: Combine With Google Search Console

Google Search Console can also show **crawl errors**, including 404s that Googlebot encountered. This helps you find broken internal or external links, even if you can't see them in Cloudflare’s free dashboard.

---

## TL;DR

- Cloudflare’s free Web Analytics shows **aggregate 404s** and **top paths** (but not full URLs or referrers).
    
- “Top paths” = the part of the URL **after the domain**, without query strings or anchors.
    
- To fully track 404s, you need to **log them manually via Workers or your 404 page**, or use **Enterprise log streaming**.