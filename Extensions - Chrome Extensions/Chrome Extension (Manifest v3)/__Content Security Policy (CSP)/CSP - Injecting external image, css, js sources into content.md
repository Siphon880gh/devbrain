If your chrome extension adds images to the web content at the current active tab and those images are external but they’re not loading... it’s possible their website blocked external images from loading.

You can remedy this by adding a content script that adds CSP rules into the HTML (NOT into the Chrome Extension's manifest.json). See "content-enables-external-img.js”:
```
    "content_scripts": [
        {
            "matches": ["<all_urls>"],
            "js": ["content.js", "content-enables-external-img.js"],
            "run_at": "document_start"
        }
    ],

```

That content-enables-external-img.js:
```
console.log("content-enables-external-img running")

/** Doesn't work on all websites. 
 * Apple.com still blocks images from your templates from loading, whereas this is effective on bmwusa.com 
 * There's no workaround. */
const metaTags = document.getElementsByTagName('meta');
for (let i = 0; i < metaTags.length; i++) {
  if (metaTags[i].getAttribute('http-equiv') === 'Content-Security-Policy') {
    // Modify the CSP content attribute to allow external images
    const cspContent = metaTags[i].getAttribute('content');
    metaTags[i].setAttribute('content', cspContent + " img-src *;");
    metaTags[i].setAttribute('content', cspContent + " connect-src *;");
  }
}

```