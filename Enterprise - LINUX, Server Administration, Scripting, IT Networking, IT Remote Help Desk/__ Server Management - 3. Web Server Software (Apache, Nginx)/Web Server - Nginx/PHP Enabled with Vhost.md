## ✅ How to Enable PHP Support in NGINX (Standard and CloudPanel)

NGINX is a powerful, high-performance web server—but it doesn’t process PHP by itself. To serve PHP websites or apps, you’ll need to forward PHP requests to **PHP-FPM**, a service that runs PHP scripts efficiently in the background.

This guide shows how to:

- Enable PHP in a standard NGINX setup
- Handle Let’s Encrypt ACME validation
- Configure your PHP site to run properly
- Apply a CloudPanel-specific configuration (if you're using CloudPanel)

---

## 🔧 Prerequisites

You have **two options** depending on how your server is set up:

### ✅ Option 1: You're using CloudPanel (Recommended)

If you're hosting on [CloudPanel](https://www.cloudpanel.io/), you're already set up:

- When creating a new **PHP App**, CloudPanel automatically installs and configures PHP-FPM.
- The web root, index file, permissions, and FastCGI are preconfigured.
- You can skip the manual NGINX PHP configuration in this article (unless you’re customizing or debugging).

### ⚙️ Option 2: You're setting up NGINX manually

Install NGINX and PHP-FPM (FastCGI Process Manager):

```bash
sudo apt update
sudo apt install nginx php-fpm
```

> **What is PHP-FPM?**  
> PHP-FPM (FastCGI Process Manager) is a background service that runs PHP code. NGINX can’t execute PHP directly, so it forwards `.php` requests to PHP-FPM, which processes them and returns the result to NGINX.

Check your PHP version:

```bash
php -v
```

Make sure your version's FPM service is running (e.g., `php8.1-fpm`):

```bash
sudo systemctl status php8.1-fpm
```

---

## 📁 Folder Structure (Recommended)

```
/var/www/domain.com/
└── public/
    ├── index.php
    └── ...
```

The NGINX config should point to the `public` folder.

---

## 🛠️ NGINX Configuration for PHP

Here’s a minimal, secure NGINX config that supports PHP:

```nginx
server {
  listen 80;
  listen [::]:80;

  server_name domain.com;

  root /var/www/domain.com/public;
  index index.php index.html;

  # Redirect HTTP to HTTPS (optional)
  if ($scheme != "https") {
    return 301 https://$host$request_uri;
  }

  # Let’s Encrypt ACME challenge (used for SSL issuance)
  location ~ /.well-known/acme-challenge {
    allow all;
    root /var/www/domain.com/public;
  }

  # Pass PHP files to PHP-FPM
  location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php8.1-fpm.sock;  # Adjust for your PHP version
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
  }

  # Deny access to sensitive system files
  location ~ /\.(ht|svn|git) {
    deny all;
  }
}
```

---

## 🚀 Test PHP Output

Create a quick test file:

```bash
echo "<?php phpinfo(); ?>" | sudo tee /var/www/domain.com/public/info.php
```

Then visit:

```
http://domain.com/info.php
```

You should see the PHP info page. Don’t forget to delete it after testing:

```bash
sudo rm /var/www/domain.com/public/info.php
```

---

## 🔄 Optional: Caching/Proxy on Port 8080 (CloudPanel Internal)

If you're on CloudPanel, your PHP site may also be routed through an internal **port 8080** caching layer. This internal NGINX block is managed automatically but looks like this under the hood:

```nginx
server {
  listen 8080;
  listen [::]:8080;

  server_name domain.com;

  root /home/USER/htdocs/domain.com/app/appdir;
  client_max_body_size 512M;

  location ~ \.php(.*)$ {
    include fastcgi_params;
    fastcgi_intercept_errors on;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name$1;
    try_files $uri =404;
    fastcgi_read_timeout 3600;
    fastcgi_send_timeout 3600;
    fastcgi_param HTTPS "on";
    fastcgi_param SERVER_PORT 443;
    fastcgi_pass 127.0.0.1:PORT_NUMBER;
    fastcgi_param PHP_VALUE "custom_php_settings_if_any";
  }

  try_files $uri $uri/ /index.php?$args;
  index index.php index.html;

  if (-f $request_filename) {
    break;
  }
}
```

> You typically don’t need to edit this unless troubleshooting caching behavior.

---

## ✅ Summary

- NGINX doesn’t run PHP by default—it needs to pass requests to PHP-FPM.
- PHP-FPM (FastCGI Process Manager) runs your PHP scripts and sends the output back to NGINX.
- CloudPanel automates PHP setup when you create a "PHP App".
- Manual setups require a `location ~ \.php$` block and the correct socket or port.
- Some CloudPanel setups include a port 8080 caching layer—good to know when debugging.

Let me know if you’d like a printable checklist or sample config for Laravel or WordPress setups!