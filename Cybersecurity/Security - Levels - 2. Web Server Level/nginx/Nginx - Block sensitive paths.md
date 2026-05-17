
Nginx can be configured to return a 403 Forbidden response for any request that targets sensitive directories or files that should never be publicly accessible from the web.

Common examples:
- `.git/` — exposes your entire git history, source code, and secrets
- `node_modules/` — exposes installed packages and sometimes config files
- `.env` — exposes environment variables including database credentials and API keys
- `.htaccess` — Apache config file that may contain rewrite rules or credentials
- `composer.json`, `package.json` — exposes dependency lists and project metadata

---

# Where to put these rules

Nginx config files typically live at:

```bash
/etc/nginx/
```

The main config:

```bash
/etc/nginx/nginx.conf
```

Site-specific configs:

```bash
/etc/nginx/sites-available/your-site
/etc/nginx/sites-enabled/your-site
```

Put the blocking rules inside the `server {}` block for your site, in:

```bash
/etc/nginx/sites-available/your-site
```

After editing, always test before reloading:

```bash
sudo nginx -t
```

Then reload:

```bash
sudo systemctl reload nginx
```

---

# Block `.git`

```nginx
location ~ /\.git {
    deny all;
    return 403;
}
```

This blocks any request to `.git/`, `.git/config`, `.git/HEAD`, etc.

Without this, an attacker can download your entire repository:

```bash
git clone http://yoursite.com/.git/
```

---

# Block `node_modules`

```nginx
location ~ /node_modules {
    deny all;
    return 403;
}
```

---

# Block `.env` files

```nginx
location ~ /\.env {
    deny all;
    return 403;
}
```

This covers `.env`, `.env.local`, `.env.production`, etc.

---

# Block dotfiles broadly

A single rule can block all dotfiles and dotfolders (anything starting with a dot), except for the Certbot/Let's Encrypt challenge path:

```nginx
location ~ /\. {
    deny all;
    return 403;
}
```

> **Important:** If you use Let's Encrypt with the webroot method, the ACME challenge uses a dotfolder:
>
> ```text
> /.well-known/acme-challenge/
> ```
>
> Place the exception before the broad dotfile block:
>
> ```nginx
> location ~ /\.well-known {
>     allow all;
> }
>
> location ~ /\. {
>     deny all;
>     return 403;
> }
> ```

---

# Block `node_modules`, `vendor`, and other build/dependency folders

```nginx
location ~ /(node_modules|vendor|\.git|\.svn) {
    deny all;
    return 403;
}
```

---

# Block sensitive files by extension or name

```nginx
location ~* \.(env|log|sql|bak|backup|sh|conf|config|ini|lock)$ {
    deny all;
    return 403;
}
```

This blocks common file types that should never be served:

| Extension | Risk |
|-----------|------|
| `.env` | Credentials, API keys |
| `.log` | Server logs, error traces |
| `.sql` | Database dumps |
| `.bak` / `.backup` | Backup files with full content |
| `.sh` | Shell scripts |
| `.conf` / `.config` / `.ini` | App configuration |
| `.lock` | Composer/npm lockfiles exposing exact versions |

---

# Block `composer.json`, `package.json`, `package-lock.json`

```nginx
location ~* (composer\.(json|lock)|package(-lock)?\.json)$ {
    deny all;
    return 403;
}
```

---

# Full combined example

A practical block to add inside your `server {}`:

```nginx
# Block Let's Encrypt challenge (must come before the dotfile block)
location ~ /\.well-known {
    allow all;
}

# Block all dotfiles and dotfolders (.git, .env, .htaccess, etc.)
location ~ /\. {
    deny all;
    return 403;
}

# Block dependency and build folders
location ~ /(node_modules|vendor) {
    deny all;
    return 403;
}

# Block sensitive file types
location ~* \.(env|log|sql|bak|backup|sh|ini|lock)$ {
    deny all;
    return 403;
}
```

---

# Test and reload

After any edit, always test the config:

```bash
sudo nginx -t
```

Expected:

```text
nginx: the configuration file /etc/nginx/nginx.conf syntax is ok
nginx: configuration file /etc/nginx/nginx.conf test is successful
```

Then reload:

```bash
sudo systemctl reload nginx
```

---

# Verify it is working

Test that `.git` is blocked:

```bash
curl -I http://yoursite.com/.git/config
```

Expected:

```text
HTTP/1.1 403 Forbidden
```

Test that `.env` is blocked:

```bash
curl -I http://yoursite.com/.env
```

Expected:

```text
HTTP/1.1 403 Forbidden
```

---

# Why `deny all` and `return 403` together

`deny all` tells Nginx to reject the connection.  
`return 403` makes the response explicit.

In practice, `deny all` alone is sufficient — Nginx returns 403 automatically. Adding `return 403` makes the intent clear and ensures consistent behavior across Nginx versions.

---

# Important notes

- These rules only protect what Nginx serves. If your app has its own file-serving route that bypasses Nginx location blocks, you need to block those paths in your app as well.
- If you deploy with a CI/CD pipeline that places a `.git` folder on the server, these Nginx rules prevent web exposure but the folder still exists on disk. Consider excluding `.git` from deployments entirely using rsync exclude flags or a `.deployignore` equivalent.
- On shared hosting where you do not control Nginx directly, use the equivalent `.htaccess` rules for Apache instead.
