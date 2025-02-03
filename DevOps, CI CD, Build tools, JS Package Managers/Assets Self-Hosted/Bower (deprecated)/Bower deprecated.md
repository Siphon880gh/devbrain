
**What is bower:**
Easily download js and css libraries into your frontend project. It also reconcile dependencies

**Why is it deprecated**
The bower team decided to deprecate the tool and only maintain it. It might not get updated with future versions of libraries, so it's suggested you do not use bower.

Bower is considered deprecated because it became largely redundant with the capabilities of npm (Node Package Manager), which can now effectively manage both backend and frontend JavaScript packages, making a separate package manager like Bower unnecessary

In addition, the majority of frontend developers have moved to build tools that bundle and minify js modules.

**Downside to deprecating Bower:**
- No more new versions of libraries easily downloaded to codebase
- Locally hosting assets through other JS package manager besides Bower:
	- You can use npm which will mix in nodejs-only js files, isomorphic files (either nodejs or js), and browser compatible js files. 
		- You have to know which one is which from experience. 
		- You can look into their Readme and repo for keywords browser and isomorphic but that's not a guarantee. Sometimes there's a bower field in the node module's package.json
		- Often there are multiple versions of .js and .css
		- FontAwesome 5.13.1 not there. NPM has all the minor versions of the most recent major version, then the older major versions tend to only host a few minor versions
		- Yarn is the alternative to npm but suffers the same problems as this list. You can install yarn through npm or the Linux/Unix package manager
- External assets through CDNs:
	- You can still use CDNs to deliver the external js and css
	- Caveat: cdnjs.cloudflare.com slows on on some internet connections on Feb 2025. Refer to [[Migrate away from Cloudflare CDN for external scripts and stylesheets]]
	- Caveat: jsdelivr largely relies on donations. As interest is drawn away from directly linking external scripts and stylesheets, their donations could run dry, then their CDN servers will not work in the future. I'm sure people have made backups or they're available from Github. If this becomes a problem, you may have to download the online backups and perform self-host.

With all these downsides, why did people NOT switch to CRA/Vite/Webpack/etc that downloads and bundles js files from other libraries and your own code? In other words, why not use React?
- Legacy code. Don't have the budget to convert to React.
- quick prototyping for stakeholders that make frequent change
- not a data visualization intensive app