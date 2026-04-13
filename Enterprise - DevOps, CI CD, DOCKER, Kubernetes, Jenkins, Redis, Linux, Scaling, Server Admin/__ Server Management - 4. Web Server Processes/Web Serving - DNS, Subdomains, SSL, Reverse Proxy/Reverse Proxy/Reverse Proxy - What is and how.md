You can use a **reverse proxy** to make a normal-looking URL point to an app that is really running on a custom port, such as `domain.tld:3000` (Node.js/Express) or `domain.tld:5000` (Python/Flask).

Instead of making users type a port number, they can visit something cleaner like:
- `domain.tld/app1`
- or `app1.domain.tld`

### Why do this?

- Cleaner URLs for users
- Better for SEO than exposing ports
- Uses standard ports (**80 / 443**)
- Fewer exposed ports = simpler + more secure

---

## Nginx (where + example)

**Where:**
- `/etc/nginx/sites-available/your-site`
- then symlink to `/etc/nginx/sites-enabled/`

**Example:**

```nginx
server {
    ...

    location /app1 {
        proxy_pass http://localhost:3000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection 'upgrade';
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
    }

    ...
}
```

**Enable + reload:**

```bash
ln -s /etc/nginx/sites-available/your-site /etc/nginx/sites-enabled/
nginx -t
systemctl reload nginx
```

---

## Apache (where + example)

**Where:**
- `/etc/apache2/sites-available/your-site.conf` (Debian/Ubuntu)
- or inside your existing VirtualHost file
- (on CentOS/RHEL: `/etc/httpd/conf.d/`)

**Example:**

```apache
<VirtualHost *:80>
    ServerName domain.tld

    ProxyPreserveHost On
    ProxyPass /app1 http://localhost:3000/
    ProxyPassReverse /app1 http://localhost:3000/
</VirtualHost>
```

**Enable + reload (Debian/Ubuntu):**

```bash
a2enmod proxy
a2enmod proxy_http
a2ensite your-site.conf
systemctl restart apache2
```

---

## In plain English

The web server listens on the normal web ports, such as **80** and **443**, and then quietly passes the request to your app running in the background on another port like **3000** or **5000**.

That way, your app still runs on its own port, but visitors never have to see or type that port number.