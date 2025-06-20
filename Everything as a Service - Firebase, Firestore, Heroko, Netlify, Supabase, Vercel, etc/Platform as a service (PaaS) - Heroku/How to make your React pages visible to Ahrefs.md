
If you’re just crawling with AhrefsBot (or using the default Site Explorer crawl), it will only grab what’s in the _raw_ HTML and won’t “wait” for React (or any client-side framework) to finish rendering. In other words, all of your meta-tags and outbound links that are injected by React won’t exist in the HTML that AhrefsBot sees, so it reports “no meta tags” or “no outbound links.”

**What Ahrefs _can_ do…**

- **Site Audit tool** now _does_ execute JavaScript on every page you audit, so it can see React-injected content ([ahrefs.com](https://ahrefs.com/blog/site-audit-crawls-javascript/?utm_source=chatgpt.com "Ahrefs' Site Audit tool can now execute JavaScript while crawling ...")).
    
- **Site Explorer**, however, only renders JS on pages with a high number of referring domains (15+), since rendering every page at scale would be prohibitively expensive ([ahrefs.com](https://ahrefs.com/blog/crawling-javascript/?utm_source=chatgpt.com "Ahrefs crawlers are now rendering web pages and executing ...")).
    

---

## How to make your React pages visible to Ahrefs

1. **Server-Side Render (SSR) or Static-Generate**
    
    - Move your meta-tags and critical markup into the HTML that ships from your server (e.g. Next.js, Gatsby, SvelteKit).
        
    - This ensures that bots see the fully formed page immediately, without waiting for client-side code.
        
2. **Prerendering**
    
    - Use a service like [Prerender.io] or a build-time prerender script to snapshot your routes as static HTML.
        
    - Serve that to crawlers while still delivering the React app to real users.
        
3. **Dynamic Rendering / “Hybrid”**
    
    - Detect bots (by user-agent) and serve them a prerendered version, while normal users get your full SPA.
        
4. **Enable JavaScript Rendering in Site Audit**
    
    - If you have access to Ahrefs’ Site Audit, turn on JS rendering so the audit will execute your React code and pick up all tags and links.
        

By moving your SEO-critical elements into the initial HTML (via SSR, SSG, or prerendering), you’ll ensure Ahrefs (and other non-JS-executing crawlers) can see and report on them correctly.