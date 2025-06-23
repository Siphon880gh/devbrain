

Single Page Applications (SPAs) offer a fast, fluid user experience by rendering content dynamically in the browser using JavaScript. However, this presents a major problem for SEO: many web crawlers, especially those from social media platforms or lesser-known search engines, **don’t execute JavaScript**. This means they miss out on critical elements like:

- Meta tags (title, description, og:image, etc.)
- Structured data (like JSON-LD)
- Text content
- Outgoing links

If your app relies entirely on client-side rendering, these crawlers often see a blank page—resulting in poor SEO and bad link previews.

## The Fix: Prerendering + Server Fallbacks

The strategy is simple: **detect when a request comes in for a known route (e.g., `/deal/:slug`) and serve a static HTML file if it exists**. Otherwise, fall back to your normal SPA behavior.

Here’s how that works in practice:

```js
const fs = require('fs');
const path = require('path');
const express = require('express');
const app = express();

const prerenderedPath = path.join(__dirname, 'prerendered');
console.log('Serving from prerendered:', prerenderedPath);

// Diagnostic: See what’s in the prerendered directory
if (fs.existsSync(prerenderedPath)) {
  console.log('Prerendered directory contents:', fs.readdirSync(prerenderedPath));
} else {
  console.log('Prerendered directory not found');
}

// Route override: check for a pre-rendered HTML file before falling back to SPA
app.get('/deal/:slug', (req, res, next) => {
  const slug = req.params.slug.replace(/'s$/, "s");
  const prerenderedFile = path.join(prerenderedPath, 'deal', slug, 'index.html');
  
  console.log(`Checking prerender: ${prerenderedFile} (exists: ${fs.existsSync(prerenderedFile)})`);
  
  if (fs.existsSync(prerenderedFile)) {
    console.log(`Serving pre-rendered file: ${prerenderedFile}`);
    res.sendFile(prerenderedFile);
  } else {
    next(); // fallback to client-side app
  }
});
```

### What’s Happening Here

- ✅ `prerenderedPath` points to a folder where your build or prerendering tool has output static HTML files.
    
- ✅ For a route like `/deal/awesome-product`, the server checks if `prerendered/deal/awesome-product/index.html` exists.
    
- ✅ If it exists, it’s served directly—giving crawlers full access to pre-rendered content and meta tags.
    
- ❌ If it doesn’t exist, the request falls through and your client-side SPA handles it.
    

## How to Generate Prerendered Files

There are a few ways to generate static HTML snapshots:

- **Using a headless browser** (like Puppeteer) to crawl your own app and save the rendered output
- **Build-time tools** like [React Snapshot](https://github.com/geelen/react-snapshot), [Scully](https://scully.io/) for Angular, or [Nuxt/Nuxt Content](https://content.nuxtjs.org/) for Vue
- **Hosted prerendering services** like [Prerender.io](https://prerender.io/) or [Rendertron](https://github.com/GoogleChrome/rendertron)

Once generated, place them into your `prerendered/` folder and ensure your server checks this directory before defaulting to the SPA.

## Why This Matters

With this pattern, you get the best of both worlds:

|Benefit|Explanation|
|---|---|
|🔍 SEO-Friendly|Crawlers get meaningful HTML, meta tags, and structured data|
|⚡ Fast UX|Human users still enjoy a dynamic, JavaScript-powered SPA|
|💬 Social Sharing|Platforms like Facebook, Slack, and Twitter can display rich previews|
|🔁 Simple Fallback|If a pre-rendered page doesn’t exist, the SPA still works normally|

## Final Tips

- Make sure to regenerate your prerendered pages anytime content changes.
- You can extend this to support other routes like `/blog/:slug`, `/product/:id`, etc.
- You might want to set appropriate cache headers on these static files.