
Warning: This does not work in .htaccess. You have to edit apache config file.

Here's a breakdown of how to set up logging for `mod_rewrite` depending on the version of Apache:

---

Reference

For where the log files are, refer to [[Apache log level]]

---

## **Apache 2.4 and Later**

In Apache 2.4+, you can use the `LogLevel` directive to configure detailed logging specifically for `mod_rewrite`.

### Steps:

1. **Set the Global Logging Level:** This controls the general logging verbosity for the server:
    
    ```apache
    LogLevel warn
    ```
    
2. **Set Specific Logging for `mod_rewrite`:** You can add module-specific log levels:
    
    ```apache
    LogLevel alert rewrite:trace3
    ```
    
    - `alert` is the global level (logs critical issues server-wide).
    - `rewrite:trace3` enables detailed tracing specifically for the `mod_rewrite` module.
3. **For Source-File Specific Logging (Optional):** If you want to debug a specific part of `mod_rewrite` code:
    
    ```apache
    LogLevel warn mod_rewrite.c:trace4
    ```
    
4. **Restart Apache:** Apply the changes:
    
    ```bash
    sudo systemctl restart apache2
    ```
    
5. **Check Logs:** Logs will be written to the default `ErrorLog` location (e.g., `/var/log/apache2/error.log`).
    

---

## **Apache 2.2 and Older**

Apache 2.2 and earlier do not support module-specific `LogLevel` or `trace` levels. Instead, you must use `RewriteLog` and `RewriteLogLevel` for `mod_rewrite` debugging.

### Steps:

1. **Enable Debug Logging Globally (Optional):** If you want to log more details globally:
    
    ```apache
    LogLevel debug
    ```
    
2. **Enable Rewrite Logging:** Add the following to your Apache configuration:
    
    ```apache
    RewriteLog "/var/log/apache2/rewrite.log"
    RewriteLogLevel 3
    ```
    
    - **`RewriteLog`**: Specifies the path to the rewrite log file (ensure the directory is writable by Apache).
    - **`RewriteLogLevel`**: Controls verbosity (1 = minimal, 9 = most verbose). Start with 3 for moderate detail.
3. **Create the Log File:** If the specified file does not exist, create it and ensure appropriate permissions:
    
    ```bash
    sudo touch /var/log/apache2/rewrite.log
    sudo chmod 644 /var/log/apache2/rewrite.log
    ```
    
4. **Restart Apache:** Apply the changes:
    
    ```bash
    sudo /etc/init.d/apache2 restart
    ```
    
5. **Check Logs:** View the rewrite-specific logs:
    
    ```bash
    tail -f /var/log/apache2/rewrite.log
    ```
    

---

### Comparison Table by Apache Version

|Feature|Apache 2.4+|Apache 2.2 and Older|
|---|---|---|
|Global Logging|`LogLevel`|`LogLevel`|
|Module-Specific Logging|`LogLevel rewrite:trace3`|Not supported|
|Source-File Specific Logging|`LogLevel mod_rewrite.c:trace4`|Not supported|
|Rewrite-Specific Logging|Handled by `LogLevel`|`RewriteLog` and `RewriteLogLevel`|
|Log Trace Level Control|`trace1` to `trace8`|`RewriteLogLevel 1` to `9`|

---

### Example Configurations

#### **For Apache 2.4+**

```apache
LogLevel warn
LogLevel alert rewrite:trace3
```

#### **For Apache 2.2 and Older**

```apache
LogLevel debug
RewriteLog "/var/log/apache2/rewrite.log"
RewriteLogLevel 3
```

---

### Key Notes

1. In Apache 2.4+, `RewriteLog` is deprecated; use `LogLevel`.
2. In Apache 2.2 and older, you must explicitly define a `RewriteLog` path and verbosity.
3. Always monitor log sizes, especially with high verbosity levels (`trace` or `RewriteLogLevel > 3`), to avoid storage issues.

Would you like help testing or troubleshooting specific configurations?