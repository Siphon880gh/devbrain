
Let's say there's a specific file you do not want to cache

At the express side, prevent caching of that file:
```
  // Add specific route for file.json with no-cache headers  
  app.get('/file.json', (req, res) => {  
    res.setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');  
    res.setHeader('Pragma', 'no-cache');  
    res.setHeader('Expires', '0');  
    res.sendFile(path.join(distPath, 'file.json'));  
  });
```

At the service worker js file, always fetch a fresh copy:
```
  // Always fetch file.json from network
  if (event.request.url.endsWith('file.json')) {
    event.respondWith(
      fetch(event.request)
        .then(response => {
          console.log('Fetching file.json from network');
          return response;
        })
        .catch(error => {
          console.error('Error fetching file.json:', error);
          return new Response('Error fetching file.json', { status: 500 });
        })
    );
    return;
  }

  event.respondWith(
    caches.match(event.request)
      .then((response) => {
        // Cache hit - return response
        if (response) {
          console.log('Serving from cache:', event.request.url);
          return response;
        }

        // Clone the request
        const fetchRequest = event.request.clone();

        return fetch(fetchRequest)
          .then((response) => {
            // Check if we received a valid response
            if (!response || response.status !== 200 || response.type !== 'basic') {
              return response;
            }

            // Clone the response
            const responseToCache = response.clone();

            // Open cache and store the response
            caches.open(CACHE_NAME)
              .then((cache) => {
                cache.put(event.request, responseToCache);
                console.log('Caching new resource:', event.request.url);
              });

            return response;
          })
          .catch(() => {
            // If fetch fails, try to serve from cache
            return caches.match(event.request);
          });
      })
  );
}); 
```