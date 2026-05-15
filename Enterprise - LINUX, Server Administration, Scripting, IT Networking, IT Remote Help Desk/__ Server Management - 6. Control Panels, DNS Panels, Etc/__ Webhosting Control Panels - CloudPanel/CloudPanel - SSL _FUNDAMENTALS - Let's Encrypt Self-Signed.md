
![](U0LxTcK.png)

Let’s Encrypt (via CloudPanel) creates a temporary validation file in your site’s document root to verify domain ownership. You can view or set this root under **CloudPanel → Settings → Root Directory**.

If your domain or subdomain points to a custom folder (e.g., `app.domain.com` mapped to `/home/USER/htdocs/DOMAIN/apps/app1`), you must **temporarily set it to the main root directory** during certificate issuance. You can comment out the custom root in your NGINX config and restore it after the certificate is successfully created.

The same applies if you're running a backend app (like Express on port 3000) behind a reverse proxy—**you'll need to disable or comment out the reverse proxy block** so the ACME challenge file can be served directly over HTTP.

Before issuing the certificate, **disable any HTTP → HTTPS redirects**. Let’s Encrypt must access the validation file over plain `http://`, and it **won’t follow HTTPS redirects**. These are typically set in your NGINX vhost. To comment out multiple lines quickly in VS Code, use regex replace (`^` → `#` ). Make sure you're adding `#` for NGINX comments, not `//`.

**Important:** The ACME server only validates the **exact domain names** you include in your certificate request. It won't automatically cover both `www.example.com` and `example.com`—you must explicitly list each one.

If you're redirecting `www` to the non-`www` version (or vice versa), you don’t need to request a certificate for the pre-redirected version. For example, if users visiting `www.example.com` get redirected to `example.com`, then you only need HTTPS for `example.com`, and you can skip adding `www.example.com` in your SSL request.

However, if you want users to **stay on the `www.` version** (i.e., no redirect), eg. if your target audience is the older generation that may come to associate all websites with "www", then you must:
- Include both the `www` and non-`www` versions in your SSL request.
- Configure your server to serve both names without redirecting during the ACME challenge.   
- Ensure your `server_name` block includes both versions:

```nginx
server_name www.yourdomain.com yourdomain.com;
root /home/USER/htdocs/DOMAIN/;
```
^ This setup allows the ACME server to validate both domains and enables HTTPS access on each.

Finally, if Let’s Encrypt can’t access your domain—due to DNS issues, missing A/CNAME records, or misconfigurations—CloudPanel will display an error message to help you troubleshoot.

---

After successful issuance, don't forget to reverse the changes you made to vhost for the certification to go through.

Otherwise, for example, visiting your website could look broken because it couldn't load pictures or css at the correct path:
![[Pasted image 20250524031056.png]]

In the above case, it was a matter of setting the root back to my custom root for the app's asset files to load in. The icons did load in the above screenshot because they were SVGs and emoji's, but you can tell the styling was off or generic because much of the css were in external files probably, other than style blocks in-page.