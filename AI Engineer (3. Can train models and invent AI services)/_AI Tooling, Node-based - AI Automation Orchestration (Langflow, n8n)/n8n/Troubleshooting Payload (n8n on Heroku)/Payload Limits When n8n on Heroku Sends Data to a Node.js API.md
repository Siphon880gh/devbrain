
When an **n8n HTTP Request node** sends data to a remote API and you see:

```text
413 Payload Too Large
```

the most likely cause is usually the **target API rejecting the request**, not Heroku.

The request path looks like this:

```text
n8n on Heroku
   ↓
HTTP Request node sends outbound request
   ↓
Target API, for example Node.js / Express
```

Heroku is hosting n8n, but for an outbound HTTP request, Heroku usually is not the layer returning `413`.

The remote API, or a proxy in front of that API, is usually the layer saying:

```text
This request body is too large.
```

---

## The Simple Rule

Use this mental model:

```text
If the payload is going OUT of n8n:
Check the target API first.

If the payload is coming INTO n8n:
Check Heroku, n8n, and any proxy in front of n8n.
```

So in your case:

```text
n8n hosted on Heroku
   ↓
HTTP Request node
   ↓
Node.js API endpoint
```

Start by checking the **Node.js API’s body-size limit**.

---

## Heroku Outbound Does Not Mean Unlimited

Heroku usually does not have a simple outbound rule like:

```text
Outbound HTTP request bodies are capped at 10 MB.
```

But that does **not** mean you can send unlimited data.

Large outbound payloads can still fail because of:

```text
- the target API’s request body limit
- Express / Fastify / Next.js body parser limits
- Nginx, Cloudflare, or API gateway limits
- n8n’s own payload handling
- Heroku dyno memory limits
- request timeouts
- slow network transfer
```

Heroku also has dyno memory limits and a soft network bandwidth limit, so very large payloads can still become a runtime problem even when Heroku is not directly returning the `413`. ([Heroku Dev Center](https://devcenter.heroku.com/articles/limits "Limits | Heroku Dev Center"))

Better wording:

```text
Heroku is usually not the 413 layer for outbound n8n HTTP Request nodes,
but the dyno still has memory, runtime, and network constraints.
```

---

## Heroku Inbound Is Different

Heroku is more likely involved when the request is coming **into** your Heroku-hosted n8n app.

Example:

```text
External service
   ↓
Heroku router
   ↓
n8n webhook
```

This matters for n8n webhooks, file uploads, form submissions, and API calls sent directly to your Heroku app.

For inbound requests, Heroku does consider request size. The limits are relatively generous for normal webhook payloads, but they are still limits:

```text
Request headers: 16 KB
Request body: 10 MB
```

So if someone is sending a large webhook payload **into** n8n on Heroku, Heroku may reject or interrupt the request before n8n fully handles it.

Also, Heroku has request timeout behavior. HTTP requests have an initial 30-second window for the web process to return response data, and after that, activity-based rolling windows apply. ([Heroku Dev Center](https://devcenter.heroku.com/articles/limits "Limits | Heroku Dev Center"))

So for inbound traffic, the issue may be:

```text
- Heroku request-size limits
- Heroku router timeout
- n8n payload limits
- n8n webhook/form-data limits
- dyno memory
- a proxy/CDN in front of Heroku
```

Important distinction:

```text
Outbound from n8n to a remote API:
Heroku usually is not the 413 layer.

Inbound into Heroku-hosted n8n:
Heroku can be part of the payload-size and timeout story.
```

---

## Where the Limit Might Be

|Layer|When it matters|What to check|
|---|---|---|
|**Target Node.js API**|n8n sends a large JSON body or file to the API|Express/Fastify/Next.js body parser settings|
|**Proxy before the API**|API is behind Nginx, Cloudflare, API Gateway, etc.|`client_max_body_size`, upload limits, API gateway limits|
|**n8n itself**|n8n receives, stores, or passes large payloads between nodes|`N8N_PAYLOAD_SIZE_MAX`|
|**Heroku inbound**|A webhook or upload is sent into n8n on Heroku|Header/body size limits, router timeout, logs|
|**Heroku dyno**|n8n builds or holds a huge payload in memory|Memory errors, crashes, restarts|
|**Target API hosting platform**|Node.js API runs on Vercel, Heroku, Render, Railway, etc.|Platform-specific request limits|

The exact payload limit depends on the backend technology. A Node.js API has different defaults than PHP, Python Flask, FastAPI, Laravel, Rails, Go, or Java Spring.

---

# If the Target API Is Node.js, How Do You Find the Payload Limit?

Node.js itself usually is not where the friendly payload limit is configured. The limit is usually enforced by the framework, middleware, body parser, reverse proxy, or hosting platform.

So first identify the Node.js stack.

---

## 1. If It Is Express

Look for code like this:

```js
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
```

or:

```js
const bodyParser = require('body-parser');

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
```

Express/body-parser commonly defaults to a small body limit, often around `100kb`, unless you override it.

Increase it like this:

```js
app.use(express.json({ limit: '10mb' }));
app.use(express.urlencoded({ limit: '10mb', extended: true }));
```

Better: set the larger limit only on the route that needs it:

```js
app.post(
  '/api/big-upload',
  express.json({ limit: '25mb' }),
  async (req, res) => {
    res.json({ ok: true });
  }
);
```

Do **not** blindly set huge limits globally unless every route truly needs it.

---

## 2. If It Is Fastify

Look for:

```js
const fastify = require('fastify')();
```

Fastify uses a `bodyLimit` setting.

Example:

```js
const fastify = require('fastify')({
  bodyLimit: 10 * 1024 * 1024 // 10 MiB
});
```

Or per route:

```js
fastify.post('/api/big-upload', {
  bodyLimit: 25 * 1024 * 1024
}, async (request, reply) => {
  return { ok: true };
});
```

---

## 3. If It Is Next.js API Routes

Look under:

```text
pages/api/
```

For Pages Router API routes, you can configure:

```js
export const config = {
  api: {
    bodyParser: {
      sizeLimit: '10mb',
    },
  },
};

export default function handler(req, res) {
  res.status(200).json({ ok: true });
}
```

For raw webhooks or streaming uploads, you may see:

```js
export const config = {
  api: {
    bodyParser: false,
  },
};
```

That means the route is handling the body manually.

---

## 4. If the Node.js API Is Behind Nginx

Even if the Node.js code allows large payloads, Nginx may reject the request first.

Look for:

```nginx
client_max_body_size 10M;
```

Example:

```nginx
server {
    server_name api.example.com;

    client_max_body_size 25M;

    location / {
        proxy_pass http://127.0.0.1:3000;
    }
}
```

If Nginx is the layer rejecting the request, the Node.js app may never see it.

---

## 5. If the API Is Behind Cloudflare or an API Gateway

The target API may also be behind:

```text
- Cloudflare
- AWS API Gateway
- Google Cloud API Gateway
- Azure API Management
- a load balancer
- another reverse proxy
```

In that case, the proxy or gateway may return `413` before Node.js receives the request.

Check:

```text
Node.js app logs
Proxy / gateway logs
Hosting platform logs
```

If the Node.js logs show nothing, the request may be blocked before it reaches the app.

---

# How to Prove Which Layer Is Rejecting It

## Step 1: Check the n8n Error

If n8n says:

```text
Request failed with status code 413
```

that usually means the **remote server responded with 413**.

That points to:

```text
target API
or
proxy in front of target API
```

---

## Step 2: Test the Same Payload With curl

From your local machine:

```bash
curl -X POST https://api.example.com/endpoint \
  -H "Content-Type: application/json" \
  --data-binary @payload.json
```

If this also returns:

```text
413 Payload Too Large
```

then the issue is not n8n-specific.

---

## Step 3: Test From the Heroku Dyno

Run:

```bash
heroku run bash
```

Then from inside the Heroku dyno:

```bash
curl -X POST https://api.example.com/endpoint \
  -H "Content-Type: application/json" \
  --data-binary @payload.json
```

If it fails from Heroku and your local machine, the target API or its proxy is the limit.

If it only fails from Heroku, investigate dyno memory, timeout behavior, networking, or how n8n is constructing the request.

---

## Step 4: Check Heroku Logs

Run:

```bash
heroku logs --tail
```

Then trigger the workflow again.

Look for:

```text
H12 Request timeout
R14 Memory quota exceeded
R15 Memory quota vastly exceeded
State changed from up to crashed
Process exited
```

If the problem is an inbound request into n8n, Heroku logs are especially important.

---

## Step 5: Check n8n’s Own Payload Limit

n8n has:

```text
N8N_PAYLOAD_SIZE_MAX
```

On Heroku:

```bash
heroku config:get N8N_PAYLOAD_SIZE_MAX
```

To increase it:

```bash
heroku config:set N8N_PAYLOAD_SIZE_MAX=64
heroku restart
```

But this only helps if **n8n** is the bottleneck.

It will not fix a target API returning:

```text
413 Payload Too Large
```

---

# Best Fixes

The best fix is usually not to keep increasing limits.

Better options:

```text
- Split the payload into smaller batches.
- Send only the fields the API needs.
- Avoid huge JSON blobs.
- Upload large files to S3, R2, or Google Cloud Storage first.
- Send the file URL to the API instead of sending the whole file through n8n.
- Use multipart upload if the API supports it.
- Increase the Node.js route limit only for the route that needs it.
- Increase n8n’s payload limit only if n8n is the layer rejecting it.
```

A better large-file pattern is:

```text
Source system
   ↓
Upload file to S3 / R2 / GCS
   ↓
n8n receives file URL and metadata
   ↓
n8n sends small JSON payload to Node.js API
   ↓
Node.js API downloads or processes the file separately
```

This avoids using n8n and Heroku as a giant pass-through pipe.

---

# Bottom Line

For this setup:

```text
n8n hosted on Heroku
   ↓
HTTP Request node
   ↓
Node.js API endpoint
```

a `413 Payload Too Large` error is most likely coming from:

```text
the Node.js API,
its framework body parser,
or a proxy/API gateway in front of it.
```

For a Node.js target API, check the actual backend stack:

```text
Express     → express.json({ limit: '10mb' })
Fastify     → bodyLimit
Next.js API → bodyParser.sizeLimit
Nginx       → client_max_body_size
Cloud/API gateway → platform upload/request limits
```

Heroku is usually not the outbound `413` layer.

But for inbound traffic into your Heroku-hosted n8n app, Heroku can matter because it has request header/body limits, router timeout behavior, dyno memory limits, and runtime constraints.