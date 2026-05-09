An **Apache vhost**, also called a **virtual host**, tells Apache how to respond to a specific domain or hostname.

For example, if someone visits:

```text
example.com
```

Apache checks the request’s hostname through the browser’s `Host:` header and looks for a matching `ServerName` or `ServerAlias` in its config.

Your browser automatically sends the `Host:` header, so you usually do not set it manually.

Example Apache vhost:

```apache
<VirtualHost *:80>
    ServerName example.com
    ServerAlias www.example.com

    DocumentRoot /var/www/example.com/public_html

    <Directory /var/www/example.com/public_html>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/example.com-error.log
    CustomLog ${APACHE_LOG_DIR}/example.com-access.log combined
</VirtualHost>
```

The important lines are:

```apache
ServerName example.com
ServerAlias www.example.com
```

That tells Apache:

```text
When the request is for example.com or www.example.com, use this VirtualHost.
```

---

## Debian and Ubuntu: `sites-available` and `sites-enabled`

On Debian and Ubuntu servers, Apache site configs usually live in:

```text
/etc/apache2/sites-available/
```

You create or edit the vhost file there:

```bash
sudo vi /etc/apache2/sites-available/example.com.conf
```

Example config:

```apache
<VirtualHost *:80>
    ServerName example.com
    ServerAlias www.example.com

    DocumentRoot /var/www/example.com/public_html

    <Directory /var/www/example.com/public_html>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/example.com-error.log
    CustomLog ${APACHE_LOG_DIR}/example.com-access.log combined
</VirtualHost>
```

Then enable the site:

```bash
sudo a2ensite example.com.conf
```

The idea is similar to Nginx:

```text
sites-available = configs that exist
sites-enabled   = configs Apache actually loads
```

After that, test the Apache config:

```bash
sudo apache2ctl configtest
```

If the test passes, reload Apache:

```bash
sudo systemctl reload apache2
```

You may also see:

```bash
sudo apachectl graceful
```

or:

```bash
sudo apache2ctl graceful
```

These perform a graceful reload, meaning Apache reloads the config without abruptly killing active connections.

---

## AlmaLinux, Rocky Linux, and CentOS-Style Servers: `conf.d`

On AlmaLinux, Rocky Linux, CentOS, and similar systems, Apache is usually called **httpd**, not `apache2`.

Vhost configs are commonly placed in:

```text
/etc/httpd/conf.d/
```

Example:

```bash
sudo vi /etc/httpd/conf.d/example.com.conf
```

Example config:

```apache
<VirtualHost *:80>
    ServerName example.com
    ServerAlias www.example.com

    DocumentRoot /var/www/example.com/public_html

    <Directory /var/www/example.com/public_html>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog /var/log/httpd/example.com-error.log
    CustomLog /var/log/httpd/example.com-access.log combined
</VirtualHost>
```

Files inside:

```text
/etc/httpd/conf.d/
```

are usually included automatically by the main Apache config.

After editing, test the config:

```bash
sudo apachectl configtest
```

Then reload Apache:

```bash
sudo systemctl reload httpd
```

Or use a graceful reload:

```bash
sudo apachectl graceful
```

---

## `DocumentRoot` vs `Directory`

In Apache, these two parts work together:

```apache
DocumentRoot /var/www/example.com/public_html
```

This tells Apache where the website files are located.

Then this block controls permissions for that folder:

```apache
<Directory /var/www/example.com/public_html>
    AllowOverride All
    Require all granted
</Directory>
```

The line:

```apache
Require all granted
```

allows web visitors to access files in that directory.

The line:

```apache
AllowOverride All
```

allows `.htaccess` files to override some Apache settings. This is common for WordPress, Laravel, and many PHP apps.

For stricter performance and security, some production setups use:

```apache
AllowOverride None
```

and place all rules directly in the vhost config instead.

---

## Control Panels: cPanel, Plesk, and Similar Setups

If you are using a hosting control panel like **cPanel**, **WHM**, **Plesk**, or another managed hosting panel, you may not want to edit Apache config files directly.

The control panel may generate Apache configs for you.

Manual edits can be overwritten when the panel rebuilds its config.

In that case, use the panel’s domain, vhost, or Apache configuration tools instead.

---

## `systemctl reload` vs `apachectl graceful`

Both commands reload Apache, but they work slightly differently.

### Debian and Ubuntu

Use:

```bash
sudo systemctl reload apache2
```

or:

```bash
sudo apache2ctl graceful
```

### AlmaLinux, Rocky Linux, and CentOS

Use:

```bash
sudo systemctl reload httpd
```

or:

```bash
sudo apachectl graceful
```

`systemctl reload` asks the system service manager to reload Apache.

`apachectl graceful` tells Apache to reload its config gracefully, allowing existing requests to finish when possible.

A safe general workflow is:

```bash
sudo apachectl configtest
sudo systemctl reload apache2
```

On Red Hat-style systems, use:

```bash
sudo apachectl configtest
sudo systemctl reload httpd
```

---

## Summary

Use this general rule:

|Server Type|Common Apache Vhost Location|Service Name|
|---|---|---|
|Debian / Ubuntu|`/etc/apache2/sites-available/` and `/etc/apache2/sites-enabled/`|`apache2`|
|AlmaLinux / Rocky / CentOS|`/etc/httpd/conf.d/`|`httpd`|
|Control panels|Managed through the panel UI|Depends on the panel|

The main Apache vhost settings are usually:

```text
ServerName
ServerAlias
DocumentRoot
Directory permissions
ErrorLog
CustomLog
```

After editing an Apache vhost, always test first:

```bash
sudo apachectl configtest
```

Then reload Apache.

For Debian and Ubuntu:

```bash
sudo systemctl reload apache2
```

For AlmaLinux, Rocky Linux, and CentOS:

```bash
sudo systemctl reload httpd
```

Or use a graceful reload:

```bash
sudo apachectl graceful
```