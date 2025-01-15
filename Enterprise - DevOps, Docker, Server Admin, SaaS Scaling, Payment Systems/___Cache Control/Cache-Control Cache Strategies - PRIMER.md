## Cache-Control vs Pragma on not storing cache

Note the **`Pragma`** HTTP header does not have a `no-store` directive. The `Pragma` header was introduced in HTTP/1.0 and is mainly used for backward compatibility. It supports only a single directive: `no-cache`. Meanwhile, Cache-Control has `no-store` and `no-cache`. 

- In cache-control, `no-store` is a harder restriction on cache, compared to its `no-cache`, making the distinction that `no-store` is absolutely DO NOT store cache, and `no-cache` is use the cache stored locally for performance but do refetch if there's a newer copy on the server.

- Pragma no-cache and Cache-control no-store are equivalent settings because their strategy is the same.

No caching by PHP:
```
<?php
header("Cache-Control: no-store, must-revalidate");
header("Pragma: no-cache"); // For HTTP/1.0 backward compatibility
header("Expires: 0"); // Forces expiration immediately
?>
```

No caching by Nginx Vhost:
```
server {
    location /no-cache {
        add_header Cache-Control "no-store, must-revalidate";
        add_header Pragma "no-cache"; # For HTTP/1.0 compatibility
        expires off; # Disable expiration
    }
}
```


## Avoid conflicts across Cache-Control and Pragma

Keep Pragma and Cache-Control headers consistent (both the same options)

- You should and if you do include both modern Cache-Control headers and legacy Pragma headers, older browsers might prioritize Pragma

- So make sure Pragma headers match the more modern Cache-control header

- Otherwise could could cause unexpected consequences when an older browser prefers Pragma that have a different caching header. You usually don't want different caching strategy based on how old a browser is

## Avoid conflicts in the header line

- no-cache and must-revalidate can be used together but NEVER with no-store 
- No-store can be used alone but never with no-cache and must-revalidate


Possibilities (Nginx vhost server level. Here at some location block):
```
add_header Cache-Control "no-store";
```

```
add_header Cache-Control "no-cache";
```

```
add_header Cache-Control "no-cache, must-revalidate, max-age=0";
```

```
add_header Cache-Control "must-revalidate, max-age=0";
```  

If there's a conflict, then browser defers to its default caching behavior which could cause unexpected consequences

**Why `no-store` Cannot Be Used with `no-cache` or `must-revalidate`**  

The `no-store` directive fundamentally conflicts with the purpose of `no-cache` and `must-revalidate` because `no-store`... :
- Prevents the browser or intermediaries (e.g., proxies, CDNs) from storing **any part of the resource** at all—neither in memory nor on disk.
- This means there is nothing to validate or revalidate because the resource is never cached in the first place.

### Fundamentals

#### **How `no-cache` Works**

- **Purpose**: 
	- Allows caching of the resource but requires that the cache **revalidate the resource with the server** before using it. It confirms as valid with the server via mechanisms like `ETag` or `Last-Modified`.
	- If the cache cannot contact the origin server (e.g., due to a network issue), it **may still serve a stale copy** of the resource, depending on the cache's policy or configuration.
- **Behavior**:
	- The resource is stored in the cache.
	- Before using the cached version, the browser or proxy must contact the server to confirm if the resource is still valid.
	- Revalidation is typically done using `ETag` or `Last-Modified` headers:
- If the resource is unchanged, the server responds with `304 Not Modified`, and the cached version is used.
- If the resource has changed, the server responds with a fresh version (`200 OK`).
- **Use Case**: 
	- When you want resources to be stored for faster retrieval but ensure they are always up to date.
	- Useful when you want the cache to revalidate the resource in most cases but are okay with it serving stale content as a fallback when the origin server is unavailable.

#### How `no-cache, must-revalidate`Works

- **Behavior**:
	- Like `no-cache`, the cache must validate the resource with the origin server before serving it.
	- With `must-revalidate`, the cache **must not serve stale content under any circumstances**. If the cache cannot revalidate the resource (e.g., the origin server is down), it must fail the request and return a `504 Gateway Timeout` instead of serving stale data.
- **Use Case**:
	- Useful when you require strict freshness guarantees and absolutely cannot tolerate the risk of stale content being served, even temporarily.
#### How `must-revalidate` Alone Works

1. **Freshness Behavior**:
	- While a resource is **fresh** (i.e., within its `max-age` or `Expires` duration), it can be served from the cache without revalidation.
	- Once the resource becomes **stale** (i.e., past its freshness lifetime), the cache **must revalidate** it with the origin server before serving it.
2. **Offline or Server Unavailable**:
	- If the cache cannot contact the origin server to revalidate a stale resource (e.g., due to a network issue), it **must not serve the stale resource**. Instead, it returns a `504 Gateway Timeout` error.

### Comparison: `must-revalidate` Alone vs. `no-cache` Alone

|                 |                                                                                                              |                                                                                                                                           |
| --------------- | ------------------------------------------------------------------------------------------------------------ | ----------------------------------------------------------------------------------------------------------------------------------------- |
| Feature         | `must-revalidate` Alone                                                                                      | `no-cache` Alone                                                                                                                          |
| **While Fresh** | Cached resource can be served without revalidation.                                                          | Cached resource must be revalidated before every use.                                                                                     |
| **While Stale** | Must revalidate with the origin server before serving. If revalidation fails, the resource cannot be served. | Cached resource is not served unless revalidated, but may fallback to stale content if server is unavailable (depending on cache policy). |

#### How `no-store` Alone Works

- **Behavior**:
	- Prevents caching entirely.
	- Neither the browser nor any intermediary (e.g., proxies, CDNs) can store the resource.
	- Every request will require fetching the resource directly from the origin server.

- **Use Case**:
	- Ideal for highly sensitive data (e.g., banking information, personal data, or authentication responses) that must not be stored anywhere.

- **Result**:
	- No caching or revalidation; the resource is always fetched fresh.


####  How `no-cache, must-revalidate, max-age=0` Works

- **Behavior**:
	- Combines:
		- **`no-cache`**: Cache must revalidate the resource before serving it.
		- **`must-revalidate`**: Stale resources cannot be served without revalidation; if the server is unavailable, the request fails.
		- **`max-age=0`**: Makes the resource immediately stale, requiring revalidation on every request.

- **Use Case**:
	- For resources that should not be served stale under any circumstances and must always be verified with the server.

- **Result**:
	- The resource is cached but treated as stale immediately, ensuring strict freshness.

#### How `must-revalidate, max-age=0` Works

- **Behavior**:
	- Combines:
		- **`must-revalidate`**: Once the resource is stale, it must be revalidated before serving.
		- **`max-age=0`**: Treats the resource as stale immediately after retrieval.

- **Use Case**:
	- For resources with a short freshness window or when strict revalidation is needed after the first fetch.

- **Result**:
	- Similar to `no-cache, must-revalidate, max-age=0`, but without the explicit `no-cache` directive. Revalidation is required after the first fetch or whenever the resource becomes stale.

#### Differences So Far

| Directive                              | Caching Allowed? | Always Revalidate? | Serve Stale on Failure? | Primary Use Case                         |
| -------------------------------------- | ---------------- | ------------------ | ----------------------- | ---------------------------------------- |
| `no-store`                             | No               | N/A                | N/A                     | Highly sensitive data                    |
| `no-cache`                             | Yes              | Yes                | Yes (policy-dependent)  | Dynamic content with potential staleness |
| `no-cache, must-revalidate, max-age=0` | Yes              | Yes                | No                      | Dynamic, critical content                |
| `must-revalidate, max-age=0`           | Yes              | Yes (after stale)  | No                      | Content requiring strict revalidation    |

---

### Recommendation for Nginx

- Use the directive that matches your resource's sensitivity and performance requirements.
- **Example** for a highly dynamic and sensitive API:
```
    location /api/ {
        add_header Cache-Control "no-cache, must-revalidate, max-age=0";
    }
```

- For static but time-sensitive resources:
```
    location /static/ {
        add_header Cache-Control "must-revalidate, max-age=0";
    }
```
  
## Don't trust AI:

Note so far in 12/2024: if you ask ChatGPT 4o for nginx or php no caching code, the LLM is biased towards giving you the wrong syntax that uses all no store, no cache, and must revalidate. However on a subsequent prompt in the same chat, if you ask about whether it's ok to mix them, the AI will apologize and correct itself.

  
ChatGPT gives incorrect PHP:
```
// Disable caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");
```

Similarly, it will give incorrect Nginx Vhost as well.

As for PHP, the correct solution could be:
```
// Disable caching
header("Cache-Control: no-store");
header("Pragma: no-cache"); // For HTTP/1.0 backward compatibility
header("Expires: 0"); // Forces expiration immediately
```

When you point out isn’t it incorrect to mix these values for Cache-Control, ChatGPT will agree.