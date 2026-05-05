For having multiple js-html apps that fetch to a backend server (express or flask) running on the same server and/or having reverse proxy, you need to be discretionary with the port numbers so that you dont use another port number that’s been used by another backend server. Note this tutorial is not for graphql

Review of why we reverse proxy: Aka proxy passing. You dont want someone to visit domain.tld:3001. Makes it harder to give a SSL, looks unprofessional, and gives hackers another port to target. You can hide it behind domain.tld/app/app1 or domain.tld/app1/api, for example

For example if you have a backend server (nodejs or flask) at port 3001 And you proxy pass (aka reverse proxy) to 127.0.0.1:3001 when someone visits https://domain.tld/api/app, first you must strip away the base site url (like /api/app ) by rewriting the url internally, and in that way your backend api endpoints that you developed at a root path on your local computer like at localhost:3001, can still hit matches. That will be discussed in a later section.

But if you have any javascript that manipulates the URL or any link, script, img, a[href] that links relative, you may have to adjust them.

Here's a pretty complete list of considerations:
- Make all links (a[href]) friendly to reverse proxy by having them all be relative (like href links to “folder” or “./folder” and not “/folder”. Because if a link rewrite the url at the address bar, then it wont be hitting the location block at nginx vhost in order to perform the reverse proxy / proxy passing
- When redirecting in js using pathname, `document.location.pathname`  setting to “./” is the same as “/” and will thus hit a nginx vhost location block that isn’t going to trigger the reverse proxy. Use `document.location.href`  instead of pathname for “./”.  
- Other js redirects you may need to look for (with grep or manually) and then adjust are:  
	- location.pathname  
	- location.replace  
	- location.href  
	- location.assign  
- Frontend assets and hyperlinks like link[href], script[src], img[src], a[href], etc may need the ./ as well  
- Frontend fetch and $.ajax will need the “./” if it starts the path with a alphabet or with a slash.

FYI why start with a slash: Notice you changed the frontend requests to `/app/app1`  and NOT `app/app1`. We are using a base url (from document root of domain.tld, go into app/app1), NOT a relative path (from this current folder, go into app/app1). Why? If the url in the address bar changes to a more nested path, your older script src, a hrefs, img, etc will be 404 because it’s no longer at the correct path level.

If your frontend is actually React, and NOT simply HTML or PHP, you have additional considerations: [[Mixed Web Server - Reverse Proxied CRA React app]]

The above checklist meant you hard coded the paths. You could try having an .env file with a BASE_URL whose value for example could be  /apps/app1/) and use webpack compiler placeholder. However this becomes more heavy on the build tooling engineering side more than the web development side.

If you decide to continue hardcoding the paths, you should know how to run the `grep`  or `sed`  commands so that in the future if you have to change the folder path or url path, you can change the hard coded paths. You may also want a Migration Guide saved in your documentations for this app or as a MD file in the same app folder. An example would guidance to perform a grep or sed for “/apps/app1/” and replace it with the new baseURL Here’s a short template:
```
# Migration Guide  
  
To make the app user friendly on a mixed VPS / Dedicated Server (mixed as in it can support php, nodejs, AND python) which helps reduce costs, reverse proxy is used to pass a friendly url's request to an internal port.  
  
Here's how you replace the baseURL for this app:  
- Run grep for `/app/goals-social-network/` and replace with your new baseURL. Or you may use sed to match and replace.
```

Switching from frontend, your backend api endpoints might need some consideration.

Firstly, a backend that sends back a 302 temp redirect status code with a new Location header to the client using `res`  to tell it to redirect - that needs a prefixed base url:
```
router.get('/posts/posts', (req, res) => {  
    res.redirect("/app/community-tech-blogs/posts");  
    return;  
});
```  

Very likely your backend api matches dont try to match the base url `/api/app` . **WHY:** You developed the NodeJS or Python app at a local environment (computer) first, which defaults to the 300X or 500X url in the web browser, so you naturally coded the api endpoints to root paths. One way is to strip away the request url in the code before matching against the api endpoints, however, this is not friendly to future migrations. You could make it easier if you work on an .env file variable for the base site url. But a recommended way is to work with vhost.

Have the vhost when a location url is hit, to strip away this base app url before passing the internet request to the express or flask at the true ported url. In other words, you internally rewrite the requesting url at the same location block where you matched the url and THEN you proxy pass to 127.0.0.1:300X or 127.0.0.1:500X, and you do this at the nginx vhost file:

```
  # Reverse proxy  
  location ~ /app/goals-social-network[/]* {  
    rewrite ^/app/goals-social-network[/]*(.*)$ /$1 break;  
    proxy_pass http://127.0.0.1:3001;  
    proxy_read_timeout 300s;   # Adjust as needed  
    proxy_connect_timeout 300s; # Adjust as needed  
    proxy_send_timeout 300s;   # Adjust as needed  
    proxy_set_header Host $host;  
    proxy_set_header X-Real-IP $remote_addr;  
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;  
    proxy_set_header X-Forwarded-Proto $scheme;  
  
    # Enable CORS  
    add_header 'Access-Control-Allow-Origin' '*' always;  
    add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS' always;  
    add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization' always;  
      
    # Handle OPTIONS (preflight) requests  
    if ($request_method = OPTIONS) {  
      add_header 'Access-Control-Allow-Origin' '*';  
      add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';  
      add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization';  
      add_header 'Access-Control-Max-Age' 1728000;  
      return 204;  
    }  
  }
```

As a wrap up, since your port doesn't need to be access on the internet, for security you may want to make sure to disallow these 300X or 500X port(s) to the internet with iptables, ufw, etc (ufw is a syntax sugar wrapper for iptables). No need to expose the port to the public internet anymore since you’re having the user visit at the url that doesn’t have the port number. The vhost has already hit the private network at the datacenter and can access the port no problem when reverse proxying / proxy passing.