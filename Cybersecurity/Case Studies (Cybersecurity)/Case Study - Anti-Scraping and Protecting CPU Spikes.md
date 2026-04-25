## Anti-Scraping Hardening — A Story

This is how my app went from **“Hostinger suspended my account due to CPU spikes to 100%** from botnet scraping attacks" to **“CPU near 0% under the same kind of attack.”**

This isn’t theory — it’s what actually worked after getting hit by scraper traffic that behaved like a botnet.

---

## The trigger

I have a web app full of coding notes. After a few years online, scrapers found it and started hammering it — nonstop requests with no cooldown.

![[app-devbrain.png]]

Logs showed it wasn’t just one bot. New bots kept coming in as others finished. That’s classic botnet behavior.

> I was able to diagnose it was bot activities through the steps at [[Diagnosing Bot Attacks - Quick Reference]]

The problem wasn’t just the notes section — the **entire website slowed down**, and my VPS CPU kept hitting **100%**.

It got so bad that **Hostinger suspended my account**.

That was the moment I knew I needed protection.

---

## Move 1 — Put it behind Cloudflare (too late)

I added Cloudflare, expecting it to block most of the abuse.

It helped… but not enough.

The issue was timing:

> The bots already knew my VPS IP address.

So instead of going through Cloudflare, they just **attacked the server directly**.

Hostinger didn’t allow IP changes, so I couldn’t rotate to a clean IP.

At that point, Cloudflare couldn’t fully protect me anymore.

---

## Move 2 — Move to a new VPS with a clean IP

I switched to Hetzner because it gave me more flexibility.

But the key wasn’t the provider — it was the setup:

> **I did NOT expose my domain publicly until Cloudflare was fully set up.**

That meant:

- My origin IP was never leaked
    
- Bots never recorded it
    
- All traffic had to go through Cloudflare
    

This step is critical. If your IP leaks once, bots will keep using it.

---

## Move 3 — Block non-US traffic

Cloudflare blocked a lot of bad traffic, but CPU was still spiking.

My site only serves US users, so I added a rule:

> Block all non-US traffic at Cloudflare

This immediately reduced load.

But this depends on your audience:

- If you have global users → don’t do this
    
- If your audience is local → this is a big win

---

## Move 4 — Add a non-interactive challenge

Even after geo-blocking, some US-based bots still got through.

Checkpoint: 
At this point, I have Cloudflare blocking outside US traffic AND I have cloudpanel set to only accept cloudflare traffic AND cloudflare automatically blocks abusive IPs. Unfortunately there are many bots that are simply not blocked by Cloudflare

These remaining requests pushed my Nginx CPU usage to around **20%**.

So I added a **non-interactive Cloudflare challenge** on the app URL.

- Real users → pass automatically
- Bots → often fail

This filtered out another layer of bad traffic.

---

## Move 5 — Stop serving `.md` files directly

My site is a directory of notes stored as Markdown (`.md`) files.

Originally, users (and bots) could access them directly.

That’s exactly what scrapers want:

```
/notes/a.md
/notes/b.md
/notes/c.md
```

They can easily crawl everything.

### Fix:

- The frontend no longer loads `.md` files directly
    
- A PHP script reads and renders the file instead
    
- Nginx blocks all direct `.md` access
    

This change alone cut a huge amount of scraping traffic.

---

## Move 6 — Add throttling at the PHP level

Once `.md` files were protected, the PHP endpoint became the new target.

So I added throttling:

> Limit how many requests an IP can make over a short period

This prevents:
- Rapid scraping
- CPU spikes from repeated file loads

Now even if a bot gets through, it can’t overwhelm the system.

---

## Move 7 — Use browser caching (ETag + revalidation)

Some of my largest files are JSON and pre-rendered HTML.

Instead of re-downloading them every time, I used:

```
Cache-Control: no-cache, must-revalidate
ETag
```

This tells the browser:

> “Save this file locally, but check if it changed before using it.”

If nothing changed:

- Server returns **304 Not Modified**
    
- Browser uses local copy
    
- No heavy processing needed
    

### Cloudflare issue

Cloudflare sits between the browser and server.

By default, it can interfere with this behavior and return **200 responses instead of 304**.

### Fix:

> Set Cloudflare to bypass cache for these specific files

This lets the origin server handle validation properly.

After this step:

- CPU dropped from ~20% → ~5%
    

---

## Move 8 — Add compression (gzip + Brotli)

Even with caching, first-time loads still transfer full files.

These files are large but very compressible.

So I enabled:

- **gzip**
    
- **Brotli**
    

This reduces file sizes dramatically (often up to ~90%+).

The browser automatically decompresses the response — no frontend changes needed.

For most setups, this just means:

- Enable gzip and Brotli in Nginx or Apache
    

---

## Result

After all these layers:

- CPU dropped from **100% → near 0%**
    
- Scraper impact became minimal
    
- Legitimate users load faster
    
- Far fewer bad requests reach the server
    

---

## Biggest takeaway

> **Cloudflare alone is not enough.**

Even with:

- Bot protection
    
- Geo-blocking
    
- Security rules
    

Bots still got through.

What worked was **layering protections**:

- Clean origin IP
    
- Cloudflare
    
- Geo-blocking
    
- Challenge page
    
- Blocking direct file access
    
- PHP throttling
    
- Browser caching (ETag)
    
- Compression
    

Each layer reduces load before it reaches the next one.

---

## Highest-impact steps (if you copy anything)

If you only implement a few things, do these first:

1. **Block direct access to raw files (like `.md`)**  
    → Stops the easiest scraping path
    
2. **Add request throttling on your backend**  
    → Limits how much damage one IP can do
    
3. **Use browser caching with ETag + 304 responses**  
    → Makes repeat visits almost free
    

---

This combination is what turned a constantly crashing VPS into a stable system — even under the same kind of attack.