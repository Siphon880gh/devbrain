
You can use both https and http. This is how

"content_security_policy": {

"extension_pages": "default-src 'self' [https://cdnjs.cloudflare.com](https://cdnjs.cloudflare.com) [http://cdnjs.cloudflare.com;](http://cdnjs.cloudflare.com;) script-src 'self'; object-src 'self'; style-src 'self' 'unsafe-inline' [https://cdnjs.cloudflare.com](https://cdnjs.cloudflare.com) [http://cdnjs.cloudflare.com;](http://cdnjs.cloudflare.com;) img-src 'self' *; connect-src 'self' [https://wengindustry.com](https://wengindustry.com) [http://wengindustry.com](http://wengindustry.com)"

},