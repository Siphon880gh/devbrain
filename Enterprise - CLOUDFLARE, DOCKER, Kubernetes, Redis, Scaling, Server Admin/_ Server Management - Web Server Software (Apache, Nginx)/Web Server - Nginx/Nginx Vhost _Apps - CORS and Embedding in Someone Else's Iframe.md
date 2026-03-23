
You want to enable CORS so that other websites can fetch your API endpoints
And/or you want to enable letting other people embed your webpage into their iframe

Here's the code to add to your server block that listens for 80 and 443. Add it after root pathing:
- Adjust per your need. This block offers CORS but also allows embedding into iframe. You may only need CORS.
```
location ^~ /abc/appName/results/ {
    # Handle preflight OPTIONS requests
    if ($request_method = OPTIONS) {
        add_header 'Access-Control-Allow-Origin' '*' always;
        add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS' always;
        add_header 'Access-Control-Allow-Headers' 'Content-Type, Authorization' always;
        add_header 'Access-Control-Max-Age' 86400 always;

        # Allow embedding in iframe
        add_header 'X-Frame-Options' 'ALLOWALL' always;
        add_header 'Content-Security-Policy' "frame-ancestors *" always;

        return 204;
    }

    # Normal requests
    add_header 'Access-Control-Allow-Origin' '*' always;
    add_header 'X-Frame-Options' 'ALLOWALL' always;
    add_header 'Content-Security-Policy' "frame-ancestors *" always;

    try_files $uri $uri/ =404;
}
```