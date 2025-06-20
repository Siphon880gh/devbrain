# Choosing the Right Puppeteer + Chrome Setup on Heroku

When deploying Puppeteer (or puppeteer-core) on Heroku, you have two main ways to supply a headless Chrome binary:

1. **Let Puppeteer download Chrome** during `npm install`
    
2. **Use the jontewks Puppeteer buildpack** to pre-bundle Chromium
    

Each approach has trade-offs in slug size, build time, and complexity. Below is a side-by-side guide and configuration steps for both.

---

## 1. Full Puppeteer Package (No Chromium Buildpack)

**How it works:**

- You install the full `puppeteer` npm package.
    
- During `npm install`, Puppeteer’s `install.js` automatically downloads a matching Chromium into `/app/.cache/puppeteer`.
    
- At runtime, you launch with Puppeteer’s default binary path.
    

### Buildpacks

```bash
heroku buildpacks:clear
heroku buildpacks:add --index 1 heroku-community/apt
heroku buildpacks:add --index 2 heroku/nodejs
```

### Aptfile (system libraries)

```text
# repo root → Aptfile
fonts-liberation
libappindicator3-1
xdg-utils
libnss3
libatk1.0-0
libatk-bridge2.0-0
libcups2
libxkbcommon0
libx11-xcb1
libxcomposite1
libxdamage1
libxrandr2
```

### package.json

```jsonc
{
  "dependencies": {
    "puppeteer": "^24.10.2",
    // …
  }
  // No PUPPETEER_SKIP_DOWNLOAD defined,
  // so Puppeteer will fetch Chromium on install.
}
```

### Launch code

```js
const launchOptions = {
  headless: true,
  args: ['--no-sandbox','--disable-setuid-sandbox']
};
const browser = await puppeteer.launch(launchOptions);
```

---

## 2. Puppeteer (or puppeteer-core) + jontewks Buildpack

**How it works:**

- The `jontewks/puppeteer-heroku-buildpack` downloads a compatible Chromium binary into `PUPPETEER_EXECUTABLE_PATH`.
    
- To avoid Puppeteer redundantly downloading its own copy, you set `PUPPETEER_SKIP_DOWNLOAD=true`.
    
- At runtime, you point Puppeteer at the buildpack’s binary.
    

### Buildpacks

```bash
heroku buildpacks:clear
heroku buildpacks:add --index 1 heroku-community/apt
heroku buildpacks:add --index 2 https://github.com/jontewks/puppeteer-heroku-buildpack
heroku buildpacks:add --index 3 heroku/nodejs
```

### Aptfile (supporting libs only)

```text
# repo root → Aptfile
fonts-liberation
libappindicator3-1
xdg-utils
libnss3
libatk1.0-0
libatk-bridge2.0-0
libcups2
libxkbcommon0
libx11-xcb1
libxcomposite1
libxdamage1
libxrandr2
```

### Environment variable

```bash
heroku config:set PUPPETEER_SKIP_DOWNLOAD=true
```

### package.json

```jsonc
{
  "dependencies": {
    "puppeteer": "^24.10.2"
    // or "puppeteer-core": "^X.Y.Z"
  },
  "scripts": {
    // No postinstall needed because download is skipped
  }
}
```

### Launch code

```js
const launchOptions = {
  headless: true,
  args: ['--no-sandbox','--disable-setuid-sandbox'],
  ...(process.env.PUPPETEER_EXECUTABLE_PATH && {
    executablePath: process.env.PUPPETEER_EXECUTABLE_PATH
  })
};
const browser = await puppeteer.launch(launchOptions);
```

---

## Comparison

|Aspect|Full Puppeteer Only|jontewks Buildpack|
|---|---|---|
|**Chromium source**|Downloaded by `install.js`|Downloaded by buildpack into `PUPPETEER_EXECUTABLE_PATH`|
|**Build time**|+~100 MB download on every deploy|Faster, since buildpack caches its Chromium|
|**Slug size**|Larger (~150 MB)|Smaller, since Puppeteer skips its own download|
|**Config complexity**|Minimal (no extra env vars)|Needs `PUPPETEER_SKIP_DOWNLOAD=true` and buildpack order|

---

## Which Should You Choose?

- **Full Puppeteer** is simplest if you don’t mind the extra 100 MB download on each deploy and a larger slug.
    
- **jontewks Buildpack** is ideal for faster builds and smaller slugs, at the cost of one extra env var and buildpack configuration.
    

Whichever route you pick, be sure your `Procfile` simply starts your server (e.g. `web: npm start`), and your code’s dynamic `executablePath` logic handles both local and Heroku environments seamlessly.