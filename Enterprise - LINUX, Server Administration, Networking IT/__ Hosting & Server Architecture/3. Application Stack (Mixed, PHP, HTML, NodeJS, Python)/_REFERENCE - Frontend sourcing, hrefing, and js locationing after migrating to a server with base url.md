Your full stack app that serves html files from localhost:300X/ or localhost:500X/ are served at root path (because of the "/"). Once you have a friendly url like domain.tld/app/app1, it abstracts away the port but introduces a base url "/app/app1".

So if you have any javascript that manipulates the URL or any link, script, img, a[href] that links relative, you may have to adjust them.

This is especially a problem on React apps that by default uses the `/` root path for loading static assets and React Router using / root path for linking. This tutorial is focused on the other javascript and html. For React, you need additional setups - refer to [[Mixed Web Server - Reverse Proxied CRA React app]]

Know:
- root url is `href="/"` and all other assets starting with `href="/..."` which is default of React
- relative url is `href="something/something`
- base url is your new friendly url starting with slash like `href="/app/app1/`

Here's a pretty complete list of considerations:
- Change all linking and sourcing (a[href], img[src], etc) to the base path (eg. `/app/app1/`). 
	- WHY: This is so that the assets can still hit the vhost location url block reverse proxy, then internally rewrite the request url to the root url `/`, and it'll deliver that request url to your server.js or server.py, and assets can be served as usual (because your server.js or python.py was developed locally on your computer first which used localhost:300X/ or localhost:500X/ with root url for assets).
	- RULE: It's the base path eg. `/app/app1/`, NOT relative path `app/app1` that you precede to href's and src's. This is because if the current webpage's url is another level deeper with more slashes, then the request url could become `/nested/app/app1` and your vhost location block wont hit, causing a 404.
	- **LIST**: href and src's to prefix includes:
		- script src
		- `<link>` href
		- a href
		- img src
	- TIPS to find to replace
		- You can run grep or sed
		- Or you can manually click through the files in your IDE or VS Code and search (CMD+F):
			- `href="`
			- `src="`
			- `href='`
			- `src='`
- If you have vanilla js (with or without React) changing the location or url of the web browser, you need to also prefix the base url to:  
	- location.pathname  
		- If you used `document.location.pathname`  to redirect to the front page, it's recommended you switch it out to `document.location.href`. If you intended to set pathname to “./” as a "refresh", that is treated by javascript as “/” and will thus hit the wrong or no nginx vhost location block.
	- location.replace  
	- location.href  
	- location.assign  
- Frontend fetch and $.ajax will need the base path “/app/app1/” if it previously starts the path with a alphabet or with a slash (root path).
	- fetch
	- $.ajax
	- $.post
	- $.get (there’s no $.update, delete, patch etc equivalent)
	- $.getJSON 
	- $.getScript
- Related to frontend, if a fetch, ajax, etc receives a 302 status code with an accompanying Location header, the web browser will redirect to the Location header's url. Therefore, you will have to edit the **backend** api endpoints adding a prefixed base url:
```
  router.get('/posts/posts', (req, res) => {  
    res.redirect("/app/community-tech-blogs/posts");  
    return;  });
```
- Most of the backend api points are left alone because your urls will get hit after the vhost location block internally rewrites by stripping away the base path, before proxy passing to 127.0.0.1:300X or 127.0.0.1:500X.