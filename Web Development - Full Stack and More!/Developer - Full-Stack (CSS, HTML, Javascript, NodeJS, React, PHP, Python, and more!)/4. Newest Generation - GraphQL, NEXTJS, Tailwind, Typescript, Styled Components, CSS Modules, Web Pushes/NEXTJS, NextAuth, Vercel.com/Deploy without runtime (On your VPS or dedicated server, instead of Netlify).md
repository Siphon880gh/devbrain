## Next.js 15.3.4 Static Export Deployment Guide

This guide covers how to deploy a Next.js 15.3.4 application as a static export to VPS/dedicated servers without requiring a Node.js runtime or a platform like Netlify. This means nothing actively running at a port.

Note that older versions of NextJS has completely different way to export and deploy statically. If using an AI IDE like Cursor IDE to perform this for you, you do risk it confusing the methods. You can paste this guide into Cursor IDE to properly redirect it.

## Next.js Configuration

### 1. Configure `next.config.ts`

```typescript

import type { NextConfig } from "next";

const nextConfig: NextConfig = {
	basePath: '/me', // Base path for your app
	assetPrefix: '/me', // Prefix for static assets
	trailingSlash: true, // Ensures all routes end with /
	output: 'export', // Enable static export
	images: {
		unoptimized: true // Required for static export
	}
};

export default nextConfig;
```


### 2. Understanding the Configuration


**`trailingSlash: true`**
- Ensures all routes end with a trailing slash (e.g., `/about/` instead of `/about`)
- Critical for static hosting because it ensures consistent URL structure
- Prevents 404 errors when accessing routes directly on static servers
- Makes the app behave consistently whether accessed via `/about` or `/about/`

**`output: 'export'`**
- Enables static export mode
- **Automatically saves to `out/` folder** by default
- Generates static HTML, CSS, and JS files
- No server-side rendering at runtime


**`basePath` and `assetPrefix`**
- `basePath`: Sets the base path for your application (e.g., `/me`)
- `assetPrefix`: Ensures static assets are loaded from the correct path

## Build Process

### 1. Build the Application

```bash
npm run build
```

This will:
- Create an optimized production build
- Generate static files in the `out/` directory
- Include all pages as static HTML files
- Bundle and optimize assets

### 2. Verify the Output

The `out/` folder structure will look like:

```

out/
├── _next/
│ ├── static/
│ └── ...
├── index.html
├── about/
│ └── index.html
├── portfolio/
│ └── index.html
└── ...
```

  
## Deployment Process

### 1. Upload to Server

Using FTP/SFTP, copy the entire `out/` folder to your server:

```
Server path: /home/wff/htdocs/wengindustries.com/me/out/
```


Your directory structure on the server should be:
```
wengindustries.com/
└── me/
└── out/
├── _next/
├── index.html
├── about/
└── ...
```


### 2. Configure Web Server
## Nginx Configuration

Add this configuration to your Nginx server block:
```nginx

# Handle exact /me - redirect to /me/
location = /me {
	return 301 /me/;
}

# Handle Next.js static assets with long cache
location /me/_next/ {
	alias /home/wengindustries/htdocs/wengindustries.com/me/out/_next/;
	expires 1y;
	add_header Cache-Control "public, immutable";
	access_log off;
}


# Serve all /me/ requests from static export

location /me/ {
	alias /home/wengindustries/htdocs/wengindustries.com/me/out/;
	index index.html;
	
	# For static assets (js, css, images, etc.), try exact file first, return 404 if not found
	location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot|webp|avif|mp4|webm|ogg|mp3|wav|flac|aac)$ {
		expires 1y;
		add_header Cache-Control "public, immutable";
		access_log off;
		try_files $uri =404;
	}
	
	# For everything else (HTML pages and routes), use Next.js fallback logic
	try_files $uri $uri/index.html /index.html;
	
	# Set proper headers for HTML files
	location ~* \.html$ {
		expires -1;
		add_header Cache-Control "public, must-revalidate, proxy-revalidate";
	}
}

```


## Apache Configuration (Alternative)

If using Apache, add this to your `.htaccess` file in the `/me/` directory:

```apache

RewriteEngine On

# Handle trailing slashes
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^([^/]+)$ $1/ [R=301,L]

# Serve static files directly
RewriteCond %{REQUEST_FILENAME} -f
RewriteRule ^ - [L]

# Handle Next.js routes
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ out/$1 [L]

# Fallback to index.html for client-side routing
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ out/index.html [L]

# Cache static assets
<FilesMatch "\.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot|webp|avif)$">
	ExpiresActive On
	ExpiresDefault "access plus 1 year"
	Header set Cache-Control "public, immutable"
</FilesMatch>

```

  

## URL Mapping

  
With this configuration:

- `wengindustries.com/me/` → serves `out/index.html`
- `wengindustries.com/me/portfolio/` → serves `out/portfolio/index.html`
- `wengindustries.com/me/about/` → serves `out/about/index.html`
- Static assets are served with proper caching headers
## Benefits of Static Export

1. **No Runtime Dependencies**: No Node.js server required
2. **Better Performance**: Pre-rendered HTML loads instantly
3. **Improved SEO**: All content is available at request time
4. **Easier Hosting**: Works with any HTTP server
5. **Better Caching**: Static files can be cached aggressively
6. **Cost Effective**: Lower server resource requirements
## Deployment Checklist
- [ ] Configure `next.config.ts` with proper paths
- [ ] Run `npm run build` to generate static files
- [ ] Verify `out/` folder contains all expected files
- [ ] Upload `out/` folder to server via FTP/SFTP
- [ ] Configure Nginx/Apache to serve files correctly
- [ ] Test all routes work properly
- [ ] Verify static assets load with proper caching headers
- [ ] Test trailing slash redirects work correctly

## Troubleshooting

**404 Errors on Direct Route Access**
- Ensure `trailingSlash: true` is set
- Verify Nginx/Apache fallback rules are correct

**Assets Not Loading**
- Check `assetPrefix` matches your deployment path
- Verify file permissions on server

**Routing Issues**
- Ensure `basePath` is configured correctly
- Test that `try_files` directive works properly

This configuration ensures your Next.js static export works seamlessly on any HTTP server without requiring a Node.js runtime.