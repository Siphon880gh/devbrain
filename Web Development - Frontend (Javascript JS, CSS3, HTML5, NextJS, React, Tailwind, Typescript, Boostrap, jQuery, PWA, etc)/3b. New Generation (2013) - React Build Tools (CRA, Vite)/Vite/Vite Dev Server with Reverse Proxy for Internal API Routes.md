When developing a frontend React app with Vite, you'll often also need a separate Express server to handle API requests—especially for dynamic data like user content, product listings, or backend services. Since both can’t run on the same port, the Express server usually runs on a different one (e.g. `3001`) while Vite’s dev server runs on `3000` for hot reloading.

To bridge the two during development, Vite can proxy specific routes (like `/api/*` or `/internal/*`) to your Express server. This setup makes your frontend feel like it's talking to a unified server and avoids CORS issues or changing URLs in code.

Here’s how you set that up:

```js
// vite.config.js
export default {
  server: {
    port: 3000,
    proxy: {
      '/api': {
        target: 'http://localhost:3001',
        changeOrigin: true,
        secure: false,
      },
      '/internal': {
        target: 'http://localhost:3001',
        changeOrigin: true,
        secure: false,
      },
    },
  },
};
```

### ✅ Why This Helps:

- **Unified dev experience**: Your React app fetches from `/api/...` without needing to know the backend runs separately.
- **Avoids CORS issues**: Requests stay on the same origin from the browser’s perspective.
- **Supports clean separation**: Keeps frontend and backend logic organized while still tightly integrated during development.
