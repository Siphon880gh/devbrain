Titled: Self-Hosting Open Source Docker Apps - Reverse Proxy Gotchas

If you're a developer exploring open source apps and trying to self-host them with Docker, you're likely doing it to save time building tools from scratch. Many of these apps come with prebuilt Docker solutions, making setup relatively painless — until reverse proxying gets involved.

One common challenge arises when you want to expose these Dockerized apps through a reverse proxy like Nginx, especially when using custom paths or subdomains.

---

### 🔁 Reverse Proxying to a Subpath (e.g. `domain.com/some/app`)

Some Docker images work seamlessly when reverse proxied to a subpath like `/some/app`. If that’s the case — perfect! You can set up your reverse proxy and you're done. The app likely handles subpath routing correctly by using relative asset paths or dynamically determining its base URL (e.g., using `window.location`) to build asset and API routes properly.

However, **many Docker images break** in this setup. That’s usually because their static assets and internal routes are hardcoded to the root path (`/`). When accessed under a subpath, the app tries to load resources from the wrong location — leading to broken UIs, 404s, and console errors.

If this happens, you have two main options:

---

### 🛠 Option 1: Reconfigure the App to Use a Custom Base Path

Check whether the app allows configuring a custom "site URL" or base path (e.g., `/some/app`).

- If **yes**:  
	You’ll need to rebuild or override the Docker image with the appropriate configuration — such as setting `BASE_URL=/some/app` or a similar environment variable. This ensures the app generates links and loads assets relative to the correct path.
	
	To find out if this is supported, try Googling the app name with keywords like:
	- Environmental Variables: `BASE_URL`, `PUBLIC_PATH`, `SITE_URL`, `APP_ROOT`, `SERVER_ROOT`
	- JS Variants like `baseURL`, `publicPath`, `siteUrl`, etc.
	- Or Python or PHP variants like `base_url`, `public_path`, `site_url`, etc.
	
	These settings might appear:
	- As environment variables in the Dockerfile
	- Inside a `config.json` file (commonly in the root or a `config/` directory)
	- Embedded in build tools like Webpack or frameworks like Vue, React, etc.
	- Less often - inside the app code
    
- If **no**:  
    The app can’t support subpath hosting without serious modifications — you’ll need to switch to a subdomain approach.
    

---

### 🌐 Option 2: Use a Subdomain Instead (e.g. `app.domain.com`)

When an app insists on serving from `/`, reverse proxying it to a **subdomain** is the cleaner path.

But there’s a checklist of setup steps:

1. **DNS Configuration**  
    Add an `A` or `CNAME` record for `app.domain.com` pointing to your server.
    
2. **TLS/SSL Certificate**  
    For HTTPS to work:
    
    - Ensure the subdomain is publicly reachable.
        
    - Your certificate provider (e.g., Let’s Encrypt) will try to complete an ACME HTTP-01 challenge.
        
    - That means `http://app.domain.com/.well-known/acme-challenge/...` must be accessible before issuing the cert.
        
    - Only after the cert is issued should you finalize the reverse proxy rule for HTTPS traffic.
        
3. **Reverse Proxy Routing**  
    Once TLS is ready, proxy all requests from `app.domain.com` to the app's internal container port. Since the app expects `/`, everything will route cleanly.
    

---

### 🚨 Last Resort: Direct Access via Port Number

If reverse proxying proves too complex or not viable, or the app is only for internal use:

- You can expose the app directly at `http://yourdomain.com:1234`.
    
- This avoids dealing with reverse proxies or TLS setup.
    
- **Use caution**: this is only acceptable for internal tools or testing environments. It leaves the app unauthenticated and unsecured by HTTPS.
    

---

### 🔍 Summary

|Approach|Works With `/some/app`?|HTTPS Ready?|Best Use Case|
|---|---|---|---|
|Reconfigure base path|✅ If configurable|✅|Flexible apps with path settings|
|Use subdomain|✅ Always|✅ With setup|Most Docker apps with hardcoded `/`|
|Direct port access|❌|❌|Local/internal only, not for production|

