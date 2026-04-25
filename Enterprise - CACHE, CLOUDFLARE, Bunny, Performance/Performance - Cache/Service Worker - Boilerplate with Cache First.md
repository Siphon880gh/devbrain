

Cache first means to pull assets from cache if exist, otherwise fetch from internet network (Remember whether the server returns cached or fresh is another cache layer to address - [[Cache busting as the developer and sys admin]])

If you're analyzing the logic of why this works, the sequence of events that trigger are:
1. install
2. activate
3. fetch
And a more in-depth explanation is at [[Service Worker - Cache Busting]]

```
const CACHE_NAME = `wengindustries-runs-app-cache-v7.7`;  
const PRECACHE_URLS = ['/']; // Add other essential files to pre-cache if needed  
  
// Pre-cache initial resources  
self.addEventListener('install', (event) => {  
  console.log("sw.js: install");  
  event.waitUntil(  
    caches.open(CACHE_NAME).then((cache) => {  
      return cache.addAll(PRECACHE_URLS);  
    })  
  );  
  self.skipWaiting(); // Activate immediately  
});   
  
// Clean up old caches  
self.addEventListener('activate', (event) => {  
  console.log("sw.js: activate");  
  event.waitUntil(  
    caches.keys().then((cacheNames) => {  
      return Promise.all(  
        cacheNames.map((cacheName) => {  
          if (cacheName !== CACHE_NAME) {  
            console.log("Deleted cache: " + cacheName);  
            console.log("Will store into new cache on successful fetches");  
            return caches.delete(cacheName); // Delete old caches  
          } else {  
            console.log("Using cache: " + cacheName)  
          }  
        })  
      );  
    })  
  );  
  self.clients.claim(); // Claim control immediately  
});  
  
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