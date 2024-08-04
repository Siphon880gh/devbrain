
In CloudPanel sites, your vhost often has a server block for 8080 port. Here's why:

If **Varnish Cache** has a cache entry for a request, the page source gets immediately returned from memory without being processed by **PHP-FPM**.

If no cache entry exists, the request gets forwarded by **Varnish Cache** to **NGINX** port **8080**, where it gets processed by the **PHP Application** via **PHP-FPM**.