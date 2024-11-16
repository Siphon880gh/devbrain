
[Varnish Cache](http://varnish-cache.org/) is a caching HTTP reverse proxy that speeds up your sites by storing the compressed **Page Source** in memory.  
Static files like **CSS, JS,** and **Images** are **NOT** being stored in **Varnish Cache** because **NGINX** delivers them faster.

When you open your site, e.g., **[https://www.domain.com](https://www.domain.com/)**, the request goes to **NGINX**, where **SSL/TLS** gets terminated.  
If the request is a static file like a **Stylesheet**, **Javascript**, or an **Image**, it gets delivered immediately by **NGINX**.  
All other requests are forwarded to **Varnish Cache** (Port **6081**).

If **Varnish Cache** has a cache entry for a request, the page source gets immediately returned from memory without being processed by **PHP-FPM**.

If no cache entry exists, the request gets forwarded by **Varnish Cache** to **NGINX** port **8080**, where it gets processed by the **PHP Application** via **PHP-FPM**.

From: https://www.cloudpanel.io/docs/v2/frontend-area/varnish-cache/developer-guide/vhost/