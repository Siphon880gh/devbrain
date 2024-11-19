Your full stack app that serves html files from localhost:300X/ or localhost:500X/ are served at root path (because of the "/"). Once you have a friendly url like domain.tld/app/app1, it abstracts away the port but introduces a base url "/app/app1".

So if you have any javascript that manipulates the URL or any link, script, img, a[href] that links relative, you may have to adjust them.

This is especially a problem on React apps that by default uses the `/` root path for loading static assets and React Router using / root path for linking. This tutorial is focused on the other javascript and html. For React, you need additional setups - refer to [[Mixed Web Server - Reverse Proxied CRA React app]]

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