### WP-CLI Introduction

`wp` (WordPress Command Line Interface, or WP-CLI) is a powerful tool that lets you manage WordPress from the terminal instead of the admin dashboard. You can perform tasks like:

- **Install core**: `wp core download` (downloads the latest WordPress files)
    
- **Manage plugins**: `wp plugin install <plugin-name> --activate`
    
- **Update WordPress**: `wp core update`
    
- **Database operations**: `wp db export`, `wp db import`
    
- **User management**: `wp user create`, `wp user delete`
    

It’s especially useful on servers and in automated deployments because it avoids manual clicking in wp-admin.


When managing your wordpress site through the cli, just make sure you're in the folder where your wp site is at.

---

### Installing WP-CLI

#### On macOS (using Homebrew)

```bash
brew install wp-cli
```

Verify installation:

```bash
wp --info
```

#### On Debian/Ubuntu Server

```bash
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
php wp-cli.phar --info
chmod +x wp-cli.phar
sudo mv wp-cli.phar /usr/local/bin/wp
```

Now you can run `wp` globally from the terminal:

```bash
wp --info
```
