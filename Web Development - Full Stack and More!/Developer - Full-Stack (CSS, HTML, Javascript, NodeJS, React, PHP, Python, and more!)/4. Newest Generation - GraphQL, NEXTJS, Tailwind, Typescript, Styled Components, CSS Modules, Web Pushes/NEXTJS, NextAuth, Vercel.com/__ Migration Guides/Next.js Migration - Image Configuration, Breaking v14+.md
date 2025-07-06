
### 🔍 Version Timeline

| Next.js Version | Configuration at `next.config.js`                                                                                                                                                                                                                                                                                                                                                                       | Notes                                   |
| --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------- |
| **≤ 12.2.x**    | `images.domains = [...]`                                                                                                                                                                                                                                                                                                                                                                                | Standard for allowing external domains. |
| **12.3.0**      | _Deprecated_ `domains`, introduced `remotePatterns` behind flag; began stability ([nextjs.org](https://nextjs.org/docs/14/pages/api-reference/components/image?utm_source=chatgpt.com "Components: <Image> \| Next.js"), [dev.to](https://dev.to/joodi/the-imagesdomains-configuration-is-deprecated-34fl?utm_source=chatgpt.com "The \"images.domains\" Configuration is Deprecated - DEV Community")) | Partial support.                        |
| **v14.0.0**     | Official _deprecation_ of `domains` — `onLoadingComplete` also removed                                                                                                                                                                                                                                                                                                                                  | `remotePatterns` becomes the standard.  |
| **v15.3.0**     | `remotePatterns` supports `new URL(...)` syntax                                                                                                                                                                                                                                                                                                                                                         | Simplified config option for patterns.  |

---

### 🛠 Migration Steps

#### 1. **Before (Next.js ≤ 12.2.0)**

```js
// next.config.js
module.exports = {
  images: {
    domains: ['placehold.co'],
  },
};
```

#### 2. **Partial Support (Next.js 12.3.0)**

You should **start** using:

```js
module.exports = {
  images: {
    remotePatterns: [
      { protocol: 'https', hostname: 'placehold.co', pathname: '/**' },
    ],
  },
};
```

However, `domains` may still work during this transitional phase ([en.wikipedia.org](https://en.wikipedia.org/wiki/Next.js?utm_source=chatgpt.com "Next.js"), [dev.to](https://dev.to/joodi/the-imagesdomains-configuration-is-deprecated-34fl?utm_source=chatgpt.com "The \"images.domains\" Configuration is Deprecated - DEV Community")).

#### 3. **Fully Deprecated (Next.js 14+)**

Remove `domains` entirely. The final form:

```js
// next.config.js
module.exports = {
  images: {
    remotePatterns: [
      {
        protocol: 'https',
        hostname: 'placehold.co',
        pathname: '/**',
      },
    ],
  },
};
```

#### 4. **Modern Format (Next.js ≥ 15.3.0)**

You can equivalently write:

```js
// next.config.js
images: {
  remotePatterns: [
    new URL('https://placehold.co/**'),
  ],
}
```

This uses cleaner `URL` syntax ([nextjs.org](https://nextjs.org/docs/pages/api-reference/components/image-legacy?utm_source=chatgpt.com "Components: Image (Legacy) - Next.js"), [nextjs.org](https://nextjs.org/docs/pages/api-reference/components/image?utm_source=chatgpt.com "Components: Image | Next.js"), [nextjs.org](https://nextjs.org/docs/14/pages/api-reference/components/image?utm_source=chatgpt.com "Components: <Image> | Next.js")).

---

### ✅ Full Migration Example

```js
// next.config.js
/** @type {import('next').NextConfig} */
const nextConfig = {
  images: {
    remotePatterns: [
      {
        protocol: 'https',
        hostname: 'placehold.co',
        pathname: '/**',
      },
    ],
  },
};

module.exports = nextConfig;
```

**Optional modern syntax (15.3+):**

```js
images: {
  remotePatterns: [ new URL('https://placehold.co/**') ],
}
```

---

### 📌 Summary

- **Pre‑12.3**: Only `images.domains`.
    
- **12.3–13.x**: `domains` deprecated; `remotePatterns` available (behind flag/stable).
    
- **14.0.0**: `domains` officially removed; `remotePatterns` required ([medium.com](https://medium.com/%40andipyk/handling-external-images-in-next-js-remotepatterns-vs-domains-versions-15-3-vs-12-3-06e9c0fe6409?utm_source=chatgpt.com "Handling External Images in Next.js: remotePatterns vs. domains ..."), [nextjs.org](https://nextjs.org/docs/14/pages/api-reference/components/image?utm_source=chatgpt.com "Components: <Image> | Next.js")).
    
- **15.3.0 onwards**: Improved `URL(...)` syntax for `remotePatterns` .
    

---

### 💡 Why Switch?

- **Security**: Fine-grained rules on protocol, hostname, path.
- **Flexibility**: Supports glob patterns like `/images/**`, subdomains.
- **Future‑proof**: Aligns with Next.js evolving best practices.
