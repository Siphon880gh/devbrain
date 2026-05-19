WAIT: Are you turning off Cloudflare for an API endpoint or webhook? Read the Security Note at [[Bypass Cloudflare for public API endpoint or webhook]] so you are aware of mitigation strategies.

---

Let's say you need to turn off Cloudflare protection for a specific url because it's causing problems.

For example, you want your API to be accessible, so you already implemented CORS at nginx/apache/ or flask/express. But now it's Cloudflare getting in the way. You know it is because hitting tha t API in an app like Postman shows you HTML for a Cloudflare challenge page

1. Add a WAF rule for URL containing wildcard: `/api/*`
2. Choose Skip for action.
3. Select all components to skip

![[Pasted image 20260519055817.png]]
