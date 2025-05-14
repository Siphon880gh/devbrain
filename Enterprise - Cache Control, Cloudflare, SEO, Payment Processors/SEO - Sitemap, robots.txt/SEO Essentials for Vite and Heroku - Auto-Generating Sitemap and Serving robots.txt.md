**Titled**: SEO Essentials for Vite and Heroku - Auto-Generating Sitemap and Serving robots.txt

To improve SEO for your Vite-powered site, you’ll want to generate a fresh `sitemap.xml` every time you build your app and correctly serve it along with a `robots.txt` file from the root of your deployed domain (e.g., `https://yourapp.herokuapp.com/sitemap.xml`).

This guide assumes you're deploying a Vite app to Heroku, and that you do not have a domain name yet, but the core setup can be adapted for any platform.

If you DO own a domain, then your domain address will be showing the heroku app while hiding the heroku url.

If you DO own a domain, then adjust the steps as follow so that Google search results will list your domain name branded pages:
- The `generateSitemap.js` should have `BASE_URL` adjusted. That's because it generates the sitemap.xml which contains full absolute URL to your webpages for google search results indexing.
- sitemap.xml will point to the domain.com/robots.txt
- when testing that you can visit sitemap.xml and robots.txt directly, you visit domain.com/sitemap.xml and domain.com/robots.txt
- when submitting the sitemap to Google Search Console, submit the url of the domain's sitemap

---

### 1. ✅ Automate Sitemap Generation During Build

Add a postbuild step in your `package.json`:

```json
"scripts": {
  "build": "vite build",
  "heroku-postbuild": "node scripts/generateSitemap.js"
}
```

Create `scripts/generateSitemap.js` that writes `sitemap.xml` to the `dist/` directory:

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

Note if you can't see anything from the url's, then the Google search crawler won't see anything either!

### 6. 🧪 Submit to Google Search Console

Submit the sitemap url to under your domain name (aka property) at Google Search:
http://search.google.com/search-console/

For instructions how, refer to my business notes on Google Search Console:
- Adding/verifying a domain (aka property at Google Search Console):
  wengindustries.com/app/bizbrain/?open=_PRIMER%20-%20Google%20Search%20Verify%20Property%20(Domain)
- Submitting a sitemap url to the property:
  wengindustries.com/app/bizbrain/?open=How%20to%20submit%20a%20site%20map