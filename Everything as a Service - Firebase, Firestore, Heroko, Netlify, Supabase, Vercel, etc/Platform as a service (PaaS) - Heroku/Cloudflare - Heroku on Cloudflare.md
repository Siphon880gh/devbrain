
**Connecting Heroku to Cloudflare**

Heroku provides a DNS target URL, but you should ignore that—it won't resolve correctly. Instead, use your Heroku app’s direct URL (e.g., `your-app.herokuapp.com`), which is already publicly accessible.

In your Cloudflare DNS settings:

- Add an **A record** with the name `@`
- Point it to the Heroku app’s URL

> Note: If you're using a custom domain, consider using a **CNAME** record pointing to `your-app.herokuapp.com` instead of an A record, since Heroku apps don’t have static IPs.


![[Pasted image 20250620055613.png]]