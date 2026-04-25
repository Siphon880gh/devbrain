Say your origin apache or nginx has their own caching rules especially sending headers for E-Tags with no-cache, must-revalidate - that allows 200 fresh and 304 not modified pull from local cache.

Cloudflare would have blocked all that from appearing on your web browser because although it's worth doing because the hop from origin to cloudflare is shorter, cloudflare performs their own caching on top of it (zstd and browser cache TLL 4 hours) which defeats the purpose of your cache setup at your server.

Then bypass to the origin to take over cache.

---

Example Reason to Want Origin to Take Control of Cloudflare Caching

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