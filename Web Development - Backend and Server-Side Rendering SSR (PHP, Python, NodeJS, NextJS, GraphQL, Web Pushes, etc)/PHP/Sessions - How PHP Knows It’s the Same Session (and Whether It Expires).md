When you use sessions in PHP, PHP isn’t “recognizing you” as a person or device. It’s recognizing a **session ID** that gets passed back and forth between the browser and the server. That ID is the key that lets PHP load the right saved session data for each request.

---

## How PHP Knows It’s the Same Session

### The session ID is the whole trick

PHP keeps sessions tied together using a unique identifier called the **session ID**. Here’s the typical flow:

1. **First request:** your code calls `session_start()`.
    
2. PHP looks for an existing session ID in the incoming request (usually a cookie).
    
3. If none exists, PHP:
    
    - creates a new session,
        
    - generates a random session ID,
        
    - sends it back to the browser in a response header like:
        
        - `Set-Cookie: PHPSESSID=abc123...; path=/; ...`
            
4. **Later requests:** the browser automatically sends that cookie back:
    
    - `Cookie: PHPSESSID=abc123...`
        
5. PHP reads the ID, loads the corresponding session data from storage, and now it’s “the same session.”
    

### Where session data is stored

The session ID is just a pointer. The actual session data (your `$_SESSION` array) lives on the server, commonly in one of these places:

- **Filesystem** (default): stored as files like `sess_abc123...`
    
- **Redis / Memcached / database**: common in production via a custom `session.save_handler`
    

### What if cookies are disabled?

PHP _can_ pass the session ID in the URL instead (not recommended because it leaks easily):

- `example.com/page.php?PHPSESSID=abc123...`
    

### Common reasons sessions don’t “stick”

Even when your code is correct, sessions can break if the browser doesn’t send the ID back or the server can’t find the stored data. Typical causes:

- Cookie isn’t stored/sent (wrong domain/path, `Secure` cookie on HTTP, `SameSite` issues, blocked cookies)
    
- Session ID changes (you call `session_regenerate_id(true)`)
    
- Session data gets deleted/expired on the server
    
- Multiple servers without shared session storage (load balancing needs “sticky sessions” or shared storage like Redis)
    

---

## Do PHP Sessions Expire?

Yes — but there are **two different expirations** to understand:

### 1) Cookie expiration (client-side)

The browser only continues a session if it keeps sending the session ID cookie back.

- **Default:** PHP uses a _session cookie_ with **no explicit expiration**, so it lasts until the browser closes.
    
- If you set a lifetime (via `session_set_cookie_params()` or `session.cookie_lifetime`), the cookie can persist longer.
    

Key setting:

- `session.cookie_lifetime`
    
    - `0` = until browser closes
        
    - `>0` = seconds until the cookie expires
        

### 2) Session data expiration (server-side garbage collection)

Even if the browser still sends `PHPSESSID`, PHP may no longer have the data stored for that ID.

Key settings:

- `session.gc_maxlifetime` — seconds until session data is considered “old”
    
- `session.gc_probability` / `session.gc_divisor` — how often cleanup runs
    

**Important gotcha:** cleanup is **probabilistic**, not a precise timer. Data becomes eligible for deletion after `gc_maxlifetime`, but might be removed a bit later depending on when garbage collection runs.

### Typical defaults (often, but not guaranteed)

- `session.gc_maxlifetime = 1440` (24 minutes)
    
- `session.cookie_lifetime = 0` (until browser closes)
    

Hosting providers and frameworks often change these values.

---

## Quick Check: What Are Your Current Settings?

```php
echo "cookie_lifetime: " . ini_get('session.cookie_lifetime') . "\n";
echo "gc_maxlifetime: " . ini_get('session.gc_maxlifetime') . "\n";
echo "gc_probability/divisor: " . ini_get('session.gc_probability') . "/" . ini_get('session.gc_divisor') . "\n";
```

---

## Practical Takeaways

- PHP knows it’s the same session because the browser sends the **same session ID** (usually via a cookie).
    
- A session can “end” because:
    
    - the **cookie disappears** (browser closed or cookie expired), or
        
    - the **server deleted the session data** (garbage collection / expiration).
        
- If you need “log out after X minutes of inactivity,” it’s common to store a timestamp in `$_SESSION` and enforce inactivity rules yourself (because GC timing isn’t exact).