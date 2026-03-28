Say you need domain.com/abc/wp/privacy-policy to work (You've enabled permalink to be rewritten to an url-slugified post name, likely through the Classic Editor plugin)

Because you're not on nginx, Wordpress doesn't automatically take care of this for you. Here's the code to add to your server block that listens for 80 and 443. Add it after root pathing:

```

# ===================== WORDPRESS under /abc/wp =====================
# Normalize no-trailing-slash to trailing slash
location = /abc/wp { return 301 /abc/wp/; }

# One DRY block for all of /abc/wp/*
location ^~ /abc/wp/ {
    index index.php;
    try_files $uri $uri/ /abc/wp/index.php?$args;

    # Handle PHP under /abc/wp/*
    location ~ \.php$ {
        include fastcgi_params;   # or fastcgi.conf if that's your distro
        fastcgi_param SCRIPT_FILENAME /home/wengindustries/htdocs/wengindustries.com$fastcgi_script_name;
        fastcgi_param QUERY_STRING $query_string;
        fastcgi_pass 127.0.0.1:{{php_fpm_port}};   # or unix:/run/php/php8.2-fpm.sock
        fastcgi_read_timeout 300;
    }

    # Block PHP inside uploads and includes for security
    location ~ ^/abc/wp/(wp-content/uploads|wp-includes)/.*\.php$ {
        deny all;
    }
    
    # Harden: block PHP in uploads/includes
    location ~ ^/abc/wp/(wp-content|wp-includes)/.*\.php$ { deny all; }

}
```