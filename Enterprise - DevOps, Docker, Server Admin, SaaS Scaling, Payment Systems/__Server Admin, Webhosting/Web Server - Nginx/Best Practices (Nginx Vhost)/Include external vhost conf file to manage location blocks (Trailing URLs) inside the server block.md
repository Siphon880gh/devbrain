Titled: Include external vhost conf file to manage location blocks (Trailing URLs) inside the server block

Purpose:
You have multiple trailing urls like /app/app1, /app/app2, /app/app3, etc and they each may have different VHost settings. For example, /app/app1 needs proxy passing to the PHP :8080, /app/app2 needs reverse proxying into Python Flask at 5001,  /app/app3 needs reverse proxying into Node Express at 3001. Instead of modifying the vhost at your website, you should have that vhost refer (using the include directive) to another vhost conf file that deals exclusively with these location blocks for /app/app1, /app/app2, /app/app3, etc. This makes sure the website's vhost is clean and you can manage the urls at another file.

You could have a folder like eco/ that deals with these referred/included vhost files, and other files related to managing global affairs of your server (pm2 ecosystem.config.js, supervisor/ folder containing symbolic links to supervisor main config file and supervisor app config files). FYI, pm2 ecosystem.config.js is to manage multiple NodeJS Express apps at different 300X ports; supervisor used to run .sh files which runs gunicorn shell commands which can scale Python Flask apps at different 500X ports.

---


Using the `include` directive inside a `server` block to manage `location` blocks from separate configuration files is a highly practical approach. It allows for modular, reusable, and cleaner configurations, especially for complex setups with multiple `location` directives.

---

### **Why Include `location` Blocks from Another File?**

1. **Modularity**: Separates concerns and makes managing specific configurations easier.
2. **Reusability**: Common `location` block settings (e.g., caching, headers, or proxy rules) can be reused across multiple server blocks.
3. **Simplifies Maintenance**: Reduces clutter in the main `server` block, making it more readable and maintainable.
4. **Collaboration**: Allows different team members to work on different configuration files simultaneously.

---

### **Example: Using `include` for `location` Blocks**

#### Main Server Block (`/etc/nginx/sites-available/example.com`):

```
server {
    listen 80;
    server_name example.com;

    # Global settings for this server
    root /var/www/example;
    index index.html;

    # Include location-specific configurations
    include /etc/nginx/server-configs/example-locations.conf;
}
```

#### Included File (`/etc/nginx/server-configs/example-locations.conf`):

```
location / {
    proxy_pass http://backend;
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
}

location /static/ {
    alias /var/www/example/static/;
    expires 30d;
    access_log off;
}

location /api/ {
    proxy_pass http://api-backend;
    proxy_set_header Host $host;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
}
```

---

### **Benefits in This Setup**

1. **Simplified `server` Block**: The `server` block only contains high-level configurations, while specific `location` blocks are moved elsewhere.
2. **Reuse Across Servers**: If another domain needs the same `location` configuration, simply include the same file.
    
    ```
    include /etc/nginx/server-configs/example-locations.conf;
    ```
    
3. **Easier Debugging**: Isolating `location` configurations in a separate file helps pinpoint issues faster.