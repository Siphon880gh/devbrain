In many open-source apps that are designed for self-hosting, it may have configuration files. A setting may be `baseUrl` or `siteUrl`. It's important to know their differences:

### `siteUrl`

- **Definition**: `siteUrl` typically refers to the full URL used to access your website from the outside world.
    
- **Example**: `https://example.com`
    
- **Purpose**: It tells the application what the canonical domain is, often used in generating links, redirects, and for things like sending absolute URLs in emails.
    
- **Important Consideration**: Always include the full protocol (`http://` or `https://`) and domain. If your app is available at a subdomain, include that too, like `https://app.example.com`.
    

---

### `baseUrl`

- **Definition**: `baseUrl` refers to the subpath at which your app is served, relative to the domain.
    
- **Example**: If your app is hosted at `https://example.com/blog`, then the `baseUrl` is `/blog/`.
    
- **Purpose**: It is often used by frontend frameworks (like Docusaurus, React apps, or static site generators) to prefix static assets and routes.
    
- **Important Consideration**: It usually starts and ends with a slash (`/`) and is especially critical if you're not deploying the app to the root (`/`) of your domain.
    

---

### Summary

|Setting|Example|Used For|Include Protocol?|
|---|---|---|---|
|`siteUrl`|`https://example.com`|Canonical links, SEO, redirects, full URLs|✅ Yes|
|`baseUrl`|`/blog/`|Static assets, routing inside the site|❌ No|

---

### Quick Tip

If you're hosting at the root of your domain (e.g., `https://example.com`), then:

```json
"siteUrl": "https://example.com",
"baseUrl": "/"
```

But if you're deploying to a subdirectory (e.g., `https://example.com/docs`):

```json
"siteUrl": "https://example.com",
"baseUrl": "/docs/"
```

Always check your app’s documentation—some use slightly different names or behavior for these settings.
