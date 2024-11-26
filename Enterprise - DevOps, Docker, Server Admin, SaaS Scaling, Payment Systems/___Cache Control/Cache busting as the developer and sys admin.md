
Make sure “Disable cache” isn’t enabled
![](https://i.imgur.com/izgc4R1.png)


When you refresh the page, do not refresh with DevTools (Console, Elements, etc) visible


---

**Clicking back**

When going back, the user clicking Back and seeing the same way the page was left, that's not the traditional **HTTP cache**, which is about storing assets like CSS, JavaScript, and images to load pages faster. Instead, it is more about the **browser's session history management** and how it preserves the exact state of the page when navigating back.

In any case, if working with forms, it is good practice for forms to be submitted via POST, and for the server to respond to the POST by **redirecting** (HTTP 302) to the next page, instead of programmatically rendering the next page directly. By issuing the redirect with the POST 302, any attempt by the user to go back will ask him/her to confirm whether they really want the form resubmitted for a second time.  

---

**HTML:**  

```
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
```

  

They can only provide some basic caching-related directives to browsers using the `<meta>` tag, but these are not as effective or reliable as actual HTTP headers set by the server. If an HTTP caching header contradicts a meta tag, the HTTP header will almost always take precedence. Meta tags do not cache assets like images, CSS ,or Javascript but it could help cache the HTML document, particularly on older web browsers (Newer web browsers have moved away from meta tags for caching)

It doesn’t hurt to include HTML cache busting meta tags (except if you want user to click Back button and retain state on some older web browsers - newer web browsers will retain state regardless when navigating back):

- Limited to Certain Browsers and Versions: Meta caching tags (`<meta http-equiv="Cache-Control">` and similar) are not part of modern web standards for caching. Some older browsers or specific configurations might honor these meta tags, but most modern browsers prioritize HTTP headers over meta tags.
- Only Affects the Current Document: These tags only influence the document in which they are defined. They cannot apply to other resources (like images, stylesheets, or scripts) linked from the document.
- Back Button and Reload Behavior: Some browsers may use meta caching tags to influence how they handle the back button or reload behavior. For example: `<meta http-equiv="Cache-Control" content="no-cache"> might force the browser to revalidate or reload the page when the user presses the back button.` 
- Dynamic Content or Sensitive Pages: For sensitive content (e.g., bank pages), a `<meta>` tag like `<meta http-equiv="Cache-Control" content="no-store">` might help ensure that the browser does not store a local copy of the page. However, again, this is not guaranteed and depends on browser implementation.

This is only useful for managing behavior in older or non-standard-compliant browsers where meta tags might still have some effect. For sensitive content (e.g., bank pages), a `<meta>` tag like `<meta http-equiv="Cache-Control" content="no-store">` might help ensure that the browser does not store a local copy of the page. However, again, this is not guaranteed and depends on browser implementation.  

---

**PHP:**

```
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache"); 
```

- Or a reasonable age of 1 hour:

```
header("Cache-Control: max-age=3600, public");
```


For more information on PHP vs Nginx/Apache headers (Yes PHP can override Nginx or Apache because it’s the last point before the client receives the files), refer to [[PHP cache headers vs Apache or Nginx cache headers]]

---

**SERVER SIDE**

When reverse proxying OR proxying to PHP interpreter:

**`proxy_cache`** is typically used in conjunction with **`proxy_pass`**. The `proxy_pass` directive specifies the upstream (backend) server that NGINX will forward client requests to, and `proxy_cache` enables caching for the responses received from that upstream server.

When used together, they create a setup where NGINX acts as a caching proxy. Here’s how they work together:

```
        proxy_pass https://127.0.0.1:5002;
        proxy_cache off;
```

---

**SERVER SIDE**

Here you can comment on/off depending if you want cache busting or cache sticky (but note not caching hurts loading performance).

That one line is saying an alternative service https3 (instead of http2) is supported on port 443 with m.a. max age of 86400 seconds = 24 hours which means it’ll be remembered for 24 hours that the service exists

```
  # Caching Static Assets
  location ~* ^.+\.(css|js|jpg|jpeg|gif|png|ico|gz|svg|svgz|ttf|otf|woff|woff2|eot|mp4|ogg|ogv|webm|webp|zip|swf|map|mjs)$ {
    add_header Access-Control-Allow-Origin "*";
    add_header alt-svc 'h3=":443"; ma=86400'; # Notified of http3 support for the next 24h
    access_log off;
    
    add_header Cache-Control "no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0";
    expires 0;

    # For swiching back to sticky cache
    # add_header Cache-Control "public, max-age=31536000, immutable";
    # expires max; # `expires max` or `expires 1y`
  }
```

Btw Apache is similar to the above, like::

```
<FilesMatch "\.(html|css|js|png|jpg|gif|svg|woff|woff2|ttf|eot|ico)$">
    Header set Cache-Control "max-age=3600, public"
</FilesMatch>
```


For more information on PHP vs Nginx/Apache headers (Yes PHP can override Nginx or Apache because it’s the last point before the client receives the files), refer to [[PHP cache headers vs Apache or Nginx cache headers]]  

Note it’s not enough to have just expiration. You need both expiration and no-cache, otherwise the web browser will heuristically follow their own caching strategy (which is inconsistent between web browsers).

---

But don’t cache the **service workers**!

```
  # Disable caching for service worker files
  location ~* /.*sw\.js$ {
      add_header Cache-Control "no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0";
      add_header Pragma "no-cache";
      add_header alt-svc 'h3=":443"; ma=86400';
      expires -1;
  }
  location ~* /.*service-worker\.js$ {
      add_header Cache-Control "no-store, no-cache, must-revalidate, proxy-revalidate, max-age=0";
      add_header Pragma "no-cache";
      add_header alt-svc 'h3=":443"; ma=86400';
      expires -1;
  }
```

  
---

*Appendix: More info on Alt-SVC*

The **`Alt-Svc`** header with `ma=86400` (24 hours) does not mean that HTTP/3 assets themselves are cached. Instead, it means the **client will remember the server's support for HTTP/3** for 24 hours, allowing it to attempt HTTP/3 connections for future requests to the same domain without rediscovering support for HTTP/3.  

  

```
  location ~* ^.+\.(css|js|jpg|jpeg|gif|png|ico|gz|svg|svgz|ttf|otf|woff|woff2|eot|mp4|ogg|ogv|webm|webp|zip|swf|map|mjs)$ {
    add_header alt-svc 'h3=":443"; ma=86400';
}
```