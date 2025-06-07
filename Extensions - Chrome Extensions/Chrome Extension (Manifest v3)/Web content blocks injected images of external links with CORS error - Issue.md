
Firstly you override img-src to everything. Add to manifest.json: img-src 'self' *: 

But the website may have its own CSP that blocked external images other than what they allow. No fret. You can modify their CSP. Notice this doesn’t work on all websites and there’d be no workarounds for that (fails at apple.com but success at bmwusa). It depends on their implementation of CSP.
```
console.log("content-enable-external-img running")

/** Doesn't work on all websites. 
 * Apple.com still blocks images from your DOM manipulation from loading, whereas this is effective on bmwusa.com 
 * There's no workaround. */
const metaTags = document.getElementsByTagName('meta');
for (let i = 0; i < metaTags.length; i++) {
  if (metaTags[i].getAttribute('http-equiv') === 'Content-Security-Policy') {
    // Modify the CSP content attribute to allow external images
    const cspContent = metaTags[i].getAttribute('content');
    metaTags[i].setAttribute('content', cspContent + " img-src *;");
  }
}
```

Then just have at manifest.js contents_scripts:
```
        {
            "matches": ["<all_urls>"],
            "js": ["content-enable-external-img.js"],
            "run_at": "document_start"
        },
```