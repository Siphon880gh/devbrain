If your app supports **hundreds or thousands of routes**, or user-generated content (e.g. `/profile/:username`, `/article/:slug`), pre-rendering everything at build or startup isn’t realistic.

Instead, you can **generate pre-rendered HTML the first time a route is visited**, then **cache it for future requests**. And if the cache is too old, it'll re-generate the pre-rendered HTML. This gives you the best of both worlds:

- Real-time coverage of any route
- Static HTML delivery for crawlers and performance
- SEO-friendly pages without long builds or bloated deploys

---

### ✅ Key Features

|Feature|Benefit|
|---|---|
|**Infinite Routes**|Works with dynamic, user-generated, or unknown paths|
|**SEO-Ready**|Crawlers receive fully rendered HTML after first request|
|**Fast After First**|Pages are cached as static files after generation|
|**Low Overhead**|No huge prerender job up front|

---

### ⚙️ How It Works

1. A user (or crawler) visits `/exercise/benchpress`
    
2. Server checks if `prerendered/exercise/benchpress/index.html` exists
    
3. If yes → serve it
    
4. If not → render it using Puppeteer, save it, and then serve it
    
5. Optionally: check for stale cache and re-render after N days
    

---

### 🛠 Server Setup

#### `server.js` (on-demand + cache)

```js
const express = require('express');
const path = require('path');
const fs = require('fs');
const { exec } = require('child_process');

const app = express();
const DIST = path.join(__dirname, 'dist');
const PRERENDER_ROOT = path.join(__dirname, 'prerendered');

function getPrerenderPath(slug) {
  return path.join(PRERENDER_ROOT, 'exercise', slug, 'index.html');
}

function needsRebuild(filePath) {
  if (!fs.existsSync(filePath)) return true;

  const stat = fs.statSync(filePath);
  const ageMs = Date.now() - stat.mtimeMs;
  const maxAge = 1000 * 60 * 60 * 24 * 7; // 7 days

  return ageMs > maxAge;
}

// Uses PRERENDER_BASE_URL from environment, fallback to localhost
const BASE_URL = process.env.PRERENDER_BASE_URL || 'http://localhost:3000';

function prerenderPage(slug, callback) {
  const url = `${BASE_URL}/exercise/${slug}`
  const outPath = getPrerenderPath(slug);

  exec(`node scripts/prerenderSingle.js "${url}" "${outPath}"`, (err) => {
    if (err) console.error(`Failed to prerender ${slug}`, err);
    if (callback) callback();
  });
}

app.get('/exercise/:slug', (req, res) => {
  const slug = req.params.slug;
  const prerenderPath = getPrerenderPath(slug);

  if (fs.existsSync(prerenderPath)) {
    if (needsRebuild(prerenderPath)) {
      prerenderPage(slug); // Refresh in background
    }
    return res.sendFile(prerenderPath);
  }

  // Render on-demand, then serve fallback while rendering
  prerenderPage(slug);
  res.sendFile(path.join(DIST, 'index.html'));
});

app.use(express.static(DIST));

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`Server running on http://localhost:${PORT}`));
```

Make sure to have setup `.env`:
- PORT
- BASE_URL

---

**Does the pre-rendering on a new URL take too long?** 

You can consider the main URL point `/exercise/:slug` to check if the prerendered file exists. If the prerendered file exists, send user the file.

But if the prerendered file does not exist, you send a HTML file you construct in that endpoint. The HTML file will render an animation and a script block. User will see a funny animation while waiting. The script block could ajax to `/exercise/:slug/prerender` which will perform the actual rebuilding / prerendering. Every 1 second, that script block polls `/exercise/:slug/poll` for a successful message. On success, refresh the webpage, which will deliver the prerendered file because the api endpoint will detect the prerendered file exists this time. You should have a timeout where the poll stops and just refreshes the page from a meta tag level after some seconds timeout, which could help out with crawlers that follow redirects.

---

### 🔧 Supporting Script: `scripts/prerenderSingle.js`

```js
const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');

const url = process.argv[2];
const outputPath = process.argv[3];

(async () => {
  const browser = await puppeteer.launch();
  const page = await browser.newPage();

  await page.goto(url, { waitUntil: 'networkidle0' });
  const html = await page.content();

  fs.mkdirSync(path.dirname(outputPath), { recursive: true });
  fs.writeFileSync(outputPath, html);

  await browser.close();
})();
```

---

### 🧠 Enhancements You Can Add

- Queue system (`bull`, `bee-queue`) to throttle renders
    
- TTL metadata file (e.g. `benchpress.meta.json` with a `lastRendered` timestamp)
    
- Status indicators or retry logic if render fails
    
- Separate endpoint to invalidate a cached HTML manually
    

---

### ✅ Summary

|Scenario|Solution|
|---|---|
|Large content set|✅ Handles dynamically|
|First visit slow?|✅ Falls back to SPA|
|Later visits fast?|✅ Uses cached HTML|
|Needs to update over time|✅ Supports age-based refresh|
