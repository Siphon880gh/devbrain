An **Nginx vhost**, also called a **virtual host** or **server block**, tells Nginx how to respond to a specific domain or hostname.

For example, if someone visits:

```text
example.com
```

Nginx checks the request’s hostname and looks for a matching `server_name` in its config.

Example:

```nginx
server {
    listen 80;
    listen [::]:80;

    server_name example.com www.example.com;

    root /home/example/htdocs/example.com;
    index index.html;
}
```

The important line is:

```nginx
server_name example.com www.example.com;
```

That tells Nginx:

```text
When the request is for example.com or www.example.com, use this server block.
```

Your browser automatically sends the hostname in the `Host:` header, so you usually do not manually set the `Host:` header yourself.

---

## Debian and Ubuntu: `sites-available` and `sites-enabled`

On Debian and Ubuntu servers, Nginx site configs usually live in:

```text
/etc/nginx/sites-available/
```

You create or edit the vhost file there:

```bash
sudo vi /etc/nginx/sites-available/example.com
```

Example config:

```nginx
server {
    listen 80;
    listen [::]:80;

    server_name example.com www.example.com;

    root /home/example/htdocs/example.com;
    index index.html;
}
```

Then enable the site by creating a symlink into:

```text
/etc/nginx/sites-enabled/
```

Example:

```bash
sudo ln -s /etc/nginx/sites-available/example.com /etc/nginx/sites-enabled/
```

The idea is:

```text
sites-available = configs that exist
sites-enabled   = configs Nginx actually loads
```

After that, test the Nginx config:

```bash
sudo nginx -t
```

If the test passes, reload Nginx:

```bash
sudo systemctl reload nginx
```

You may also see this reload command:

```bash
sudo nginx -s reload
```

That also reloads Nginx, but `systemctl reload nginx` is usually preferred on systemd-based servers because it reloads Nginx through the service manager.

---

## AlmaLinux, Rocky Linux, and CentOS-Style Servers: `conf.d`

On AlmaLinux, Rocky Linux, CentOS, and similar systems, Nginx configs are often placed in:

```text
/etc/nginx/conf.d/
```

Example:

```bash
sudo vi /etc/nginx/conf.d/example.com.conf
```

Example config:

```nginx
server {
    listen 80;
    listen [::]:80;

    server_name example.com www.example.com;

    root /home/example/htdocs/example.com;
    index index.html;
}
```

Files inside:

```text
/etc/nginx/conf.d/
```

are usually included automatically by the main Nginx config.

After editing, test and reload:

```bash
sudo nginx -t
sudo systemctl reload nginx
```

Or:

```bash
sudo nginx -t
sudo nginx -s reload
```

---

## CloudPanel: Edit the Vhost in the UI

If you are using **CloudPanel**, you usually should not edit the generated Nginx files directly.

Instead, edit the site’s vhost from the CloudPanel dashboard:

```text
CloudPanel → Sites → Your Site → Vhost
```

From there, you can add or adjust settings such as:

```text
server_name
root
location blocks
proxy_pass rules
rewrite rules
cache rules
```

CloudPanel manages the underlying Nginx config for you, so manual edits to generated files may be overwritten later.

---

## `systemctl reload nginx` vs `nginx -s reload`

Both commands can reload Nginx, but they work slightly differently.

### Recommended on most Linux servers

```bash
sudo systemctl reload nginx
```

This asks systemd to reload the Nginx service.

Use this on most Debian, Ubuntu, AlmaLinux, Rocky Linux, and CentOS-style servers.

### Also common

```bash
sudo nginx -s reload
```

This sends a reload signal directly to the running Nginx master process.

It works on many systems, but it depends on the Nginx binary, config path, and PID file being where the command expects them to be.

So the safest general habit is:

```bash
sudo nginx -t
sudo systemctl reload nginx
```

If you are managing Nginx manually, inside a container, or without systemd, then this may be more appropriate:

```bash
sudo nginx -t
sudo nginx -s reload
```

---

## Summary

Use this general rule:

|Server Type|Common Vhost Location|
|---|---|
|Debian / Ubuntu|`/etc/nginx/sites-available/` and `/etc/nginx/sites-enabled/`|
|AlmaLinux / Rocky / CentOS|`/etc/nginx/conf.d/`|
|CloudPanel|`CloudPanel → Sites → Your Site → Vhost`|

The main vhost settings are usually:

```text
server_name
root
index
location blocks
proxy_pass rules, if using a reverse proxy
```

After editing an Nginx vhost, always run:

```bash
sudo nginx -t
```

Then reload using one of these:

```bash
sudo systemctl reload nginx
```

or:

```bash
sudo nginx -s reload
```

For most normal Linux servers, prefer:

```bash
sudo systemctl reload nginx
```