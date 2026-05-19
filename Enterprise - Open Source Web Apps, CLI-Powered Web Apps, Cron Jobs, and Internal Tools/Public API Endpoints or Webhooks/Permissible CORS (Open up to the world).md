When creating **Public API Endpoints or Webhooks**:
- A **public API endpoint** is an endpoint that you intentionally allow other IP numbers, domains, or third-party services to connect to.
- A **webhook** is an endpoint that automation tools, SaaS platforms, or external services need to hit so you can track, trigger, or coordinate something on a server you own.

There is a major consideration:
- You may need to add **more permissive CORS rules**, either opening the endpoint to the public, allowing `*`, or only allowing specific whitelisted domains/origins.
    

---

# CORS Approaches for Public API Endpoints and Webhooks

A browser may block a request before the real request is sent if the server does not properly respond to the **CORS preflight request**.

This often happens when a frontend on one domain tries to call an API endpoint on another domain:

```txt
Frontend:
https://domain.com

API endpoint:
https://api-domain.com/api/example/webhook
```

The browser may first send an `OPTIONS` request to check whether the API endpoint allows the request. If the server does not respond correctly, the real `POST` request never happens.

---

# PHP Approach

At the very top of the PHP endpoint, before any output:

```php
<?php

$allowedOrigins = [
    'https://domain.com',
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if (in_array($origin, $allowedOrigins, true)) {
    header("Access-Control-Allow-Origin: $origin");
    header("Vary: Origin");
}

header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Continue with normal POST handling here...
```

Important: the `OPTIONS` request must return successfully. If your backend only accepts `POST`, the browser preflight can fail before the real `POST` happens.

---

# More Permissive PHP Approach Using `*`

For a truly public endpoint where you want to allow requests from any browser origin, you can use:

```php
<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

// Continue with normal POST handling here...
```

This is more open and easier for public APIs, webhooks, and third-party integrations.

However, `*` means any website can make browser-based requests to the endpoint. You should still protect the endpoint with server-side validation, API keys, signatures, rate limits, CAPTCHA, authentication, or request verification depending on the use case.

Also note: `Access-Control-Allow-Origin: *` should not be used with credentialed browser requests such as cookies or `withCredentials: true`.

---

# Express.js Approach

If the API is Node/Express:

```js
import cors from "cors";

app.use(cors({
  origin: "https://domain.com",
  methods: ["POST", "OPTIONS"],
  allowedHeaders: ["Content-Type", "Authorization", "X-Requested-With"],
}));

app.options("/api/example/webhook", cors());

app.post("/api/example/webhook", async (req, res) => {
  // Form or webhook handling here
});
```

---

# More Permissive Express.js Approach Using `*`

For a more public endpoint:

```js
import cors from "cors";

app.use(cors({
  origin: "*",
  methods: ["POST", "OPTIONS"],
  allowedHeaders: ["Content-Type", "Authorization", "X-Requested-With"],
}));

app.options("/api/example/webhook", cors());

app.post("/api/example/webhook", async (req, res) => {
  // Form or webhook handling here
});
```

This allows browser requests from any origin.

For public APIs and webhook-style endpoints, this may be acceptable, but the endpoint should not rely on CORS as the main security layer. CORS controls browser permission. It does not stop direct server-to-server requests, bots, curl requests, or abuse from non-browser clients.

---

# Nginx / CloudPanel Approach

If the request is blocked before it reaches PHP or Node, add CORS handling in the Nginx vhost for that route:

```nginx
location = /api/example/webhook {
    if ($request_method = OPTIONS) {
        add_header Access-Control-Allow-Origin "https://domain.com" always;
        add_header Access-Control-Allow-Methods "POST, OPTIONS" always;
        add_header Access-Control-Allow-Headers "Content-Type, Authorization, X-Requested-With" always;
        add_header Access-Control-Max-Age 86400 always;
        add_header Content-Length 0;
        return 204;
    }

    add_header Access-Control-Allow-Origin "https://domain.com" always;
    add_header Vary "Origin" always;

    # Your normal PHP/proxy handling goes here
}
```

---

# More Permissive Nginx Approach Using `*`

```nginx
location = /api/example/webhook {
    if ($request_method = OPTIONS) {
        add_header Access-Control-Allow-Origin "*" always;
        add_header Access-Control-Allow-Methods "POST, OPTIONS" always;
        add_header Access-Control-Allow-Headers "Content-Type, Authorization, X-Requested-With" always;
        add_header Access-Control-Max-Age 86400 always;
        add_header Content-Length 0;
        return 204;
    }

    add_header Access-Control-Allow-Origin "*" always;

    # Your normal PHP/proxy handling goes here
}
```

But be careful: if CloudPanel already has a PHP location block, an exact `location = ...` block may bypass normal PHP routing unless you proxy/pass it correctly.

Usually, the safer approach is to handle CORS inside the PHP or Node app unless Nginx is the layer rejecting `OPTIONS`.

---

# Simple Rule

Use a **specific origin** when only one known website should call the endpoint:

```txt
Access-Control-Allow-Origin: https://domain.com
```

Use an **allowed origins list** when several trusted websites should call it:

```txt
https://domain.com
https://app.domain.com
https://client-domain.com
```

Use `*` when the endpoint is intentionally public:

```txt
Access-Control-Allow-Origin: *
```

But even with `*`, your real protection should come from server-side checks such as API keys, signed webhook secrets, request validation, rate limiting, authentication, and abuse protection.