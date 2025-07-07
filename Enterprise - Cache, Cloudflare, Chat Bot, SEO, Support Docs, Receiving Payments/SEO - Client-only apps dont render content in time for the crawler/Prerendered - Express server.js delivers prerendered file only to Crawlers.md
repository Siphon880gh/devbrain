A strategy is to only deliver the prerendered file to crawlers and it seems good at first glance to only deliver the prerendered file to crawlers only. But in fact, you wouldn't want a user that bookmark a page that's been routed by React Router Dom, and then visiting the bookmark goes 404. Delivering a prerendered file should happen regardless if it's an user or a crawler, HOWEVER, you could deliver two versions of the prerendered file. The prerendered file that the bot sees should be optimized for speed (keeping SEO score up), whereas the prerendered file that the user sees can be optimized for user experience.

One common situation is Lazy Load
- Express detect user agent if a dealer like googlebot. If it is, you want to give full html without lazy load
- But a Lazy Load interface for users feel more smooth and modern

Here's code that:
1. **Sends a `speedOptimizedPreferredFile` to bots** (if it exists),
2. Falls back to the **normal prerendered file** for non-bots (if it exists),
3. Then finally falls back to **SPA**

```
const path = require('path');
const fs = require('fs');

app.get('/', (req, res, next) => {
  const userAgent = req.get('User-Agent') || '';
  const isBot = /googlebot|bingbot|ahrefsbot/i.test(userAgent);

  console.log(`User-Agent: ${userAgent}`);
  console.log(`Is bot: ${isBot}`);

  // Bot logic – try speed optimized version first
  if (isBot) {
    const speedOptimizedFile = path.join(prerenderedPath, 'index-speed.html');
    if (fs.existsSync(speedOptimizedFile)) {
      console.log(`Serving speed-optimized pre-rendered file for bot: ${speedOptimizedFile}`);
      return res.sendFile(speedOptimizedFile);
    }
  }

  // For all users – serve regular prerendered file if it exists
  const prerenderedFile = path.join(prerenderedPath, 'index.html');
  if (fs.existsSync(prerenderedFile)) {
    console.log(`Serving regular pre-rendered file: ${prerenderedFile}`);
    return res.sendFile(prerenderedFile);
  }

  // Fallback to SPA
  console.log('Serving SPA – no pre-rendered file found');
  next();
});
```

You can test that the speed optimized prerendered file gets rendered by hardcoding `if (isBot)` to `if (true)` temporarily.