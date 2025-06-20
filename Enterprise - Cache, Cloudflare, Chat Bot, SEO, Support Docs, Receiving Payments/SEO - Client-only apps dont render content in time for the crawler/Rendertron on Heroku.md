Explained in the context of:

Here’s a complete walkthrough for hosting your Vite CSR app on Heroku so that SEO crawlers (Ahrefs, Googlebot, Facebook, etc.) see fully rendered HTML—with all your meta tags, text content, and outbound links—instead of the raw client bundle.

---

## Why Prerendering Matters for CSR Apps

Client-side rendering (CSR) apps ship a minimal HTML shell plus JS bundles, then hydrate everything in the browser. That’s great for interactivity, but many SEO and social-media crawlers either don’t execute or only partially execute JavaScript. The result? They see an empty `<div id="app">…</div>`—no `<title>`, no meta tags, no text, no links.

**Rendertron** solves this by running Headless Chrome on your pages and returning snapshots of the fully populated DOM to bots—while real users still get your fast CSR experience.

---

## High-Level Request Flow

1. **Crawler → Your Heroku “proxy”**  
    Detect the UA (e.g. Googlebot).
    
2. **Proxy → Rendertron**  
    Forward the full URL (e.g. `https://your-app.herokuapp.com/exercise/foo`) to Rendertron’s `/render/` endpoint.
    
3. **Rendertron → Your Vite App**  
    Headless Chrome fetches, runs your JS, waits for render-complete.
    
4. **Rendertron → Proxy → Crawler**  
    Returns the static HTML snapshot (with `<meta>`, `<h1>…`, outbound links, etc.).
    
5. **Real users → Proxy → Vite**  
    Proxy routes non-bot UAs straight to your Vite app or static build.
    

---

## Option 1: Two Separate Heroku Apps

### A. App A: “Proxy + Vite”

- **Stack:** Express (or any Node server)
    
- **Port:** Binds to `process.env.PORT` (Heroku’s dyno port)
    
- **Behavior:**
    
    - If `User-Agent` is a bot → Proxy to App B’s Rendertron URL
        
    - Else → Serve your built `dist/` folder (or dev proxy to Vite)
        

```js
// server.js for App A
const express = require('express');
const { createProxyMiddleware } = require('http-proxy-middleware');
const { isBot } = require('express-useragent');
const path = require('path');

const app = express();
const RENDERTRON_URL = process.env.RENDERTRON_URL; // e.g. https://rendertron-app.herokuapp.com
const PORT = process.env.PORT || 3000;

// 1) Bot? → Rendertron
app.use((req, res, next) => {
  if (isBot(req.headers['user-agent'])) {
    const target = `${req.protocol}://${req.get('host')}${req.originalUrl}`;
    return createProxyMiddleware({
      target: RENDERTRON_URL,
      changeOrigin: true,
      pathRewrite: { '^/': `/render/${encodeURIComponent(target)}` }
    })(req, res, next);
  }
  next();
});

// 2) Humans → Static files
app.use(express.static(path.join(__dirname, 'dist')));
app.get('*', (req, res) => {
  res.sendFile(path.join(__dirname, 'dist/index.html'));
});

app.listen(PORT, () => console.log(`Proxy running on port ${PORT}`));
```

- **Deploy App A:**
    
    ```bash
    heroku create your-vite-proxy-app
    git push heroku main
    heroku config:set RENDERTRON_URL=https://your-rendertron-app.herokuapp.com
    ```
    

### B. App B: “Rendertron”

- **Stack:** The official Rendertron repo
    
- **Port:** Binds to its own `$PORT` (Heroku assigns automatically)
    
- **Deploy:**
    
    ```bash
    heroku create your-rendertron-app
    git clone https://github.com/GoogleChrome/rendertron.git
    cd rendertron
    npm install
    heroku git:remote -a your-rendertron-app
    git push heroku main
    ```
    
- **Scale:**
    
    ```bash
    heroku ps:scale web=1
    ```
    

**Pros:**

- Clear separation, independent scaling.
    
- You can cache snapshots on a Redis add-on for App B.
    

**Cons:**

- Two dynos = two bills.
    

---

## Option 2: One Dyno, One App (Embedded Rendertron)

Bundle both your proxy and Rendertron middleware into a single Express app that Heroku will run on its one `$PORT`.

### 1. Add Chrome Buildpack

```bash
heroku buildpacks:add --index 1 jontewks/puppeteer
heroku buildpacks:add --index 2 heroku/nodejs
```

### 2. Server Code

```js
// server.js
const express = require('express');
const path = require('path');
const Rendertron = require('rendertron-middleware');
const { isBot } = require('express-useragent');

const app = express();
const port = process.env.PORT || 3000;

// Initialize Rendertron middleware, launching headless Chrome under the hood
const rendertron = Rendertron.makeMiddleware({
  proxyUrl: null,
  injectShadyDom: false,
  waitForEvent: 'render-complete', // or a timeout
  // optional: cache options (Redis)
});

app.use((req, res, next) => {
  if (isBot(req.headers['user-agent'])) {
    return rendertron(req, res);
  }
  next();
});

// Serve your built Vite files
app.use(express.static(path.join(__dirname, 'dist')));
app.get('*', (req, res) => {
  res.sendFile(path.join(__dirname, 'dist/index.html'));
});

app.listen(port, () => console.log(`App listening on ${port}`));
```

### 3. Procfile

```
web: node server.js
```

**Pros:**

- Single dyno; one app to manage.
    
- Simpler URLs (no cross-app proxying).
    

**Cons:**

- Dyno CPU is shared—heavy prerendering could slow normal requests unless you cache aggressively.
    

---

## Tips for Smooth SEO

- **Dispatch a “render-complete” event** from your client when all async data is loaded. Rendertron can wait on that instead of an arbitrary timeout.
    
- **Set up caching** (in-memory or Redis) so bots aren’t forever triggering fresh renders.
    
- **Whitelist only crawler UAs** you care about—don’t assume every unknown UA needs prerendering.
    
- **Environment variables** on Heroku:
    
    - `PORT` (provided automatically)
        
    - `RENDERTRON_URL` (for two-app setup)
        
- **Buildpacks** (for single-app):
    
    1. Chrome/Puppeteer buildpack
        
    2. Node.js buildpack
        

---

### In Summary

By sitting a small Express “proxy” in front of your Vite CSR build—and routing bots to Rendertron—you get the best of both worlds:

- **SEO-friendly, fully rendered HTML** for crawlers
    
- **Lightning-fast CSR** for real users
    

Choose “two apps” for maximum isolation or “embedded” for a lean, single-dyno deployment on Heroku. Either way, Ahrefs, Googlebot, and social-media scrapers will now pick up all your meta tags, text content, and outbound links as intended.

---

## Dynamic Renderer - Free?

==Yes, Rendertron is free as it is an open-source project==. You can deploy and run your own Rendertron instance without incurring any licensing fees. It's a solution for [dynamic rendering](https://www.google.com/search?rlz=1C5CHFA_enUS1017US1017&cs=0&sca_esv=f189ccc98951b8a3&sxsrf=AE3TifME6OQ78ixSABBSV74r1OqfxuOFkg%3A1750405651736&q=dynamic+rendering&sa=X&ved=2ahUKEwj9g5-Ywf-NAxUQPEQIHfOwHvcQxccNegQIBRAB&mstk=AUtExfC2Qox6DATtYpUPMcPTG-568S8Wqz0Jx6RmImAbKCL8Fc9guGDSpne_EO6oGl6FKDdOAOch3ZKI2nRd2MRFCclRK9MhDeu1KuSv36MJEMXBZSZe8sY-GjZ74Xxc48XOk-xy0qkOXAnL0GHDxaRn4KpGqgVj6NyTp-K3ltqlTFo_ufqI6xA63dAgCcmNZD7mVmshuZNLvUoTy71D9WbyGAiKE2aCA9LPJyqx6hY26D-Sknrh63PMOdispuOm640tDJLexxxhZKKJIZ3xOzM7xADp&csui=3), which involves using headless Chrome to render web pages into static HTML. While the base software is free, deploying it on platforms like [Google Cloud Platform](https://www.google.com/search?rlz=1C5CHFA_enUS1017US1017&cs=0&sca_esv=f189ccc98951b8a3&sxsrf=AE3TifME6OQ78ixSABBSV74r1OqfxuOFkg%3A1750405651736&q=Google+Cloud+Platform&sa=X&ved=2ahUKEwj9g5-Ywf-NAxUQPEQIHfOwHvcQxccNegQIBhAB&mstk=AUtExfC2Qox6DATtYpUPMcPTG-568S8Wqz0Jx6RmImAbKCL8Fc9guGDSpne_EO6oGl6FKDdOAOch3ZKI2nRd2MRFCclRK9MhDeu1KuSv36MJEMXBZSZe8sY-GjZ74Xxc48XOk-xy0qkOXAnL0GHDxaRn4KpGqgVj6NyTp-K3ltqlTFo_ufqI6xA63dAgCcmNZD7mVmshuZNLvUoTy71D9WbyGAiKE2aCA9LPJyqx6hY26D-Sknrh63PMOdispuOm640tDJLexxxhZKKJIZ3xOzM7xADp&csui=3) might have associated costs, especially for production use