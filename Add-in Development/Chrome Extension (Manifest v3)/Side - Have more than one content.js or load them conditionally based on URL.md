
In Chrome Extension development with Manifest V3, you can have multiple content scripts. Here's how you can define multiple content scripts in your `manifest.json`:

1. **Define Multiple Content Scripts in `manifest.json`**:
Instead of specifying a single content script, you can provide an array of content script objects.

```json
{
"manifest_version": 3,
...
"content_scripts": [
{
"matches": ["<all_urls>"],
"js": ["content1.js"]
},
{
"matches": ["<all_urls>"],
"js": ["content2.js"]
}
],
...
}
```

In the example above, two content scripts (`content1.js` and `content2.js`) are defined to run on all URLs.

2. **Different Scripts for Different Match Patterns**:
You can also specify different content scripts for different match patterns. For instance, if you want `content1.js` to run on one website and `content2.js` to run on another:

```json
{
...
"content_scripts": [
{
"matches": ["https://example1.com/*"],
"js": ["content1.js"]
},
{
"matches": ["https://example2.com/*"],
"js": ["content2.js"]
}
],
...
}
```

3. **Multiple JS Files for a Single Match Pattern**:
If you want multiple JS files to run for a single match pattern, you can list them in the "js" array:

```json
{
...
"content_scripts": [
{
"matches": ["<all_urls>"],
"js": ["content1.js", "content2.js"]
}
],
...
}
```

In this case, `content1.js` will be executed before `content2.js` for the specified match pattern.

Remember to ensure that all your content script files are included in the `manifest.json` and are located in the specified paths in your extension's directory.