Requirement: That prerendering works on localhost per [[Option 2 - Pre-render all pages in the background when server starts]]

---

TYPE:
This prerendering strategy actually renders the React app then visits the exercise URL so that a modal dynamically appears. Then Pupppeteer captures the HTML of the modal and saves as prerendered HTML.

  

STATUS:
Prerendered works on localhost! Visit `http://localhost:3000/exercise/benchpress` directly and see that it delivered in place prerendered/exercise/benchpress which has the meta tags and has content inside `<body id="root">...</body>`. However, setup with Heroku was a bit complicated, and was moot when memory limits keep closing the dyno.

  

FOR HEROKU:
Here’s a streamlined, step-by-step guide for running Puppeteer (v19+, particularly 24.10.2) with headless Chrome on Heroku:

  

---

  

## 📦 1. Commit Snapshot

  

> **Commit:** “Fixing for Heroku again by adjusting buildpacks and npm scripts because Puppeteer v19+ changed Chrome location, cache location, and install commands.”

  

This is where:

  

1. Your prerender script runs vite build, loads your home route (e.g. home.jsx), visits the modal’s URL on that page in order to open the modal dynamically, and then saves the modal’s HTML as prerendered HTML.

2. You adjust buildpacks, Apt packages, and npm scripts to match Puppeteer’s new installation paths.

  

---

  

## ⚙️ 2. Add the Apt Buildpack & Chrome Buildpack

  

Create a shell script (`add-heroku-buildpacks.sh`) and run it once per Heroku repo:

  

```bash

# clear any existing buildpacks

heroku buildpacks:clear -a <your-app-name>

  

# 1) Apt (for Debian libs)

heroku buildpacks:add --index 1 heroku-community/apt

  

# 2) Puppeteer Chrome installer

heroku buildpacks:add --index 2 https://github.com/jontewks/puppeteer-heroku-buildpack

  

# 3) Node.js

heroku buildpacks:add --index 3 heroku/nodejs

```

  

---

  

## 📥 3. List Required Debian Packages

  

In your project root, create an **Aptfile** containing all the libs Puppeteer needs:

  

```

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

  

---

  

## 🔧 4. Update Your npm Scripts

  

In your `package.json`:

  

```jsonc

{

// … other scripts …

"scripts": {

"postinstall": "npm_config_loglevel=silly npx puppeteer browsers install chrome",

"heroku-postbuild": "vite build && mkdir -p ./.cache && mv /app/.cache/puppeteer ./.cache"

}

}

```

  

* **`postinstall`** uses Puppeteer’s new CLI:

```bash

npx puppeteer browsers install chrome

```

It used to be `npx puppeteer install --product=chrome` which no longer works.

* **`heroku-postbuild`**

1. Builds your Vite app.

2. Creates a local `.cache` folder.

3. Moves Chrome’s cache into your repo’s `.cache` so it survives across dyno restarts.

  

---

  

## 🔑 5. Set Required Environment Variables

  

In your Heroku dashboard (or via CLI):

  

```bash

# Skip Puppeteer’s default download (since the jontwerks/puppeteer-heroku-buildpack buildpack already installs Chrome)

heroku config:set PUPPETEER_SKIP_DOWNLOAD=true

```

  

---

  

## 🔍 6. Locating the Chrome Executable

  

Chrome ends up under your app folder, e.g.:

  

```

/app/.cache/puppeteer/chrome/linux-137.0.7151.119/chrome-linux64/chrome

```

  

To confirm:

  

1. **Enable debug logs:**

  

```bash

heroku config:set NPM_CONFIG_LOGLEVEL=silly -a <your-app-name>

```

2. **Deploy** and watch the build logs for the exact path.

3. **OR** run a one-off dyno shell:

  

```bash

heroku ps:exec -a <your-app-name>

# then inside:

npx puppeteer browsers install chrome

```

  

Use that path when you launch Puppeteer:

  

```js

const browser = await puppeteer.launch({

executablePath: process.env.CHROME_PATH || '/app/.cache/puppeteer/.../chrome',

args: ['--no-sandbox', '--disable-setuid-sandbox'],

});

```

  

---

  

## 📝 7. Heroku Buildpack Quirk

  

> As of **March 17, 2025**, Heroku’s Node.js classic buildpack skips your `"build"` script if it detects a `"heroku-postbuild"` script.

> So any changes in your normal `"build"` must live inside `"heroku-postbuild"`.

  

---

  

## ⚠️ 8. Managing Dyno Memory Limits

  

Standard dynos have **512 MB** RAM. A Chrome install during build can push you over:

  

* **Tip:** After adjusting buildpacks, clear your cache to force a fresh install:

  

```bash

heroku builds:cache:purge -a <your-app-name>

```

  

---

  

### ✅ Summary Checklist

  

1. [ ] **Aptfile** with all libs

2. [ ] `add-heroku-buildpacks.sh` (apt → puppeteer buildpack → nodejs)

3. [ ] `postinstall` & `heroku-postbuild` npm scripts

4. [ ] `PUPPETEER_SKIP_DOWNLOAD=true` env var

5. [ ] Confirm Chrome path in logs or via `heroku ps:exec`

6. [ ] Move launch logic to use `executablePath`

7. [ ] Clear build cache after major changes

  

With this in place, your Vite+React app will prerender via Puppeteer on Heroku, using headless Chrome reliably—even under the new Puppeteer v19+ layout and Heroku buildpack behavior.

  

---

  

One more thing. Your package.json has them all in dependencies because the prerendering on Heroku is a npm run build process that requires vite to be on Heroku:

  

```

"dependencies": {

"@fingerprintjs/fingerprintjs": "^4.6.2",

"@vitejs/plugin-react": "^4.2.0",

"cors": "^2.8.5",

"dotenv": "^16.5.0",

"express": "^4.18.2",

"framer-motion": "^12.10.4",

"mongoose": "^8.14.2",

"node-fetch": "^3.3.2",

"nodemailer": "^7.0.3",

"path": "^0.12.7",

"react": "^18.2.0",

"react-dom": "^18.2.0",

"react-helmet-async": "^2.0.5",

"react-router-dom": "^6.22.0",

"redis": "^5.1.0",

"workbox-cacheable-response": "^7.0.0",

"workbox-core": "^7.0.0",

"workbox-expiration": "^7.0.0",

"workbox-precaching": "^7.0.0",

"workbox-recipes": "^7.0.0",

"workbox-routing": "^7.0.0",

"workbox-strategies": "^7.0.0",

"@prerenderer/prerenderer": "^1.2.5",

"@prerenderer/renderer-puppeteer": "^1.2.4",

"puppeteer": "^24.10.2",

"@tailwindcss/postcss": "^4.1.8",

"autoprefixer": "^10.4.21",

"nodemon": "^3.1.10",

"postcss": "^8.5.4",

"tailwindcss": "^4.1.8",

"vite": "^6.3.5"

}

```