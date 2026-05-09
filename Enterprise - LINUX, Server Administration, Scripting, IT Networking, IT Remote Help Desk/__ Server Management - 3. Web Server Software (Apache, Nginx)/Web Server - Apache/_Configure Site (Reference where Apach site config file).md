If you are using a hosting control panel like **cPanel**, **WHM**, **Plesk**, CloudPanel, or another managed hosting panel, you may not want to edit Apache or Nginx config files directly.

The control panel may generate the web server configs for you. Manual edits can be overwritten when the panel rebuilds its configuration.

In that case, use the panel’s domain, vhost, or web server configuration tools instead.

## Quick Reference: Where to Manage Web Server Configs

|Setup|Where to Manage It|Notes|
|---|---|---|
|Plain Apache on Debian/Ubuntu|`/etc/apache2/sites-available/`|Create/edit a `.conf` file, then enable it with `a2ensite`.|
|Plain Apache on AlmaLinux/Rocky/CentOS|`/etc/httpd/conf.d/`|Add a `.conf` file here. Files are usually included automatically.|
|Plain Nginx on Debian/Ubuntu|`/etc/nginx/sites-available/` and `/etc/nginx/sites-enabled/`|Create config in `sites-available`, then symlink it into `sites-enabled`.|
|Plain Nginx on AlmaLinux/Rocky/CentOS|`/etc/nginx/conf.d/`|Add a `.conf` file here. Files are usually included automatically.|
|cPanel / WHM|WHM/cPanel domain and Apache config tools|Avoid editing generated Apache files directly because WHM may overwrite them.|
|Plesk|Plesk domain hosting settings / Apache & Nginx settings|Use Plesk’s UI for per-domain web server directives.|
|CloudPanel|`CloudPanel → Sites → Your Site → Vhost`|Best place to edit Nginx vhost rules for a CloudPanel-managed site.|
|Managed shared hosting|Hosting panel’s domain settings|You may not have direct access to Apache/Nginx config files. Use the panel UI.|

A good rule of thumb:

```text
If you installed Apache yourself, edit the config files directly.

If a control panel manages the server, use the control panel first.
```