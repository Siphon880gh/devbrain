
**Introduction:**  
Deploying a Puppeteer-powered Node.js application on Heroku requires more than just pushing your code—you need the right native libraries and Chromium binaries in place before Node.js runs your app. By using the heroku-community/apt buildpack to install Debian packages, then Puppeteer’s custom buildpack for Chromium, and finally the official Node.js buildpack, you’ll avoid missing-dependency errors and enjoy smooth, repeatable deploys.

---

## 1. Install Debian Libraries with an Aptfile

Heroku’s [apt buildpack](https://github.com/heroku/heroku-buildpack-apt) lets you install Debian packages listed in an `Aptfile` at build time. Puppeteer and Chromium depend on several native libraries—without them, Chrome won’t launch in a dyno.

1. **Create an `Aptfile`** in your project root:
    
    ```
    fonts-liberation
    libnss3
    libx11-xcb1
    libxcomposite1
    libxdamage1
    libxrandr2
    libatk1.0-0
    libatk-bridge2.0-0
    libgtk-3-0
    libasound2
    libxss1
    libxtst6
    libpci3
    libxcb1
    libglib2.0-0
    ```
    
2. **What this does:** During `heroku build`, the apt buildpack runs `apt-get update && xargs apt-get install -y` on each package above, ensuring Chromium has all its dependencies.
    

---

## 2. Verifying Your Buildpack Order

The order of buildpacks determines how Heroku sets up your environment. To see your current stack:

```bash
heroku buildpacks -a your-app-name
```

For Puppeteer and Chrome, depending on which setup you follow according to [[Heroku - Puppeteer and Chrome]]

You either want this setup 
```
1. heroku-community/apt
2. https://github.com/jontewks/puppeteer-heroku-buildpack
3. heroku/nodejs
```

Or that setup:
```
1. heroku-community/apt
2. heroku/nodejs
```

You could create a ./script.sh that has been granted `chmod u+x` that can quickly set your buildpacks. For example ./script.sh:
```
heroku buildpacks:clear  
heroku buildpacks:add --index 1 https://github.com/heroku/heroku-buildpack-apt  
heroku buildpacks:add --index 2 https://github.com/jontewks/puppeteer-heroku-buildpack  
heroku buildpacks:add --index 3 heroku/nodejs
```

---

## 3. Adding a Buildpack at a Specific Position

To insert a buildpack without reshuffling everything manually, use `--index`. For example, if you accidentally added Node.js before apt and want to move apt to slot 1:

```bash
heroku buildpacks:add --index 1 heroku-community/apt -a your-app-name
```

---

## 4. Clearing All Buildpacks

If you ever need to start from scratch—say you’ve experimented with multiple buildpacks—you can wipe your stack clean:

```bash
heroku buildpacks:clear -a your-app-name
```

---

## 5. Recommended Three-Step Buildpack Stack

1. **heroku-community/apt**
    
    - Installs all native Debian libraries your app and Chromium need.
        
2. **jontewks/puppeteer-heroku-buildpack**
    
    - Downloads and caches a compatible Chromium binary for Puppeteer.
        
3. **heroku/nodejs**
    
    - Installs your Node.js dependencies and runs your build/postbuild scripts.
        

By layering them in this order, you ensure that:

- APT dependencies are in place **before** Chromium downloads,
    
- Chromium is present **before** Node.js installs Puppeteer,
    
- Your Node.js code can launch Puppeteer/Chromium reliably in every dyno.
    

---

With this setup, your Puppeteer-based scraping, prerendering, or testing scripts will run without “missing Chrome binary” errors—and your Heroku deploys will remain predictable and reproducible. Happy deploying!