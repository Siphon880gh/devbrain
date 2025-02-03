If you have js programmatically refresh the page, but it's displaying a cached copy when you expect it to 100% reset (eg. logging out a user and the menu is supposed to look different), it might just be you using window.location.reload wrong. See this:

`window.location.reload()`
- **true**: Forces a reload from the server (bypassing the browser cache).
- **false** (or omitted): Reloads the page using the browser's cache.

This reloads the page fresh:
```
window.location.reload(true);
```
