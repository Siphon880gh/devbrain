**Best Practices for Prerendering HTML in SPAs for SEO (When Crawlers Don't Wait for JS)**:
- The server only serves prerendered files when `NODE_ENV=production`. This avoids using cached output during development, allowing you to see live code changes.
- If you're working on prerendering scripts and want to preview the prerendered output, you **must run the app in production mode**. Make sure your `start` script in `package.json` sets the environment variable, as it best practice even outside of prerendering html:

```json
"scripts": {
  "start": "NODE_ENV=production node server.js"
}
```

- Before starting the server, **build the app** so that the prerendered files are generated and ready:

```bash
npm run build
```

- Then start the server:

```bash
npm start
```

This ensures the server detects and serves the prerendered files properly.
