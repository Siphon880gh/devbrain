## Quick Reference: Where to Manage Nginx Configs

|Setup|Where to Manage It|Notes|
|---|---|---|
|Plain Nginx on Debian/Ubuntu|`/etc/nginx/sites-available/` and `/etc/nginx/sites-enabled/`|Create the vhost config in `sites-available`, then enable it by symlinking it into `sites-enabled`.|
|Plain Nginx on AlmaLinux/Rocky/CentOS|`/etc/nginx/conf.d/`|Add a `.conf` file here. Files are usually included automatically by the main Nginx config.|
|CloudPanel|`CloudPanel → Sites → Your Site → Vhost`|Best place to edit Nginx vhost rules for a CloudPanel-managed site. Avoid editing generated files directly unless you know the panel will not overwrite them.|
|Plesk|`Plesk → Domains → Your Domain → Apache & Nginx Settings`|Use Plesk’s UI for per-domain Nginx directives. Plesk may regenerate server configs.|
|cPanel / WHM with Nginx enabled|WHM/cPanel Nginx or reverse proxy tools|cPanel is traditionally Apache-based, but some setups use Nginx as a reverse proxy. Use WHM/cPanel tools instead of editing generated configs directly.|
|Managed shared hosting|Hosting panel’s domain settings|You may not have direct access to Nginx config files. Use the hosting provider’s panel UI.|
|Dockerized Nginx|Your project’s `nginx.conf`, mounted config folder, or Docker Compose volume|The config may live inside the project instead of `/etc/nginx/`. Check `docker-compose.yml` or container volume mounts.|
|Nginx Proxy Manager|Nginx Proxy Manager web UI|Manage proxy hosts, SSL, redirects, and access rules through the UI instead of editing Nginx files manually.|

A good rule of thumb:

```text
If you installed Nginx yourself, edit the config files directly.

If a control panel manages Nginx, use the control panel first.

If Nginx runs inside Docker, check the project config or mounted volumes.
```