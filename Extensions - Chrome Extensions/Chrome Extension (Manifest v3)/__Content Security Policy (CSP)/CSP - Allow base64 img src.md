This CSP in manifest.json allows for base64 data. Notice `data:`

```
"content_security_policy": {
"extension_pages": "default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:; object-src 'self';"
},
```