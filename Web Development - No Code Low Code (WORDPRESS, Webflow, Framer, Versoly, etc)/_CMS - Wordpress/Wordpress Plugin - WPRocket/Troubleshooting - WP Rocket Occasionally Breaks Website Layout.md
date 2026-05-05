
When using WP Rocket (or any caching plugin), two common issues can cause your site’s layout or functionality to break for visitors:

1. **Cache Mismatch After Settings Changes**
    
    - If you change WP Rocket settings but don’t **clear and preload the cache**, the cached version may still reference outdated CSS/JS.
      ![[Pasted image 20250827034510.png]]
    
    - Logged-in admins won’t notice (because WordPress bypasses cache for you), but logged-out visitors or incognito users may see a completely broken layout—often missing CSS.
    
2. **Nonce Expiry**
    
    - WordPress nonces (“numbers used once”) are short-lived security tokens embedded in forms, AJAX calls, and links.
    - If a nonce expires while the page is cached, users may hit errors or broken functionality hours later—even though the site looks fine to you.
    - Change the value to a value below 12 hours; 10 hours would be a starting point, but you may have go down to 8 or even less.
      ![[Pasted image 20250827034458.png]]
    

✅ **Best Practices to Prevent Breakage**

- Always **clear + preload cache** after changing WP Rocket options.
- Align cache lifespan to be **shorter than nonce lifespan**.
- Exclude **nonce-heavy pages** (checkout, dashboards, forms, etc.) from caching at WPRocket -> Advanced Rules ->  Never Cache URL(s)
- If you _must_ cache nonce-heavy pages, adjust the **cache lifespan under WP Rocket → Advanced Rules** so the cache refreshes before nonces expire.

---

Possibly a more permanent fix is to always clear and reload cache automatically for all URLs whenever any page or post is edited. Note with this setup, you still have to manually clear and reload cache after changing wprocket settings.

WPRocket to purge everytime a page/post saved.  
URL:  
```
/.*
```

Where?
Under Advanced Rules:
![[Pasted image 20250830200515.png]]

Scroll down until you find "Always Purge URL(s)" and enter the wildcard there:
![[Pasted image 20250830200542.png]]