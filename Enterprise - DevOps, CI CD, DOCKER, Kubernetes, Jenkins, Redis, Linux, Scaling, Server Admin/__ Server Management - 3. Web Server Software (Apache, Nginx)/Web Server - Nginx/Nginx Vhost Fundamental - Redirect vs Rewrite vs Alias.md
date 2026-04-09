
Certainly! In Nginx, **redirect**, **rewrite**, and **alias** are directives used for different purposes in URL handling and resource mapping. Understanding the differences among them is crucial for configuring your web server effectively.

---

## **1. Redirect**

### **Definition**

A **redirect** tells the client (usually a web browser) to make a new request to a different URL. This is done by sending an HTTP status code (like 301 or 302) along with the new URL in the `Location` header of the HTTP response.

### **Implementation in Nginx**

In Nginx, redirects are typically implemented using the `return` or `rewrite` directives with a redirect status code.

### **Use Cases**

- **Changing URL Structure**: When you change the URL structure of your website and want to redirect old URLs to new ones.
- **Enforcing URL Formats**: Redirecting non-www to www URLs, or HTTP to HTTPS.
- **Temporary Redirects**: For maintenance or temporary resource relocation.

### **Examples**

**Using `return` Directive:**

```nginx
server {
    listen 80;
    server_name example.com;

    location /old-page {
        return 301 http://example.com/new-page;
    }
}
```

**Using `rewrite` Directive with Redirect:**

```nginx
rewrite ^/old-page$ /new-page permanent;
```

---

## **2. Rewrite**

### **Definition**

A **rewrite** modifies the URI of a request internally within Nginx, without notifying the client. The client is unaware that the URL has changed because the browser's address bar remains the same unless a redirect status is specified.

### **Implementation in Nginx**

The `rewrite` directive is used to change the URI. It can be applied with flags like `last`, `break`, `redirect`, or `permanent` to control the rewrite behavior.

### **Use Cases**

- **Internal URI Rewriting**: Mapping user-friendly URLs to internal scripts or resources.
- **Conditional Processing**: Changing the request URI based on certain conditions.
- **Access Control**: Redirecting unauthorized users to a login page internally.

### **Examples**

**Simple Internal Rewrite:**

```nginx
location / {
    rewrite ^/user/(.*)$ /index.php?user=$1 last;
}
```

**Conditional Rewrite:**

```nginx
if ($http_user_agent ~* "MSIE") {
    rewrite ^(.*)$ /msie.html break;
}
```

---

## **3. Alias**

### **Definition**

The **alias** directive maps a URI to a filesystem path. It tells Nginx to serve files from a directory that does not necessarily match the URI directly.

### **Implementation in Nginx**

The `alias` directive is placed inside a `location` block and specifies the physical path on the server that corresponds to the requested URI.

### **Use Cases**

- **Serving Static Files**: When the directory structure of your files doesn't match the URI structure.
- **Organizing Filesystem**: Keeping your web-accessible files in a different location from your web root.
- **Virtual Directories**: Serving files from multiple directories as if they are part of the same website.

### **Examples**

**Using `alias` to Serve Static Content:**

```nginx
location /images/ {
    alias /data/uploads/;
}
```

In this example, a request to `/images/picture.jpg` would serve the file located at `/data/uploads/picture.jpg`.

---

## **Comparison**

| Aspect            | Redirect                                            | Rewrite                                            | Alias                                                  |
|-------------------|-----------------------------------------------------|----------------------------------------------------|--------------------------------------------------------|
| **Purpose**       | Instructs client to request a different URL         | Changes URI internally within Nginx                | Maps URI to a different filesystem path                |
| **Client Aware**  | Yes (browser address bar changes)                   | No (unless used with redirect/permanent flags)     | Not applicable (affects file serving, not URI)         |
| **Use Cases**     | URL changes, site moves, URL normalization          | Internal routing, SEO-friendly URLs                | Serving files from directories outside the root        |
| **Implementation**| `return`, `rewrite` with redirect status codes      | `rewrite` directive                                | `alias` directive within a `location` block            |

---

## **Key Takeaways**

- **Redirect**: Use when you need the client to make a new request to a different URL. It's an external change, and the client is aware of it.
- **Rewrite**: Use for internal URL modifications within Nginx. The client remains unaware of the change unless you specify a redirect.
- **Alias**: Use when you need to map a URI to a different directory on the filesystem, especially when the directory structure doesn't match the URI structure.

---

## **Additional Notes**

- **`root` vs. `alias`**: While both are used to specify the directory from which files are served, `root` appends the URI to the specified path, whereas `alias` replaces the matched location prefix with the specified path.

  **Example with `root`:**

  ```nginx
  location /static/ {
      root /var/www/html/;
  }
  ```

  A request to `/static/css/style.css` serves `/var/www/html/static/css/style.css`.

  **Example with `alias`:**

  ```nginx
  location /static/ {
      alias /var/www/assets/;
  }
  ```

  A request to `/static/css/style.css` serves `/var/www/assets/css/style.css`.

- **Performance Considerations**: Internal rewrites are generally faster than redirects because they avoid an additional HTTP request from the client.

---

## **Conclusion**

Understanding when and how to use **redirect**, **rewrite**, and **alias** directives allows you to control URL behavior, resource mapping, and client interactions effectively in Nginx. By choosing the appropriate directive, you can optimize your web server's performance and provide a better experience for your users.

If you have any specific scenarios or need further clarification on any of these directives, feel free to ask!

---

## Rewrite vs Alias
Shown to user
- **`redirect`** changes the url in the address bar of the user's web browser.

Hidden from user
- **`alias`** is about **mapping URLs to different directories** on your server. It's particularly useful when your directory structure doesn't match your URL structure, allowing you to serve static content from any location on your filesystem.

- **`rewrite`** is about **modifying the request URI** that Nginx uses to process the request. It's a powerful tool for URL manipulation, redirection, and internal routing, but it doesn't directly change the filesystem paths where content is served from.

Q: When rewritten using rewrite, does the new internal route get matched by vhost?
A: URL rewrites do **NOT** change the virtual host (vhost) matching. The vhost is determined by the original request's `Host` header, not by the rewritten URL.

Q: Can my php parse the new internal route?
A: Yes
- **`$_SERVER['REQUEST_URI']`**: The original URI requested by the client.
- **`$_SERVER['SCRIPT_NAME']`**: The name of the script being executed after the rewrite.
- **`$_SERVER['QUERY_STRING']`**: Any query string passed along with the request, including those added during the rewrite.