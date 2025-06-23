Easily forgotten cheat sheet. Let's say you changed developer career and haven't touched this technology in a while. These are the things that are more likely to be forgotten if you took a long hiatus because they're inherently tricky or arbitrary.

## Postbuild Intricacies

Keep in mind the intricacies of build scripts
- When you run `npm run build`, npm executes `build`, then `postbuild` if it exists.
- If on Heroku, you need `postbuild-heroku script`. Heroku does not run `build` script prior, and it expects your heroku postbuild script to control for that
	- `postbuild-heroku: "npm run build && node scripts/prerender.js"`

## Associate local code to online Heroku repo

Whether you:
- create the app locally and then register it as a new Heroku app using the CLI,
- already have a Heroku app set up via the Heroku dashboard, or
- have your GitHub repo connected to Heroku but your local project is only linked to GitHub (not Heroku),

...you should still connect your local codebase to Heroku using the Heroku CLI. This allows you to deploy code, view logs, and manage the app directly from your terminal.

Refer to [[Fundamental - Associate local repo to Heroku]]