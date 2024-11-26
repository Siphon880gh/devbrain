Service worker will be another layer of caching right before it displays to the user. When the cache at the service worker is busted, then it will use the fresh copy or the cache copy depending on server settings. So you may want to cache bust at server too as a requirement before proceeding to cache busting on the service worker. Refer to [[Cache busting as the developer and sys admin]].

---

Lets say your service-worker.js or sw.js is coded the typical way and your index.js registeres that service worker file. Your service worker would cache all js, css files. And there should be a CACHE_NAME string variable at the top. Everytime you need to cache bust on users’ service workers, you would change the CACHE_NAME to do so. This is because during the `activate` event, the service worker compares the current `CACHE_NAME` with existing cache keys. It removes old caches with names different from the current `CACHE_NAME` , this makes sure the next key step will cover correctly.

```
        cacheNames.map((cacheName) => {
          if (cacheName !== CACHE_NAME) {
            return caches.delete(cacheName); // Delete old caches
          }
        })
```

^ If internet is ON and it still uses old cache, then it’s using your header’s settings for cache (nginx or php or html)

---

During a fetch, you have possible scenarios:

“Network First" or "Network Falling Back to Cache" - prioritizing fresh network data, but gracefully degrading to cached content if the network is unavailable.  

```
// Intercept fetch requests
self.addEventListener('fetch', (event) => {
  console.log("sw.js: fetch");
  if (event.request.url.includes('.js') || 
  event.request.url.includes('.css') || 
  event.request.url.includes('.html') || 
  event.request.url.includes('.png') || 
  event.request.url.includes('.jpg') || 
  event.request.url.includes('.svg')) {
      
    event.respondWith(
      (async () => {
        const cache = await caches.open(CACHE_NAME);

        try {
          // Try to fetch the resource from the network
          const fetchResponse = await fetch(event.request);

          // Check if it's a valid response before caching
          if (fetchResponse.ok) {
            cache.put(event.request, fetchResponse.clone());
          }

          return fetchResponse; // Return the fresh response
        } catch (e) {
          // If fetching fails, fall back to the cache
          return cache.match(event.request);
        }
      })()
    );
  } // if cachable file type
});
```

  

"Cache First" approach for static assets. If cached, returns the cached version immediately. If not in cache, fetches from network and then caches it. Then if network request fails, throw an error.

```
self.addEventListener('fetch', (event) => {
  // Only intercept requests for static assets
  if (event.request.url.includes('.js') || 
      event.request.url.includes('.css') || 
      event.request.url.includes('.html') || 
      event.request.url.includes('.png') || 
      event.request.url.includes('.jpg') || 
      event.request.url.includes('.svg')) {
    
    event.respondWith(
      (async () => {
        const cache = await caches.open(CACHE_NAME);
        
        // First, check if the resource is in cache
        const cachedResponse = await cache.match(event.request);
        
        if (cachedResponse) {
          // If cached, return the cached version immediately
          return cachedResponse;
        }
        
        try {
          // If not in cache, fetch from network
          const fetchResponse = await fetch(event.request);
          
          // Check if it's a valid response before caching
          if (fetchResponse.ok) {
            cache.put(event.request, fetchResponse.clone());
          }
          
          return fetchResponse;
        } catch (e) {
          // If network fetch fails and not in cache, return a fallback
          return new Response('Offline', { status: 404 });
        }
      })()
    );
  }
});
```

For boilerplate of the entire service worker with Cache First approach: [[Service Worker - Boilerplate with Cache First]]

---

If your server keeps caching service-worker.js or sw.js, any changes you make including changing the CACHE_NAME in order to cache bust on users’ service worker WILL FAIL. So do not let your server cache any service workers:

```
  # Disable caching for service worker files
  location ~* /.*sw\.js$ {
      add_header Cache-Control "no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0";
      add_header Pragma "no-cache";
      add_header alt-svc 'h3=":443"; ma=86400';
      expires -1;
  }
  location ~* /.*service-worker\.js$ {
      add_header Cache-Control "no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0";
      add_header Pragma "no-cache";
      add_header alt-svc 'h3=":443"; ma=86400';
      expires -1;
  }
```
