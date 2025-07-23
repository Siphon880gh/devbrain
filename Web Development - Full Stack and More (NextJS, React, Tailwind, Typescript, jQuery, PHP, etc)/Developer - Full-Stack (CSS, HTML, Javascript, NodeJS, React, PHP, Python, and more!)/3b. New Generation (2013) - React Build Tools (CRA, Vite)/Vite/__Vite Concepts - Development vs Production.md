Although you could simply run a command and the Vite boilerplate would be created ready for developer and production server, like per [[__Vite PRIMER]], you should know the theory on why the boilerplate has the code as they do in order to support a split workflow of running a hot module development server and a ready-serve production build.

---
When you build a single-page app (SPA) with Vite, your development workflow and your production deployment have very different needs. In development, you want fast rebuilds, hot-module replacement, rich source maps and instant feedback. In production, you want to serve highly optimized, pre-bundled assets from a `dist` folder, along with a simple fallback route so client-side navigation always hits your `index.html`.

This guide walks you through wiring up a Node.js server (Express, Koa, etc.) to:

1. **In development:**
    - Launch Vite’s dev server in middleware mode.
    - Leverage HMR and Vite’s asset pipeline—**never** serve from `dist`.
        
2. **In production:**
    - Serve the static build artifacts from `dist`.
    - Add exactly one catch-all route (`* → index.html`) to support client-side routing.

By cleanly separating these two modes, you avoid serving stale bundles while developing, and you ensure a lean, cache-friendly deployment in production. Let’s dive in.

---

## Development Setup

In development mode, you want the full power of Vite’s dev server—hot module replacement (HMR), fast rebuilds, and source maps—so you’ll **never** serve your `dist` folder. Instead, spin up Vite in middleware mode and let it handle all requests:

1. **Install Dependencies**
    
    ```bash
    npm install vite express
    # or
    yarn add vite express
    ```
    
2. **Create Your Dev Server**  
    In your `server.js` (or `index.js`), configure Express to load Vite’s middleware when `NODE_ENV !== 'production'`:
    
    ```js
    import express from 'express';
    import { createServer as createViteServer } from 'vite';
    
    async function startDev() {
      const app = express();
    
      // Create Vite dev server in middleware mode
      const vite = await createViteServer({
        root: process.cwd(),
        server: { middlewareMode: true },
      });
    
      // Let Vite handle asset requests and HMR
      app.use(vite.middlewares);
    
      // (Optional) Add your API routes here
      app.get('/api/hello', (req, res) => {
        res.json({ msg: '👋 Hello from your dev API!' });
      });
    
      app.listen(3000, () => {
        console.log('🚀 Dev server running at http://localhost:3000');
      });
    }
    
    startDev();
    ```
    
3. **How It Works**
    
    - **Middleware Mode**: Vite intercepts requests, serves unbundled modules, and injects HMR code.
        
    - **No `dist`**: Pointing at `dist` in development will bypass HMR and source maps—avoid it entirely.
        
    - **Rapid Feedback**: Edit a component, save, and Vite pushes updates to the browser in milliseconds.
        

---

## Production Setup

In production, you need to serve pre-built, cache-friendly assets. Your server should:

- Host everything under `dist/` (the output of `vite build`), and
    
- Provide a single “catch-all” route to return `index.html` for any unknown path (so client-side routing still works).
    

1. **Build Your App**
    
    ```bash
    npm run build
    # or
    yarn build
    # runs `vite build`; output goes to ./dist
    ```
    
2. **Serve Static Files & Index**  
    Update `server.js` to switch into production mode:
    
    ```js
    import express from 'express';
    import path from 'path';
    import fs from 'fs';
    
    async function startProd() {
      const app = express();
      const root = process.cwd();
      const distPath = path.resolve(root, 'dist');
    
      // Serve all assets (JS/CSS/images) from dist
      app.use(express.static(distPath, { index: false }));
    
      // Fallback: serve index.html for client-side routes
      app.use('*', (req, res) => {
        const html = fs.readFileSync(
          path.join(distPath, 'index.html'),
          'utf-8'
        );
        res.type('text/html').send(html);
      });
    
      app.listen(3000, () => {
        console.log('📦 Production server running at http://localhost:3000');
      });
    }
    
    startProd();
    ```
    
3. **Key Points**
    
    - **`express.static`** serves your hashed asset files with optimal caching headers.
        
    - **Catch-All Route** (`app.use('*', …)`): ensures any path (e.g. `/dashboard`, `/profile/123`) returns `index.html` so your SPA router can take over.
        
    - **No Vite Middleware**: production is all about static files—don’t include dev-only middleware here.
        

---

## Summary

- **Never** serve `dist/` in development—always use Vite’s middleware for HMR and source maps.
    
- **Only** serve `dist/` in production, paired with exactly **one** catch-all route to power client-side navigation.
    
- Keeping these modes completely separate safeguards against stale builds in development and unoptimized delivery in production.
    

With this pattern, you’ll enjoy a blazing-fast developer experience and a rock-solid, cache-friendly SPA deployment.