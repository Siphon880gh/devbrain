
Your extension pages (panel.html, sidebar.html, popup.html) need to load css and/or js files from an external source? Like cdn? You have to enable thru the CSP at manifest.json

```
"content_security_policy": {

"extension_pages": "default-src 'self' https://cdnjs.cloudflare.com http://cdnjs.cloudflare.com; script-src 'self'; object-src 'self'; style-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com http://cdnjs.cloudflare.com; img-src 'self' *; connect-src 'self' https://wengindustry.com http://wengindustry.com"

},
```