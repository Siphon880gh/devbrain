### What Triggers a Service Worker Update

- A change in the **service worker file itself** (e.g., `service-worker.js`) — even a single byte.
- A different URL or content hash of the file registered by `navigator.serviceWorker.register()`.
- Useful when your cache strategy changes (because you implement the cache strategy in the service worker js)

### 🧹 Resetting Old Caches

Triggering a service worker update **does not** by itself ensure that old asset caches are reset or deleted.

To reset old caches (e.g., when your assets change), you must:

#### 1. Use versioned cache names:

```js
const CACHE_NAME = 'my-app-cache-v2';
```

#### 2. In your `activate` event, delete old caches:
```js
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames =>
      Promise.all(
        cacheNames.map(name => {
          if (name !== CACHE_NAME) {
            return caches.delete(name);
          }
        })
      )
    )
  );
});
```

---

### 🟡 What `manifest.json` Version Field Does

The `"version"` field in `manifest.json` is **not used by browsers or service workers** to trigger any behavior. It won't reset the service worker or reset your cache. Manifest.json's version is purely:

- Informational for developers
- Sometimes used by update scripts or display logic
