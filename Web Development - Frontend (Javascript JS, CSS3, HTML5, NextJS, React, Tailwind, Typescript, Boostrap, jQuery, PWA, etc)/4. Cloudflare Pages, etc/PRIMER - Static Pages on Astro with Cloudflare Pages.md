  

Astro is a good fit for Cloudflare Pages because it can generate fast static pages and, with the Cloudflare adapter, run server-rendered pages at the edge. Wrangler is Cloudflare’s CLI: it lets you develop locally, configure bindings such as KV or R2, and deploy or manage the project. Together, they give you Astro’s site-building tools with Cloudflare’s hosting and edge features.

The key reason it fits Cloudflare Pages is that Astro renders much of a page to HTML ahead of time, so Cloudflare can serve it quickly without running JavaScript on every request; pages that need server-side rendering can use the Cloudflare adapter.

You might ask: What’s so different from say me creating html files?

Astro helps when the site grows—you can reuse a header or layout across pages, write content in Markdown, generate pages from data, and have it build the finished HTML for you. If you’re happy maintaining a few HTML files by hand, you don’t need Astro.

And how to deploy it to Cloudflare? Wrangler is Cloudflare’s command-line tool for running your site locally, deploying it, and configuring Cloudflare features.

![[Pasted image 20261006052348.png]]

![[Pasted image 20261006052355.png]]

  

## Astro + Tailwind CSS v4 — Manual Build and Cloudflare Pages Deployment

### Ground rules

- Create the Astro website inside `site/`.
- Use Astro static output only.
- Use Tailwind CSS v4.
- Install packages through npm without manually specifying version numbers. Let npm resolve the current compatible versions.
- Do not add React, Vue, Svelte, or another client-side framework.
- Do not install a Cloudflare Astro adapter.
- Do not convert the Astro project to SSR.
- Cloudflare Pages receives only the already-built static files from `site/dist/`.

---

## 0. Create the Astro site

From the repository root:

npm create astro@latest site

When Astro asks setup questions:

- Use a minimal/empty starter unless the project specifically needs another Astro template.
- Do not add React or another UI framework.
- TypeScript is fine if desired.
- Installing dependencies is fine.
- Git initialization is optional if this repository already has Git.

Then:

cd site

### Install Tailwind CSS v4

Do not type package version numbers.

npm install tailwindcss @tailwindcss/vite

Tailwind CSS v4 uses the Vite plugin. Do not install the old `@astrojs/tailwind` integration.

If the site needs an automatically generated sitemap, also install:

npm install @astrojs/sitemap

### Configure Tailwind

Create:

site/src/styles/global.css

with:

@import "tailwindcss";

Import it from the site's main layout, for example:

---
import "../styles/global.css";
---

You normally do not need a `tailwind.config.js` just to use standard Tailwind v4 utilities.

---

## 0A. Configure Astro

Edit:
```
site/astro.config.mjs

Use this structure:

import { defineConfig } from "astro/config";
import tailwindcss from "@tailwindcss/vite";
import sitemap from "@astrojs/sitemap";

export default defineConfig({
  site: "https://example.com",

  output: "static",
  trailingSlash: "always",

  build: {
    format: "directory",
    inlineStylesheets: "always",
  },

  integrations: [
    sitemap(),
  ],

  vite: {
    plugins: [
      tailwindcss(),
    ],
  },
});
```


Replace:

https://example.com

with the appropriate site URL before the final build.

There must be:

- no Cloudflare adapter
- no React integration
- no client-side framework integration
- no SSR/server output

The required Astro settings are:

output: "static",
trailingSlash: "always",

build: {
  format: "directory",
  inlineStylesheets: "always",
},

---

## 0B. Add canonical URLs and noindex handling

The site's shared layout should generate the canonical from `Astro.site`.

For example:

---
import "../styles/global.css";

const canonicalURL = new URL(Astro.url.pathname, Astro.site);

// MANUALLY CHOOSE THIS BEFORE BUILDING:
const noindex = true;
---

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />

    <link rel="canonical" href={canonicalURL} />

    {
      noindex
        ? <meta name="robots" content="noindex, nofollow" />
        : <meta name="robots" content="index, follow" />
    }

    <slot name="head" />
  </head>

  <body>
    <slot />
  </body>
</html>

All normal pages should use this layout so canonical/noindex behavior is consistent.

### STAGING / TEST MODE

Use:

const noindex = true;

Keep the staging site out of search indexes.

The `site:` setting should still be an actual deploy URL, not localhost.

For a Cloudflare Pages project named:

my-example-site

the staging site will normally be:

https://my-example-site.pages.dev

so Astro can use:

site: "https://my-example-site.pages.dev",

### PRODUCTION LAUNCH MODE

Before the final production build:

const noindex = false;

and change Astro to the actual production domain:

site: "https://www.example.com",

or:

site: "https://example.com",

depending on which hostname is canonical.

Never build the production site with:

localhost
127.0.0.1
*.pages.dev

as the canonical site URL if the public canonical domain is a custom domain.

---

# 1. Choose staging or production BEFORE deployment

Before running the deployment, explicitly state which mode is being used:

MODE: STAGING / TEST

or:

MODE: PRODUCTION LAUNCH

### If STAGING / TEST

Confirm:

- `noindex = true`
- Astro `site:` is the staging URL
- canonical tags use the staging URL
- no canonical URLs contain localhost

### If PRODUCTION LAUNCH

Confirm:

- `noindex = false`
- Astro `site:` is the real public domain
- the real custom domain is already available/configured
- canonical tags use the real domain
- no canonical URLs contain localhost or `pages.dev`

Then rebuild.

---

## Build the site

From inside `site/`:

npm run build

The result should be:

site/dist/

Return to the repository root:

cd ..

Confirm it exists:

ls site/dist

You should see generated HTML/assets.

Because:

build: {
  format: "directory"
}

a page such as:

/about/

should normally produce:

dist/about/index.html

---

# 2. Log into Cloudflare Wrangler if needed

From the repository root:

npx wrangler login

Wrangler opens a browser.

Log into the appropriate Cloudflare account and approve access.

The browser should return a successful authorization message.

You can optionally check the login/account afterward:

npx wrangler whoami

---

# 3. FIRST DEPLOYMENT ONLY — create the Cloudflare Pages project

Do this only if the Pages project does not already exist.

npx wrangler pages project create <name> --production-branch main

Example:

npx wrangler pages project create my-example-site --production-branch main

Use a simple Cloudflare-compatible project name such as:

my-example-site

Prefer lowercase letters, numbers, and hyphens.

Do not recreate the Pages project on later deployments.

If unsure whether it already exists:

npx wrangler pages project list

---

# 4. Deploy the built static files

Make sure you have rebuilt immediately before deployment:

cd site
npm run build
cd ..

Then deploy:

npx wrangler pages deploy site/dist --project-name <name> --branch main

Example:

npx wrangler pages deploy site/dist --project-name my-example-site --branch main

Cloudflare will print the deployment URL.

Also check the normal project URL:

https://<name>.pages.dev/

Example:

https://my-example-site.pages.dev/

Open it in a browser.

---

# 5. Verify the LIVE site, not localhost

Do not consider the deployment finished simply because Wrangler reported success.

Test the live Cloudflare URL.

## 5A. Check the homepage

Run:

curl -I https://example.com/

or for staging:

curl -I https://my-example-site.pages.dev/

Expected:

HTTP/2 200

A redirect may be intentional if, for example, `example.com` redirects to `www.example.com`, but the final canonical URL should return `200`.

---

## 5B. Check the sitemap

Important:

The official Astro sitemap integration normally generates:

/sitemap-index.xml
/sitemap-0.xml

rather than one plain `/sitemap.xml`.

Therefore check, in this order:

curl -I https://example.com/sitemap.xml

and:

curl -I https://example.com/sitemap-index.xml

Use whichever sitemap structure the site actually publishes.

If using Astro's sitemap integration, normally inspect:

https://example.com/sitemap-index.xml

which points to:

https://example.com/sitemap-0.xml

and potentially additional sitemap files.

---

## 5C. Fetch EVERY page URL listed in the sitemap

For a small site, open the sitemap and manually copy every `<loc>` URL.

For example:

<loc>https://example.com/</loc>
<loc>https://example.com/about/</loc>
<loc>https://example.com/contact/</loc>

For each URL run:

curl -I https://example.com/
curl -I https://example.com/about/
curl -I https://example.com/contact/

Every final page should return:

200

Report any:

- 404
- 403
- 500
- redirect loop
- unexpected redirect

---

## 5D. Verify every canonical URL

Fetch each page HTML:

curl -s https://example.com/about/

Find:

<link rel="canonical" ...>

For example:

curl -s https://example.com/about/ | grep -i canonical

Expected:

<link rel="canonical" href="https://example.com/about/">

Confirm that every canonical:

1. uses HTTPS
2. uses the chosen canonical hostname
3. contains the correct path
4. follows the site's trailing-slash convention
5. never contains `localhost`
6. never contains `127.0.0.1`
7. does not contain `pages.dev` on the real production launch

---

## 5E. Verify noindex/index status

Run:

curl -s https://example.com/ | grep -i 'name="robots"'

### STAGING

Expected:

<meta name="robots" content="noindex, nofollow">

Check several pages, not only the homepage.

### PRODUCTION

There must not be an accidental:

noindex

on any indexable page.

Expected may be:

<meta name="robots" content="index, follow">

or the robots meta can be omitted entirely if the site's implementation intentionally treats the absence as indexable.

The critical production rule is:

NO accidental noindex.

Also check:

https://example.com/robots.txt

and make sure a production site does not unintentionally contain:

Disallow: /

---

# 6. Run Lighthouse against the LIVE homepage

Do not run the final Lighthouse report against localhost.

Install Lighthouse through npm without manually supplying a version:

cd site
npm install --save-dev lighthouse
cd ..

Set the live URL mentally/substitute it below.

Run mobile Lighthouse three separate times:

cd site

npx lighthouse https://example.com/ \
  --form-factor=mobile \
  --only-categories=performance,accessibility,best-practices,seo \
  --output=json \
  --output-path=./lighthouse-1.json \
  --chrome-flags="--headless"

npx lighthouse https://example.com/ \
  --form-factor=mobile \
  --only-categories=performance,accessibility,best-practices,seo \
  --output=json \
  --output-path=./lighthouse-2.json \
  --chrome-flags="--headless"

npx lighthouse https://example.com/ \
  --form-factor=mobile \
  --only-categories=performance,accessibility,best-practices,seo \
  --output=json \
  --output-path=./lighthouse-3.json \
  --chrome-flags="--headless"

Lighthouse's standard configuration is mobile-oriented, but explicitly use:

--form-factor=mobile

so there is no ambiguity.

---

## Calculate the median Lighthouse scores

Create:

site/lighthouse-median.mjs

with:

import fs from "node:fs";

const files = [
  "lighthouse-1.json",
  "lighthouse-2.json",
  "lighthouse-3.json",
];

const reports = files.map((file) =>
  JSON.parse(fs.readFileSync(file, "utf8"))
);

const categories = [
  "performance",
  "accessibility",
  "best-practices",
  "seo",
];

for (const category of categories) {
  const scores = reports
    .map((report) =>
      Math.round(report.categories[category].score * 100)
    )
    .sort((a, b) => a - b);

  console.log(
    `${category}: ${scores.join(", ")} — median ${scores[1]}`
  );
}

Run:

node lighthouse-median.mjs

Report the result clearly, for example:

LIVE MOBILE LIGHTHOUSE — 3-run median

Performance:     97
Accessibility:  100
Best Practices: 100
SEO:            100

Keep the three individual scores available as well because a median without the underlying runs can hide variability.

---

# 7. Add a custom domain — MANUAL CLOUDFLARE DASHBOARD STEP

Do not guess DNS changes and do not automatically change the user's DNS.

Tell me to perform these clicks:

1. Open the Cloudflare Dashboard.
2. Click **Workers & Pages**.
3. Click the correct Pages project.
4. Click **Custom domains**.
5. Click **Set up a domain**.
6. Enter the desired domain, for example:

example.com

or:

www.example.com

7. Click **Continue**.
8. Review the DNS information Cloudflare shows.

Then STOP AND WAIT FOR ME.

Do not assume the domain has been activated until I confirm it or its status can be verified.

### If this is an apex/root domain

Example:

example.com

Cloudflare requires the domain/zone to be managed appropriately in Cloudflare, including the required nameserver configuration.

### If this is a subdomain

Example:

www.example.com

or:

site.example.com

Cloudflare may create the appropriate DNS record automatically if the zone is already managed by Cloudflare.

If DNS is managed somewhere else, Cloudflare may instruct me to create a CNAME pointing the hostname to:

<project-name>.pages.dev

Do not merely create a CNAME without first adding the custom domain through the Pages project's **Custom domains** screen.

---

# 8. FIRST-TIME CUSTOM-DOMAIN LAUNCH — rebuild after the domain is active

If the first deployment was a staging deployment using:

https://<project>.pages.dev

then attaching the custom domain is NOT the last step.

After the custom domain is active:

### Change Astro

In:

site/astro.config.mjs

change:

site: "https://<project>.pages.dev",

to the actual canonical domain:

site: "https://example.com",

or:

site: "https://www.example.com",

### Disable noindex

Change:

const noindex = true;

to:

const noindex = false;

### Announce the mode

Before deployment say:

MODE: PRODUCTION LAUNCH
Canonical domain: https://example.com
Noindex: OFF

### Rebuild

cd site
npm run build
cd ..

### Deploy again

npx wrangler pages deploy site/dist --project-name <name> --branch main

---

# 9. Repeat final production verification

After the real domain is live, repeat the checks against the CUSTOM DOMAIN, not merely `pages.dev`.

Confirm:

- homepage final response = 200
- every sitemap page = 200
- sitemap URLs use the live domain
- canonical URLs use the live domain
- no canonical contains localhost
- no canonical contains `pages.dev`
- production pages do not contain `noindex`
- robots.txt does not accidentally block the whole production site
- HTTPS works
- trailing slash behavior is correct
- all three Lighthouse mobile runs were performed against the live production homepage
- report the median Lighthouse scores

Final deployment summary should look like:

MODE: PRODUCTION LAUNCH

Project: my-example-site
Live domain: https://example.com
Cloudflare Pages: https://my-example-site.pages.dev
Build: PASS
Sitemap URLs checked: 12/12 returned 200
Canonical URLs: PASS
No localhost canonicals: PASS
No pages.dev production canonicals: PASS
Noindex: OFF
robots.txt: PASS

Lighthouse mobile — 3-run median
Performance: 97
Accessibility: 100
Best Practices: 100
SEO: 100

Do not call the production deployment complete until the live-domain checks pass.