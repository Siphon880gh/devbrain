### Wildcard SSL Certificate with Certbot for Multiple Domains

In this case, I needed to secure two separate Namecheap-managed domains:  
[**wengindustry.com**](https://wengindustry.com/) and [**wengindustries.com**](https://wengindustries.com/), including wildcard coverage for their subdomains.

To request the wildcard SSL certificates, I ran the following:

```bash
certbot certonly --manual --preferred-challenges dns \
  -d "*.wengindustries.com" -d "wengindustries.com" \
  -d "*.wengindustry.com" -d "wengindustry.com"
```

> ⚠️ **Certbot Note:** It’s not preinstalled by default on most Linux distros. Search your distribution’s install method (e.g. `apt install certbot` on Debian/Ubuntu).

---

### Initial Setup

If you're using Certbot for the first time, it will:
- Prompt you to agree to the Let's Encrypt terms of service
- Ask for your email address (optional, but recommended for expiration reminders)

All of this happens interactively in your terminal when you run the command above.

---

### DNS Challenge: TXT Record Setup

Certbot will then walk you through setting **TXT records** to verify ownership. For each domain, it will ask for:
- A TXT record for the root domain (`domain.com`)
- A TXT record for the wildcard (`*.domain.com`)

Since I was using **two different domains**, I had to add a total of **four TXT records**—**two for `wengindustries.com`**, and **two for `wengindustry.com`**—via the Namecheap DNS dashboard.

> 🧠 **Tip:** Set the TTL (Time To Live) for each TXT record to the **lowest available option**, such as **1 minute**, for faster propagation.

Certbot will guide you step-by-step through each domain's challenge:

![[Pasted image 20250524050356.png]]

Let's say you're a bit further along now:

![[Pasted image 20250524050408.png]]

---

### Example Certbot Prompt

Here’s an example of what Certbot might ask:

```
Please deploy a DNS TXT record under the name:

_acme-challenge.wengindustries.com

with the following value:

Yy<CENSORED>
```

It will end with a reminder:

> **Before continuing**, verify the TXT record has been deployed. Depending on your DNS provider, propagation may take a few seconds to several minutes.
> 
> You can check TXT propagation using the [Google Admin Toolbox Dig tool](https://toolbox.googleapps.com/apps/dig/#TXT/_acme-challenge.wengindustry.com).  
> Look for one or more **bolded lines** below the `;ANSWER` section—that indicates your TXT value is live.

---

Once your DNS records are verified and visible, press **Enter** in the terminal to continue. Certbot will finish issuing your wildcard certificates.

But yes — when you run `certbot certonly`, it **only fetches the SSL/TLS certificate files** from Let’s Encrypt. It does **not** automatically configure your web server (like NGINX or Apache) to use them.

---

### ✅ Next Step: Configure Your Web Server for HTTPS

Assuming you're using **NGINX**, here's what to do:

---

### 🔍 1. Locate the Certificates

Certbot usually saves your certificates in:

```
/etc/letsencrypt/live/yourdomain.com/
```

That folder will contain:

|File|Purpose|
|---|---|
|`fullchain.pem`|The certificate + chain|
|`privkey.pem`|Your private key|
|`cert.pem` (optional use)|Your domain certificate only|
|`chain.pem` (optional use)|Intermediate chain only|

> For most web servers, you'll only need `fullchain.pem` and `privkey.pem`.

---

### 🛠️ 2. Update Your NGINX Config

Inside your NGINX server block for HTTPS (port 443), use:

```nginx
server {
    listen 443 ssl http2;
    server_name yourdomain.com;

    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;

    # Optional but recommended
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;

    root /your/web/root;
    index index.html index.php;

    location / {
        try_files $uri $uri/ =404;
    }
}
```

For multiple domains like `*.wengindustry.com` and `*.wengindustries.com`, you can repeat the block or use:

```nginx
server_name wengindustry.com *.wengindustry.com wengindustries.com *.wengindustries.com;
```

---

### 🧪 3. Reload NGINX

```bash
sudo nginx -t   # check for config errors
sudo systemctl reload nginx
```

---

### 🔁 Optional: Auto-Renew Setup

Let’s Encrypt certs expire every 90 days. To auto-renew:

```bash
sudo crontab -e
```

Then add a line like:

```
0 3 * * * certbot renew --quiet && systemctl reload nginx
```

This checks daily at 3 AM and reloads NGINX if renewal occurs.

---

Let me know if you're using CloudPanel, Apache, or something else—I'll tailor the setup for that.