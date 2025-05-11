**Titled**: SEO Essentials for Vite and Heroku - Auto-Generating Sitemap and Serving robots.txt

To improve SEO for your Vite-powered site, you’ll want to generate a fresh `sitemap.xml` every time you build your app and correctly serve it along with a `robots.txt` file from the root of your deployed domain (e.g., `https://yourapp.herokuapp.com/sitemap.xml`).

This guide assumes you're deploying a Vite app to Heroku, and that you do not have a domain name yet, but the core setup can be adapted for any platform.

If you DO own a domain and you intend for google to list your domain address rather than a herokuapp.com space url, then adjust the steps as follow:
- robots.txt will point to sitemap at your domain rather than herokuapp.com
- when testing that you can visit sitemap.xml and robots.txt directly, you visit domain.com/sitemap.xml and domain.com/robots.txt

---

### 1. ✅ Automate Sitemap Generation During Build

Add a postbuild step in your `package.json`:

```json
"scripts": {
  "build": "vite build",
  "heroku-postbuild": "node scripts/generateSitemap.js"
}
```

Create `scripts/generateSitemap.js` that writes to the `dist/` directory:

```js
import fs from 'fs';
import path from 'path';

const BASE_URL = 'https://yourapp.herokuapp.com';

const staticPages = [
  { loc: '/', changefreq: 'daily', priority: 1.0 },
  { loc: '/about', changefreq: 'monthly', priority: 0.6 },
  { loc: '/privacy', changefreq: 'monthly', priority: 0.4 },
  { loc: '/contact', changefreq: 'monthly', priority: 0.5 }
];

const xml = `<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
${staticPages.map(page => `
  <url>
    <loc>${BASE_URL}${page.loc}</loc>
    <changefreq>${page.changefreq}</changefreq>
    <priority>${page.priority}</priority>
  </url>`).join('')}
</urlset>`;

fs.writeFileSync(path.resolve('dist/sitemap.xml'), xml);
```

You can expand this to include dynamic pages or slugs by reading files or fetching data as needed.

---

### 2. 🤖 Add a `robots.txt` File

Place your `robots.txt` inside the `public/` directory:

```txt
User-agent: *
Disallow:

Sitemap: https://yourapp.herokuapp.com/sitemap.xml
```

Vite automatically copies everything in `public/` to the final `dist/` folder on build.

---

### 3. 🌐 Serve `sitemap.xml` and `robots.txt` via Express

In your `server.js` or similar entry point for Heroku, make sure Express serves the `dist/` folder:

```js
app.use(express.static(path.join(__dirname, 'dist')));
```

Make sure you **do not serve `public/` directly**—only the built `dist/` folder matters in production.

---

### 4. (Optional) Serve Text/XML Files in Development via Vite Plugin

If you want to preview `sitemap.xml` and `robots.txt` during development (`vite dev`), use a custom Vite plugin:

```js
// vite.config.js
import fs from 'fs';
import path from 'path';

const serveStaticFiles = () => ({
  name: 'serve-static-files',
  configureServer(server) {
    server.middlewares.use((req, res, next) => {
      const filePath = {
        '/sitemap.xml': path.resolve(__dirname, 'public/sitemap.xml'),
        '/robots.txt': path.resolve(__dirname, 'public/robots.txt')
      }[req.url];

      if (filePath && fs.existsSync(filePath)) {
        const content = fs.readFileSync(filePath, 'utf-8');
        res.writeHead(200, {
          'Content-Type': req.url.endsWith('.xml') ? 'application/xml' : 'text/plain',
          'Content-Length': Buffer.byteLength(content)
        });
        res.end(content);
        return;
      }

      next();
    });
  },
  configurePreviewServer(server) {
    // Same logic as above
  }
});

export default {
  plugins: [serveStaticFiles()]
};
```

---

### 5. 🧪 Test Your Setup

After deploying, visit:

- `https://yourapp.herokuapp.com/sitemap.xml`
- `https://yourapp.herokuapp.com/robots.txt`

Both files should load correctly, and Google's search crawler will be able to discover and index your site efficiently.