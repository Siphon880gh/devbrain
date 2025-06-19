When your Vite-based frontend has too many pages for static pre-rendering during `vite build`, or you’re deploying to a platform like **Heroku** (where long `postbuild` tasks can break for taking too long with too many files), a better approach is to pre-render your HTML pages **after the server starts** — in the background.

This lets you:
- Avoid blocking the build process
- Pre-render dozens or hundreds of pages
- Start serving API and frontend traffic immediately
    
This approach works best when:
- All URLs are known in advance (via sitemap or static list)
- Pages don’t change frequently

---

### ✅ Key Features

|Feature|Benefit|
|---|---|
|**Heroku-friendly**|Doesn’t require `npm run dev` or blocking `postbuild`|
|**Non-blocking**|API routes and frontend load immediately on startup|
|**Scalable**|Handles large route lists without extending build time|
|**SEO-ready**|Crawlers get full HTML and meta tags after prerender|

---

### ⚙️ How It Works

1. You build your app with `vite build`
    
2. Your Express server starts and begins handling requests immediately
    
3. In the background, it calls a Node script (`scripts/prerenderAll.js`) that:
    
    - Loads a list of URLs (e.g. from `routes.json`)
        
    - Uses Puppeteer to open and render each page
        
    - Saves the output as static HTML in `/prerendered`
        
4. When users or crawlers request a route like `/exercise/pushup`, the server serves the static HTML if it’s ready, or falls back to the SPA temporarily
    

---

### 🛠 Setup Overview

#### `routes.json`

```json
["benchpress", "pushup", "squat", "deadlift"]
```

---

#### `scripts/prerenderAll.js`

```js
const puppeteer = require('puppeteer');
const fs = require('fs');
const path = require('path');

// Uses PRERENDER_BASE_URL from environment, fallback to localhost
const BASE_URL = process.env.PRERENDER_BASE_URL || 'http://localhost:3000';
const slugs = require('./routes.json');

(async () => {
  const browser = await puppeteer.launch();
  const page = await browser.newPage();

  for (const slug of slugs) {
    const url = `${BASE_URL}/exercise/${slug}`;
    const outputPath = path.join(__dirname, 'prerendered', 'exercise', slug, 'index.html');

    console.log(`Prerendering: ${url}`);
    await page.goto(url, { waitUntil: 'networkidle0' });
    const html = await page.content();

    fs.mkdirSync(path.dirname(outputPath), { recursive: true });
    fs.writeFileSync(outputPath, html);
  }

  await browser.close();
})();
```

Make sure you've setup your .env file with `BASE_URL` and optionally `PORT` (for server.js to run on a port other than fallback 3000 if you need to - see code below)

---

#### `server.js`

```js
const express = require('express');
const path = require('path');
const fs = require('fs');
const { exec } = require('child_process');

const app = express();
const DIST = path.join(__dirname, 'dist');
const PRERENDER_ROOT = path.join(__dirname, 'prerendered');

// 🚀 Trigger background prerendering without blocking server
exec('node scripts/prerenderAll.js', (err, stdout, stderr) => {
  if (err) console.error('Prerender failed:', stderr);
  else console.log('Prerender complete:\n', stdout);
});

// Serve prerendered HTML if available
app.get('/exercise/:slug', (req, res) => {
  const slug = req.params.slug;
  const prerenderPath = path.join(PRERENDER_ROOT, 'exercise', slug, 'index.html');

  if (fs.existsSync(prerenderPath)) {
    return res.sendFile(prerenderPath);
  }

  // Fallback to client-side rendering
  res.sendFile(path.join(DIST, 'index.html'));
});

// Serve static assets and fallback SPA
app.use(express.static(DIST));

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`Server running at http://localhost:${PORT}`));
```

Or instead of "Fallback to client-side rendering"'s index.html, you can send them to a maintenance page.

If you're still developing code and re-running the server at your local machine frequently, you may want to consider making exec only run if NODE_ENV is production. Then your regular `npm run start` wouldn't feel that slow and you can ask it to pre-render in the background with `export NODE_ENV=production && npm run start`

---

### 🧠 Is the Server Blocked While Pre-rendering?

No — this setup **does not block API routes or frontend access**.

- `exec('node scripts/prerenderAll.js')` launches a **non-blocking background process**
    
- The Express server is **fully available** to handle requests while pages are being generated
    
- This is ideal for platforms like Heroku that prioritize fast boot times
    

|Task|Happens Immediately?|
|---|---|
|Start API/SPA server|✅ Yes|
|Accept `/api/...` requests|✅ Yes|
|Accept `/exercise/:slug`|✅ Yes (with fallback)|
|Run prerender script|✅ In background|

---

### 📁 Example Output

```
dist/                            ← Vite SPA build
prerendered/
  └─ exercise/
      ├─ benchpress/index.html
      ├─ pushup/index.html
      ├─ squat/index.html
      └─ deadlift/index.html
```

---

### 🔁 Usage

```bash
npm run build        # Build the SPA
node server.js       # Starts Express and prerenders in background
```
