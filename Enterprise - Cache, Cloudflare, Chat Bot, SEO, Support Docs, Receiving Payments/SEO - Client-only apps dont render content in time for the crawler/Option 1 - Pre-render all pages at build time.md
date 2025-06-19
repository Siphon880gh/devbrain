
If you're building a frontend-only React app with **Vite**, a practical way to boost SEO and social sharing is by **pre-rendering your key pages into static HTML during the production build**.

This approach works best when:
- You have a small, fixed number of routes (e.g., 10–20)
- All URLs are known in advance (via sitemap or static list)
- Pages don’t change frequently

---

### ✅ Recommended Tool: `vite-plugin-prerender`

This plugin automatically visits a list of URLs at build time, waits for your app to fully render, and saves each page as a static HTML file—allowing search engines and social media crawlers to access content without executing JavaScript.

---

### 🧪 Example: Modal-Based URL Routing

Imagine your app has modal pages like `/exercise/benchpress` or `/exercise/pushup`. Here’s how your implementation might work:

- On the homepage, clicking an exercise updates the URL (e.g., via `navigate('/exercise/benchpress')`)
    
- The same page component stays mounted, but a `useEffect()` detects the slug change
    
- The slug is used to look up the corresponding exercise object, which is then stored in a state variable
    
- Once that state variable is truthy, the modal renders and opens (And if you have meta tags that dynamically change for no modal opened vs URL-based modal opened, then the React Helmet updates the meta tags)

---

### ⚙️ How Pre-rendering Works

1. When you run `npm run build:prerender`, the plugin visits each defined URL
    
2. JavaScript runs as usual, modals open, content loads, and meta tags are rendered
    
3. The full DOM is captured and saved to files like:
    
    ```
    prerendered/exercise/benchpress/index.html
    prerendered/exercise/pushup/index.html
    ```
    
4. These static HTML files become part of your production build
    

---

### 🚀 Benefits of Pre-rendering

|Feature|Benefit|
|---|---|
|**SEO**|Search engines index full page content and meta tags|
|**Performance**|Faster page loads via static HTML|
|**Social Sharing**|Correct previews on Twitter, Facebook, etc.|
|**Deep Linking**|Direct access to specific modal URLs|

---

### ⚠️ Limitations & Heroku Considerations

Pre-rendering has trade-offs, especially at scale:

- ❌ **Long build times**: 100+ URLs significantly increase build duration
    
- ❌ **Stale content**: Pages must be rebuilt to reflect updated content
    
- ❌ **Heroku caveats**:
    
    - Heroku doesn't start a dev server (`npm run dev`) during `postbuild`
        
    - Some pre-rendering methods (like Puppeteer-based tools) require a running server, which can break during Heroku deploys
        

---

### 🛠 Sample Setup

#### `scripts/generatePrerenderUrls.js`

```js
const fs = require('fs');
const routes = require('./routes.json'); // e.g., ["benchpress", "pushup"]

const urls = routes.map((slug) => `/exercise/${slug}`);
fs.writeFileSync('prerender-urls.json', JSON.stringify(urls, null, 2));
```

#### `vite.config.js`

```js
import fs from 'fs';
import prerender from 'vite-plugin-prerender';

export default {
  plugins: [
    prerender({
      staticDir: 'prerendered',
      routes: JSON.parse(fs.readFileSync('prerender-urls.json')),
    }),
  ],
};
```

---

### 🔧 Package Scripts

```json
{
  "scripts": {
    "dev": "vite",
    "build": "vite build",
    "build:prerender": "vite build --mode production && node scripts/generatePrerenderUrls.js",
    "preview": "vite preview"
  }
}
```

```bash
# Run locally without pre-rendering
npm run dev

# Build and pre-render all pages
npm run build:prerender

# Preview the pre-rendered output
npm run preview
```

---

### 🛰️ Serving Pre-rendered Pages via Server Endpoint

To deliver pre-rendered HTML to crawlers or users directly, your server can detect and serve the pre-built files based on route matching. Here’s a basic Express example for `/exercise/:exerciseName`:

#### `server.js` (Express)

```js
const express = require('express');
const path = require('path');
const fs = require('fs');

const app = express();
const PRERENDER_ROOT = path.join(__dirname, 'prerendered');

app.get('/exercise/:exerciseName', (req, res, next) => {
  const slug = req.params.exerciseName;
  const filePath = path.join(PRERENDER_ROOT, 'exercise', slug, 'index.html');

  if (fs.existsSync(filePath)) {
    return res.sendFile(filePath);
  }

  // Fallback to default app (e.g., index.html) if prerendered file not found
  res.sendFile(path.join(__dirname, 'dist', 'index.html'));
});

app.use(express.static(path.join(__dirname, 'dist')));

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`Server running at http://localhost:${PORT}`));
```

> ✅ You can also extend this logic to check file freshness or trigger background re-generation.

---

## 🤖 Do You Need Puppeteer?

In most cases, **no** — `vite-plugin-prerender` uses a headless browser internally (usually Puppeteer or Playwright), so **you don’t need to install or configure Puppeteer manually**.

You’d only need Puppeteer if:

- You want advanced control (e.g., wait 5s before capture, check `.modal-content` exists)
    
- You’re writing a custom rendering script outside of Vite
    
- You need more complex logic than the plugin supports