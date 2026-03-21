
Usually **bots attack at the perimeter and application layers**.

**Perimeter layer** if they are:

- flooding your public IP
    
- hitting ports directly
    
- doing basic DDoS or connection spam
    
- bypassing the domain and going straight to the server IP
    

This is where tools like **firewalls, CDNs, reverse proxies, WAFs, and DDoS protection** help.

**Application layer** if they are:

- scraping pages
    
- spamming forms
    
- brute-forcing logins
    
- hammering search boxes or APIs
    
- crawling routes very aggressively
    

This is where **rate limits, bot detection, CAPTCHA, login protection, app rules, and WAF rules** help.

In your case, if bots were hitting the **VPS public IP directly**, that is mainly a **perimeter-layer attack**.  
If they were repeatedly requesting pages, login URLs, or app endpoints, that is also an **application-layer attack**.

A clean way to say it:

> Bot attacks usually target the perimeter layer first, and often continue into the application layer depending on whether they are flooding traffic, scraping content, or abusing forms and logins.

A more security-technical phrasing is:

- **Network/perimeter attack** = attacking the server/IP/path to the app
    
- **Application-layer bot attack** = abusing HTTP/HTTPS requests against the website or API
    

If you want, I can map common bot behaviors into a table like **scraping, brute force, DDoS, credential stuffing, and vulnerability scanning → which security layer they hit**.