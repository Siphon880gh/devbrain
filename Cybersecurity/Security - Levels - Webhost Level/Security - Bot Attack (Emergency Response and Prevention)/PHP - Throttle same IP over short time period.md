**Note**: This is not the full solution to bot attacks. This is one of many interventions needed. Refer to [[_ Best Practice - Prevent or Stop Bot Attacks (Linux, Cloudflare, PHP)]] for the other interventions.

---

If your app uses PHP, you may want to rate-limit repeated requests coming from the same IP address within a short time window.

When a scraper exceeds the limit, the server responds with **HTTP 429 Too Many Requests**.

If the traffic is coming from a real user clicking too quickly in the browser (which can still stress CPU and network resources), the app degrades more gracefully by showing a friendly cooldown message instead of a raw error page.

![[throttle.png]]

---

I have a web app full of coding notes. After a few years online, scrapers found it and started hammering it with nonstop requests and no cooldown between them.

![[app-devbrain.png]]

The logs showed it was not just one bot. New bots kept appearing while others finished. That is classic botnet behavior.

> I was able to confirm it was bot activity through the steps at [[Diagnosing Bot Attacks - Quick Reference]]

After implementing Linux-level protections and Cloudflare bot mitigations, I also wanted to harden the PHP side of the application.

This guide rate-limits the PHP endpoint that legitimately serves notes, so a scraper cannot simply walk through `?id=1`, `?id=2`, `?id=3`, and continue pulling the entire knowledge base. This concept applies to almost any website with predictable IDs or endpoints.

[local-open.php](https://chatgpt.com/c/local-open.php) is the single entry point that serves note content. Before resolving `?id=N`, the script now tracks requests from each client IP using a short sliding time window.

If a client exceeds the configured limit:

- The endpoint returns **HTTP 429 Too Many Requests**
    
- A `Retry-After` header is included
    
- The frontend displays a friendly cooldown message instead of the note content
    

This slows down scraping while still giving legitimate users a readable response.

The default production configuration (from [config-throttle.json](https://chatgpt.com/c/config-throttle.json)) is designed for a **Cloudflare + CloudPanel** setup:

- **4 requests per 30 seconds** per IP
    
- Authenticated PRIVATE users are **not automatically bypassed**
    
    - The rate limit still applies to logged-in users so an authenticated browser tab cannot become an unlimited scraping channel
        
- `X-Forwarded-For` and `X-Real-IP` are **not trusted**
    
    - CloudPanel terminates TLS locally and forwards traffic to PHP over loopback
        
    - Those headers can be spoofed by anything reaching the public edge outside Cloudflare
        
- `CF-Connecting-IP` **is trusted**
    
    - The server is assumed to be locked down to Cloudflare IP ranges
        
    - That makes Cloudflare’s header authoritative for determining the real client IP
        

## Configuration — [config-throttle.json](https://chatgpt.com/c/config-throttle.json)

Two configurations cover most deployments. Pick the one that matches your setup, drop it into [config-throttle.json](https://chatgpt.com/c/config-throttle.json), and you are done.

A full field-by-field explanation is available below if you want to customize behavior.

---

## Recipe A — Cloudflare in Front of CloudPanel (Recommended / Default)

In this setup, the origin server only accepts traffic from Cloudflare IP ranges. That means `CF-Connecting-IP` can safely be trusted as the real visitor IP.

Everything else — including `X-Forwarded-For` and `X-Real-IP` — is ignored because those headers are only trustworthy if the request truly came through Cloudflare.

With the origin locked down properly, only Cloudflare can set `CF-Connecting-IP`, so that becomes the IP used for throttling.

```json
{
  "enabled": true,
  "max_requests": 4,
  "window_seconds": 30,
  "storage_dir": "temp/throttle",
  "cooldown_message": "**Slow down.** You're opening notes too quickly. Please wait a moment and try again.",
  "bypass_authenticated_private": false,
  "trust_forwarded_for": false,
  "trust_cloudflare": true
}
```

---

## Recipe B — No Cloudflare, PHP Served Directly

This setup assumes:
- No Cloudflare
- No reverse proxy in front of CloudPanel
- CloudPanel is directly exposed on port 443

In this topology, `REMOTE_ADDR` is already the real client IP.

Because of that:
- `trust_forwarded_for` stays disabled
- `trust_cloudflare` stays disabled

The moment either trust option is enabled without a trusted proxy in front, a scraper can forge fake headers and rotate through unlimited fake IP addresses to bypass rate limits.

Use this config:

```json
{
    "enabled": true,
    "max_requests": 4,
    "window_seconds": 30,
    "storage_dir": "temp/throttle",
    "cooldown_message": "**Slow down.** You're opening notes too quickly. Please wait a moment and try again.",
    "bypass_authenticated_private": false,
    "trust_forwarded_for": false,
    "trust_cloudflare": false
}
```

---

## How the Rate Limiter Works

The limiter is implemented directly inside `local-open.php`.

Each request:

1. Determines the client IP
    
2. Hashes the IP with SHA-256
    
3. Stores request timestamps inside `temp/throttle`
    
4. Removes timestamps that fall outside the configured time window
    
5. Checks whether the client exceeded the request limit
    

If the limit is exceeded:

- PHP returns **HTTP 429**
    
- `Retry-After` is sent
    
- A friendly YAML response is returned so the frontend can render the cooldown message inside the note viewer
    

Instead of showing a raw server error, the user sees a normal UI message.

The limiter also performs lightweight cleanup:

- About 1% of requests trigger garbage collection
    
- Counter files older than 24 hours are deleted automatically
    

---

## Important Security Notes

### Do Not Blindly Trust Proxy Headers

Headers like:

- `X-Forwarded-For`
    
- `X-Real-IP`
    

should only be trusted if your server is actually behind a trusted reverse proxy.

Otherwise, attackers can forge those headers and bypass throttling by pretending to be different IP addresses.

---

## Storage Directory Requirement

The limiter requires a writable directory for storing request counters:

```text
temp/throttle
```

The PHP process must have permission to create and write files inside that directory.

---

## local-open.php?id=1

```php
<?php
session_start();


$id = isset($_GET["id"]) ? intval($_GET["id"]) : null;

// ============================================================
// Rate limiting (anti-scraping) — see README - Throttle Note Requests.md
// Config: config-throttle.json. Missing/invalid config = fail-open (off).
// Keyed on client IP, stored as JSON counter files under storage_dir.
// ============================================================
(function () {
    $configPath = __DIR__ . '/config-throttle.json';
    if (!file_exists($configPath)) return;
    $raw = @file_get_contents($configPath);
    if ($raw === false) return;
    $cfg = json_decode($raw, true);
    if (!is_array($cfg) || empty($cfg['enabled'])) return;

    $maxRequests   = isset($cfg['max_requests'])   ? max(1, intval($cfg['max_requests']))   : 4;
    $windowSeconds = isset($cfg['window_seconds']) ? max(1, intval($cfg['window_seconds'])) : 30;
    $storageDir    = isset($cfg['storage_dir'])    ? (string)$cfg['storage_dir']            : 'temp/throttle';
    $cooldownMsg   = isset($cfg['cooldown_message'])
        ? (string)$cfg['cooldown_message']
        : "Slow down — too many note requests. Please wait a moment and try again.";
    $bypassPrivAuthed = !empty($cfg['bypass_authenticated_private']);
    $trustXff         = !empty($cfg['trust_forwarded_for']);
    $trustCloudflare  = !empty($cfg['trust_cloudflare']);

    // Already-authenticated PRIVATE users can opt out (normal browsing shouldn't trip rate limits).
    if ($bypassPrivAuthed && isset($_SESSION['private_auth']) && $_SESSION['private_auth'] === true) {
        return;
    }

    // Identity: direct REMOTE_ADDR by default.
    //
    // Header priority when trusted:
    //   1. CF-Connecting-IP  (Cloudflare) — always the real client IP, no parsing
    //   2. X-Real-IP         (set by Nginx / CloudPanel reverse proxy)
    //   3. X-Forwarded-For   (first hop is the client)
    //
    // Only enable the trust flags if your origin is actually behind that proxy;
    // otherwise any visitor can forge these headers and evade rate limiting.
    $clientIp = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    if ($trustCloudflare && !empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        $clientIp = trim($_SERVER['HTTP_CF_CONNECTING_IP']);
    } elseif ($trustXff) {
        if (!empty($_SERVER['HTTP_X_REAL_IP'])) {
            $clientIp = $_SERVER['HTTP_X_REAL_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $parts = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $clientIp = trim($parts[0]);
        }
    }
    // No identifiable client (CLI, odd SAPI) — skip rather than globally rate-limit.
    if ($clientIp === '') return;

    // Resolve storage dir. Accept absolute or relative-to-script paths.
    $storagePath = (strlen($storageDir) > 0 && $storageDir[0] === '/')
        ? $storageDir
        : __DIR__ . '/' . ltrim($storageDir, '/');
    if (!is_dir($storagePath)) {
        @mkdir($storagePath, 0755, true);
    }
    if (!is_dir($storagePath) || !is_writable($storagePath)) return;


    $ipKey       = hash('sha256', $clientIp);
    $counterFile = $storagePath . '/' . $ipKey . '.json';
    $now         = time();
    $windowStart = $now - $windowSeconds;

    $timestamps = [];
    if (file_exists($counterFile)) {
        $prev = @file_get_contents($counterFile);
        if ($prev !== false && $prev !== '') {
            $decoded = json_decode($prev, true);
            if (is_array($decoded)) {
                foreach ($decoded as $t) {
                    if (is_numeric($t) && intval($t) >= $windowStart) {
                        $timestamps[] = intval($t);
                    }
                }
            }
        }
    }

    if (count($timestamps) >= $maxRequests) {
        http_response_code(429);
        header('Retry-After: ' . $windowSeconds);
        header('Content-Type: text/plain; charset=utf-8');
        echo "title: Too many requests\nhtml: |\n" . $cooldownMsg;
        exit;
    }

    $timestamps[] = $now;
    @file_put_contents($counterFile, json_encode(array_values($timestamps)));

    // Opportunistic cleanup (~1% of requests): delete counter files untouched for 24h.
    if (mt_rand(1, 100) === 1) {
        $entries = @scandir($storagePath);
        if (is_array($entries)) {
            foreach ($entries as $entry) {
                if ($entry === '.' || $entry === '..') continue;
                $full = $storagePath . '/' . $entry;
                if (is_file($full) && filemtime($full) < ($now - 86400)) {
                    @unlink($full);
                }
            }
        }
    }
})();
?>
```
It requires we have the path `temp/throttle` and that it can be written to, so you may need to mkdir -p and chmod.