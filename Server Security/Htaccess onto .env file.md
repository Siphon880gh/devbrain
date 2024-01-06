Hide .env from being directly accessed in the web browser URL!

.htaccess:
```
# Disable index view  
Options -Indexes  
  
# Hide a specific file  
<Files .env>  
    Order allow,deny  
    Deny from all  
</Files>
```

Notice the key here is "Files .env"