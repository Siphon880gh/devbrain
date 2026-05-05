
If you're looking for information on creating **Apache mod_rewrite rules** for matching and redirecting requests, here’s a concise guide:

### What is `mod_rewrite`?
Apache's `mod_rewrite` module allows you to perform advanced URL manipulations using rules defined in a `.htaccess` file or the Apache configuration.

---

### Basic Structure of a Rewrite Rule
```apache
RewriteEngine On
RewriteCond <condition>
RewriteRule <pattern> <substitution> [flags]
```

1. **`RewriteEngine On`**: Enables the mod_rewrite engine.
2. **`RewriteCond`**: Specifies a condition that must be true for the rule to execute (optional).
3. **`RewriteRule`**: Defines the pattern to match and how to rewrite it.

---

### Examples

#### **Simple Redirect**
Redirect a single URL to another.
```apache
RewriteEngine On
RewriteRule ^old-page\.html$ /new-page.html [L,R=301]
```
- **Explanation**:
  - `^old-page\.html$`: Matches `old-page.html`.
  - `/new-page.html`: Redirects to `new-page.html`.
  - `[L,R=301]`: Stops processing further rules and performs a 301 redirect (permanent).

---

#### **Match and Rewrite Dynamically**
Redirect URLs with a pattern to a PHP script or another URL.
```apache
RewriteEngine On
RewriteRule ^product/([0-9]+)/?$ product.php?id=$1 [L,QSA]
```
- **Explanation**:
  - `^product/([0-9]+)/?$`: Matches `product/123` or `product/123/`.
  - `$1`: Captures the matched number (e.g., `123`).
  - `product.php?id=$1`: Redirects to `product.php?id=123`.
  - `[L,QSA]`: Stops further processing (`L`) and appends query string arguments (`QSA`).

---

#### **Rewrite with Conditions**
Redirect only if a condition is met.
```apache
RewriteEngine On
RewriteCond %{HTTP_HOST} ^example\.com$ [NC]
RewriteRule ^(.*)$ https://www.example.com/$1 [L,R=301]
```
- **Explanation**:
  - `RewriteCond %{HTTP_HOST} ^example\.com$`: Matches requests to `example.com`.
  - `https://www.example.com/$1`: Redirects to `www.example.com` while preserving the original path (`$1`).

---

#### **Force HTTPS**
Redirect all HTTP traffic to HTTPS.
```apache
RewriteEngine On
RewriteCond %{HTTPS} !=on
RewriteRule ^(.*)$ https://%{HTTP_HOST}/$1 [L,R=301]
```
- **Explanation**:
  - `RewriteCond %{HTTPS} !=on`: Matches requests not using HTTPS.
  - Redirects to the same path but with `https://`.

---

#### **Remove or Add Trailing Slash**
1. **Remove Trailing Slash**:
   ```apache
   RewriteEngine On
   RewriteCond %{REQUEST_FILENAME} !-d
   RewriteRule ^(.*)/$ /$1 [L,R=301]
   ```
   - Removes the trailing slash unless the request is for a directory.

2. **Add Trailing Slash**:
   ```apache
   RewriteEngine On
   RewriteCond %{REQUEST_FILENAME} !-f
   RewriteRule ^(.*[^/])$ /$1/ [L,R=301]
   ```
   - Adds a trailing slash unless the request is for a file.

---

#### **Redirect Based on User-Agent**
```apache
RewriteEngine On
RewriteCond %{HTTP_USER_AGENT} (Googlebot|Bingbot) [NC]
RewriteRule ^(.*)$ https://bot.example.com/$1 [L,R=302]
```
- Redirects requests from specific bots to a different subdomain.

---

### Flags Cheat Sheet
- **`L`**: Last rule; stop further processing.
- **`R=301`**: Redirect with a status code (301 = permanent).
- **`QSA`**: Append query string arguments.
- **`NC`**: Case-insensitive match.
- **`OR`**: Logical OR for conditions.
- **`NE`**: No escape; special characters remain in the URL.

---

### Testing Tips
- Use tools like [https://htaccess.madewithlove.com](https://htaccess.madewithlove.com) to test `.htaccess` rules.
- Enable Apache logging:
  ```apache
  LogLevel alert rewrite:trace3
  ```
  Check the logs for debugging.

Let me know if you have a specific rule or scenario you'd like help with!