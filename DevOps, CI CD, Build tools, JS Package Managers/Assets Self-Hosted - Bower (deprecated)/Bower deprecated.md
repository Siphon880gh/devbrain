
**What is bower:**
Easily download js and css libraries into your frontend project. It also reconcile dependencies

**Why is it deprecated**
The bower team decided to deprecate the tool and only maintain it. It might not get updated with future versions of libraries, so it's suggested you do not use bower.

Bower is considered deprecated because it became largely redundant with the capabilities of npm (Node Package Manager), which can now effectively manage both backend and frontend JavaScript packages, making a separate package manager like Bower unnecessary

In addition, the majority of frontend developers have moved to build tools that bundle and minify js modules.

**Downside to deprecating Bower:**
- No more new versions of libraries easily downloaded to codebase
- You can use npm which will mix in nodejs-only js files, isomorphic files (either nodejs or js), and browser compatible js files.
	- You have to know which one is which from experience. 
	- You can look into their Readme and repo for keywords browser and isomorphic but that's not a guarantee. Sometimes there's a bower field in the node module's package.json
	- Often there are multiple versions of .js and .css
- It becomes a hassle on legacy apps or quick prototyping apps (not using react when it's not data visualization intensive or the features keep changing between stakeholders)
	- You can still use CDNs to deliver the external js and css
	- cdnjs.cloudflare.com slows on on some internet connections on Feb 2025. Refer to [[Migrate away from Cloudflare CDN for external scripts and stylesheets]]
	- jsdelivr largely relies on donations. As interest is drawn away from directly linking external scripts and stylesheets, their donations could run dry, then their CDN servers will not work in the future.
