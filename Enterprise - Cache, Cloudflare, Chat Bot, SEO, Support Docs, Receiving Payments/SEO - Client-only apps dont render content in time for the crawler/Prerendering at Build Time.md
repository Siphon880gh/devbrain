Keep in mind the intricacies of build scripts
- When you run `npm run build`, npm executes `build`, then `postbuild` if it exists.
- If on Heroku, you need `postbuild-heroku script`. Heroku does not run `build` script prior, and it expects your heroku postbuild script to control for that
	- `postbuild-heroku: "npm run build && node scripts/prerender.js"`