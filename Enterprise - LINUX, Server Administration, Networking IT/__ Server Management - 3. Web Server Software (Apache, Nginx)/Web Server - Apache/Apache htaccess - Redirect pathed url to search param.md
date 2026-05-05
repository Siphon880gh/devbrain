While clicking links in a React SPA will change the url to paths like localhost:3000/pathA/pathB, users might bookmark the page when in production, and visiting that path going 404 means you have a SPA that does not prerender a build for public. It's also bad for SEO because the crawler may visit those pathed urls and bounce back, marking your website as suspicious and downranking you. Your solution is to build a script that prerenders those htmls in folders that make up the /pathA/pathB, or switching to another tech stack that can support prerendered pages (Like NextJS)

If those approaches are not immediately available to you, then a quick fix (wont fix SEO, but it'll fix users visiting bookmarked): Have at the react client side at the entry point or close to the entry point check for the search param "page" and if it exists, then it can navigate to the proper React Router Dom route or trigger clicking a specific button or nav item to open the page. This means at your nginx or apache level, it hits the URL path like /pathA/pathB, then it should redirect to ?page=pathA/pathB, then your react app can handle the rendering.

Add to the root apache .htaccess:
```
RewriteEngine On  
  
RedirectMatch "(?i)(.*)me/(tech)" "http://localhost:8888/weng/me?page=$2"  
RedirectMatch "(?i)(.*)me/(whoami)" "http://localhost:8888/weng/me?page=$2"  
RedirectMatch "(?i)(.*)me/(resume)" "http://localhost:8888/weng/me?page=$2"  
RedirectMatch "(?i)(.*)me/(work)" "http://localhost:8888/weng/me?page=$2"  
RedirectMatch "(?i)(.*)me/(collab)" "http://localhost:8888/weng/me?page=$2"  
RedirectMatch "(?i)(.*)me/(credited)" "http://localhost:8888/weng/me?page=$2"  
RedirectMatch "(?i)(.*)me/(contact)" "http://localhost:8888/weng/me?page=$2"  
RedirectMatch "(?i)(.*)me/(testimonials)" "http://localhost:8888/weng/me?page=$2"  
RedirectMatch "(?i)(.*)me/(students)" "http://localhost:8888/weng/me?page=$2"  
RedirectMatch "(?i)(.*)me/(achievements#top-marks)$" "http://localhost:8888/weng/me?page=$2"  
RedirectMatch "(?i)(.*)me/(achievements)$" "http://localhost:8888/weng/me?page=$2"  
RedirectMatch "(?i)(.*)me/(certs)" "http://localhost:8888/weng/me?page=certs"  
RedirectMatch "(?i)(.*)me/(certificates)" "http://localhost:8888/weng/me?page=certs"
```

This is equivalent to nginx vhost:
```
    # Handle static files first  
    location ~* ^/me/(.+)\.(css|js|png|jpg|jpeg|gif|ico|pdf|svg|woff|woff2|ttf|eot)$ {  
        # root /me/dist/assets; # Adjust the path to your static file directory  
        expires max;  
        log_not_found off;  
    }  
      
    # Redirect /me/<something> to /?page=<something> because there's no prerendered pages  
    location ~ ^/me/(.+)$ {  
        return 301 /me/?page=$1;  
    }  
      
    location ~ ^/me/php-react-mixin/(.*) {  
          
        fastcgi_intercept_errors on;  
        proxy_intercept_errors on;   
          
        {{varnish_proxy_pass}}  
        proxy_set_header Host $http_host;  
        proxy_set_header X-Forwarded-Host $http_host;  
        proxy_set_header X-Real-IP $remote_addr;  
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;  
        proxy_hide_header X-Varnish;  
        proxy_redirect off;  
        proxy_max_temp_file_size 0;  
        proxy_connect_timeout      720;  
        proxy_send_timeout         720;  
        proxy_read_timeout         720;  
        proxy_buffer_size          128k;  
        proxy_buffers              4 256k;  
        proxy_busy_buffers_size    256k;  
        proxy_temp_file_write_size 256k;  
    }
```