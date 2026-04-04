If you’re developing / making changes to the app and you can’t see the changes because the service worker is STILL in the way.

And if service worker still forcefully caching (you’re not seeing the steps you need) and you’ve done the steps to cache bust on service worker including changing the CACHE_NAME ([[Service Worker - Cache Busting]]) so that a new fetch is done instead of pulling from cache store, AND your server is setup to send cache busting headers ([[Cache busting as the developer and sys admin]]), THEN this is your final resort

Disable registering service worker. Often found at index.html, similar to appearance to:
```
    <script>  
        if ('serviceWorker' in navigator) {  
            window.addEventListener('load', () => {  
                navigator.serviceWorker.register('/sw.js', {  
                scope: 'https://therunner.app'  
            })  
                .then(registration => {  
                    console.log('Service Worker registered with scope:', registration.scope);  
                })  
                .catch(error => {  
                    console.error('Service Worker registration failed:', error);  
                });  
            });  
        }  
    </script>
```

So comment that off

Then forcefully reset the cache on your web browser. Refer to [[Cache busting from client side (You are the client)]]