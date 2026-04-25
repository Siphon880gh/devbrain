Make certain URLs cache only until detect last modified changed

## What it looks like

**First run**, status code is 200 (note you need to have Network tab opened as page loads to properly log files as they load in):
![[cache-all-200-fresh.png]]

**Subsequent revisits** or **refresh** - status 304:
Status 304 (Not Modified) is an HTTP redirection response code indicating that a requested resource has not changed since it was last accessed, allowing the client to use a cached version from their web browser.

In other words: Status 304 means the browser asked the server for the resource, and then the server said “I've re-validated, and the resource hasn't changed. No need to transfer it again." The browser gets the message and loads its local cache, improving performance for the user.

![[cache-all-304-local.png]]

**Test further:**
With the Network panel opened, if you hit CMD+SHIFT+R instead of CMD+R, it’ll clear the cache and reload, going back to 200 statuses
![[cache-all-200-fresh.png]]
  

## Basics

This only works if the server sends proper headers about these files as they load in! Hence you need to modify apache’s .htaccess OR nginx’ vhost. There is no other special code other than modifying apache/nginx configurations. A big focus is on the **headers** and **matching the URL/filename**, often including matching the **file type** in the URL/filename if you want certain file types cached (which is a common need).

The header that makes this happen is:
```
Cache-Control: no-cache, must-revalidate
```

Below are the configuration syntaxes needed

---

## OPTION A - Apache's .htaccess
Note you can quickly test this in a localhost server like MAMP (If you look to the screenshots above, you'll see that's where I tested from):
Version without gzip/brotli:
```
# Browser cache policy for generated cache outputs.
#
# Target files (at repo root):
#   cachedResData.json
#   cachedResDataImaged.json
#   cachedResPartial.html
#
# Strategy: conditional-GET revalidation.
# Apache auto-emits Last-Modified + ETag for static files. "no-cache" here
# means the browser MAY store the response but MUST revalidate with the server
# on each request. When the file's mtime is unchanged, Apache answers 304 and
# the browser serves its cached copy. When the file has been rebuilt (e.g. by
# `npm run build-devbrain`), its mtime changes and the browser gets the fresh
# body. This gives us "use the browser's copy unless the last-modified differs".
<IfModule mod_headers.c>
    <FilesMatch "^cached.*\.(json|html)$">
        Header set Cache-Control "no-cache, must-revalidate"
        Header unset Pragma
        Header unset Expires
    </FilesMatch>
</IfModule>

# Make ETag strong by basing it on mtime + size (no inode, so it survives
# filesystem moves / replicas).
FileETag MTime Size
```

Version with gzip/brotli:
```
# Browser cache + pre-compressed delivery for generated cache outputs.
#
# Target files (at repo root):
#   cachedResData.json
#   cachedResDataImaged.json
#   cachedResPartial.html
# plus their .br / .gz pre-compressed siblings (built by cache_compress.js).
#
# === Caching strategy: conditional-GET revalidation ===
# Apache auto-emits Last-Modified + ETag for static files. "no-cache" here
# means the browser MAY store the response but MUST revalidate with the server
# on each request. When the file's mtime is unchanged, Apache answers 304 and
# the browser serves its cached copy. When the file has been rebuilt (e.g. by
# `npm run build-devbrain`), its mtime changes and the browser gets the fresh
# body. cache_compress.js forces .br/.gz mtimes to match the source so the
# 304 logic behaves identically across encodings.
#
# === Compression strategy: pre-compressed static ===
# Instead of compressing on every request, the build step writes brotli (q=11)
# and gzip (level 9) variants once, and Apache serves the smallest variant the
# client accepts. Brotli q=11 saves another 15-25% over what an on-the-fly
# server module produces, and costs zero CPU per request. Cloudflare passes
# Content-Encoding: br through unchanged.
#
# Variant selection priority: br > gz > raw.

<IfModule mod_rewrite.c>
    RewriteEngine On

    # Serve pre-compressed brotli when the client supports it AND the .br
    # exists on disk AND has non-zero size. -s avoids the empty-file race if
    # the build was interrupted mid-write.
    RewriteCond %{HTTP:Accept-Encoding} br
    RewriteCond %{REQUEST_FILENAME}.br -s
    RewriteRule ^(cached.*\.(json|html))$ $1.br [QSA,L]

    # Otherwise pre-compressed gzip.
    RewriteCond %{HTTP:Accept-Encoding} gzip
    RewriteCond %{REQUEST_FILENAME}.gz -s
    RewriteRule ^(cached.*\.(json|html))$ $1.gz [QSA,L]
</IfModule>

<IfModule mod_headers.c>
    # Cache-Control + Vary apply to every variant (raw, .br, .gz). Vary tells
    # any shared cache (Cloudflare, browser, intermediate proxy) that the
    # response body depends on Accept-Encoding, so variants don't get crossed.
    <FilesMatch "^cached.*\.(json|html)(\.(br|gz))?$">
        Header set Cache-Control "no-cache, must-revalidate"
        Header unset Pragma
        Header unset Expires
        Header append Vary Accept-Encoding
    </FilesMatch>

    # When the rewrite lands on a .br variant: tell the browser this is brotli
    # and force the original Content-Type (Apache's default mime guess for
    # ".br" would be wrong / a download).
    <FilesMatch "^cached.*\.json\.br$">
        Header set Content-Encoding br
        Header set Content-Type application/json
    </FilesMatch>
    <FilesMatch "^cached.*\.html\.br$">
        Header set Content-Encoding br
        Header set Content-Type text/html
    </FilesMatch>

    # Same for the .gz variants.
    <FilesMatch "^cached.*\.json\.gz$">
        Header set Content-Encoding gzip
        Header set Content-Type application/json
    </FilesMatch>
    <FilesMatch "^cached.*\.html\.gz$">
        Header set Content-Encoding gzip
        Header set Content-Type text/html
    </FilesMatch>
</IfModule>

# Make ETag strong by basing it on mtime + size (no inode, so it survives
# filesystem moves / replicas).
FileETag MTime Size
```


---

## OPTION B - Nginx's vhost

Version without gzip/brotli:
```nginx
server {
    listen 443 ssl http2;
    server_name your.host;
    root /var/www/your.host/app/devbrain;
    index index.php index.html;

    # ... your existing PHP handler, SSL config, etc ...

    # Conditional-GET revalidation for generated cache outputs.
    # Nginx auto-emits Last-Modified; enabling etag on (default in 1.3.3+) pairs well.
    # "no-cache" tells the browser to store but always revalidate.
  location ~* ^/(cached.*\.(json|html))$ {
	root /home/wengindustries/htdocs/wengindustries.com/app/devbrain;

	try_files /$1 =404;

	add_header Cache-Control "no-cache, must-revalidate" always;
	add_header Vary "Accept-Encoding" always;

	etag on;
	if_modified_since exact;
	expires off;
  }
}
```

Version with gzip/brotli:
```
server {
    listen 443 ssl http2;
    server_name your.host;
    root /var/www/your.host/app/devbrain;
    index index.php index.html;

    # ... your existing PHP handler, SSL config, etc ...

    # Conditional-GET revalidation for generated cache outputs.
    # Nginx auto-emits Last-Modified; enabling etag on (default in 1.3.3+) pairs well.
    # "no-cache" tells the browser to store but always revalidate.
  location ~* ^/(cached.*\.(json|html))$ {
	root /home/wengindustries/htdocs/wengindustries.com/app/devbrain;

	try_files /$1 =404;

	add_header Cache-Control "no-cache, must-revalidate" always;
	add_header Vary "Accept-Encoding" always;

	etag on;
	if_modified_since exact;
	expires off;  

	gzip_static on;
	brotli_static on;
  }
}
```

---

## Further configuration with Cloudflare

Cloudflare proxied?

If going behind Cloudflare, you will have some problems because Cloudflare acts as the user browser because it’s an intermediate hop, therefore requests will always be 200 instead of 304, however default Cloudflare cache settings usually mean if before TTL expires, it pulls from browser cache. Will appear as 200 local cache instead of 200 (more on this later)

What you want to do is to tell cloudflare cache to let origin handle caching

Lets see how the problem looks

Normally we want 304 and 200 local cache:

Notice the 200 cache here appears as “disk cache”. Inside network details of that request would appear as “local cache” - same thing
![[cache-304-and-200-local.png]]

![[cache-200-local-details.png]]

That 200 local cache is because you've visited this webpage before and the TTL hasn't been reached.
 
 Now let's considered you never visited:
 ![[cache-all-200-fresh-dark.png]]

These are all 200 fresh requests

For example when you go into detail of any 200 fresh requests, there's no "local cache":
![[cache-200-fresh-details.png]]
  

During troubleshooting, you can mess up because you might forget to check the type of 200 statuses and assumed it's a normal 200 status that retrieved data.

With Cloudflare default caching, it will always be either 200 fresh or 200 local cache. It's best practice to get 304 - file not modified so retrieve local cache. It’s more descriptive about what’s happening with cache control than just say, 200 local cache - we retrieve local cache. Also, when Cloudflare sits between the web host and the user, your web host may be more likely to send the full file again even when the file has not changed. This can happen because the origin server may not recognize the request as coming from the same visitor, since Cloudflare can route requests through different edge IPs within the same region.

You're telling Cloudflare:
- "Don't serve this from your cache. Pass the request through."
- Bypass cache which will defer to origin (your webhost)
- And bypass for browser TTL, so 200 local cache doesn’t supercede the 304 not-modified-so-we-pull-from-local-cache (more semantic)
![[cache-cloudflare-bypass-so-origin-takes-over.png]]

After setting up, you can see 304’s. And if you go into its header details, you’ll see Cloudflare saying it’s bypassed to origin, in its own language:

HTTP/2 304  
cf-cache-status: DYNAMIC

![[cache-cloudflare-dynamic-means-origin-handles.png]]

  
DYNAMIC is okay here. It means Cloudflare bypassed cache and forwarded to your origin

This increases the chance of the descriptive and performant 304:
![[cache-304-and-200-local.png]]

There is still a 200 local cache aka disk cache but at least 304's are showing through
![[cache-200-local-details.png]]

This also ok because it’s instant from local cache (200 local) though it doesn’t report the strategy that it's not been modified so we pull from local cache (304).