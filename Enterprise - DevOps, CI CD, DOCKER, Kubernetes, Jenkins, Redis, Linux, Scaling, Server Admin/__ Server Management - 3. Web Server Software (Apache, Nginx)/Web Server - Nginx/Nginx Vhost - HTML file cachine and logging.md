
```
location ~* \.(html|htm)$ {  
    expires 1h;  # Cache HTML files for 1 hour  
    access_log on;  # Enable logging for HTML files  
}
```

### Location Block
```nginx
location ~* \.(html|htm)$ {
```
- **location ~* \.(html|htm)$**: This line defines a location block that matches requests for HTML or HTM files.
  - **location**: Specifies a location block in NGINX configuration.
  - **~***: Indicates a case-insensitive regular expression match.
  - **\.(html|htm)$**: The regular expression that matches any file ending with .html or .htm. The **\\.** ensures that the dot is treated literally, **(html|htm)** matches either "html" or "htm", and **$** denotes the end of the string.

### Cache Expiration
```nginx
    expires 1h;  # Cache HTML files for 1 hour
```
- **expires 1h;**: This directive sets the caching time for matched files.
  - **expires**: Configures the expiration time for the files.
  - **1h**: Specifies that the files should be cached for 1 hour. After this time, the browser will request a new version of the file from the server.

### Access Logging
```nginx
    access_log on;  # Enable logging for HTML files
```
- **access_log on;**: This directive enables access logging for the matched files.
  - **access_log**: Manages the access logs in NGINX.
  - **on**: Turns on access logging for these requests.

---

In Ubuntu 22.04, the default location for NGINX access logs is usually `/var/log/nginx/access.log`. However, this can be configured differently in your NGINX configuration files.

To verify or change the log file location, you can check the NGINX configuration file. Here’s how you can find out where the logs go:

1. **Default Log File Location**: By default, NGINX logs are stored in the following files:
   - Access logs: `/var/log/nginx/access.log`
   - Error logs: `/var/log/nginx/error.log`

2. **Check NGINX Configuration**: Open the main NGINX configuration file (usually located at `/etc/nginx/nginx.conf`) or any other configuration files included within it (like those in `/etc/nginx/conf.d/` or `/etc/nginx/sites-enabled/`).

   You can use a command-line text editor like `nano` or `vim` to open the file:
   ```bash
   sudo nano /etc/nginx/nginx.conf
   ```

3. **Look for `access_log` Directive**: Search for the `access_log` directive to see the path defined for the access logs.
   ```nginx
   access_log /var/log/nginx/access.log;
   ```

4. **Custom Log File Locations**: If the logs are set to go to a custom location, it will be specified in the configuration files. For example:
   ```nginx
   access_log /custom/path/to/access.log;
   ```

If the `access_log` directive is not explicitly defined within your specific location block, NGINX will use the global `access_log` settings defined in the main configuration file.

### Example
Here is an example of what the relevant section in the NGINX configuration might look like:
```nginx
http {
    log_format main '$remote_addr - $remote_user [$time_local] "$request" '
                      '$status $body_bytes_sent "$http_referer" '
                      '"$http_user_agent" "$http_x_forwarded_for"';

    access_log /var/log/nginx/access.log main;

    server {
        location ~* \.(html|htm)$ {
            expires 1h;
            access_log on;
        }
    }
}
```
In this example, the access logs will be written to `/var/log/nginx/access.log`.

To view the logs, you can use the `cat`, `less`, or `tail` commands:
```bash
cat /var/log/nginx/access.log
```
or to follow the log entries in real-time:
```bash
tail -f /var/log/nginx/access.log
```

This should help you locate where the logs are being stored on your Ubuntu 22.04 system.