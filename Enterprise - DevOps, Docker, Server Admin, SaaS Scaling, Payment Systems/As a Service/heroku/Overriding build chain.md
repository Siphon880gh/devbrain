
The `heroku-postbuild` script with `NPM_CONFIG_PRODUCTION=false` is commonly used to build and compile a Node.js app on Heroku without minifying the source code. 

When deploying to Heroku, it will run `npm install` and build the application by default in production mode (`NPM_CONFIG_PRODUCTION=true`). This minifies and optimizes the code for production.

However, for source code that needs to be compiled like TypeScript, it is better to disable production mode so the full unminified source is available for compiling:

```
// package.json

"scripts": {
  "heroku-postbuild": "NPM_CONFIG_PRODUCTION=false npm run build"  
}
```

With this script:

- `NPM_CONFIG_PRODUCTION=false` disables production mode before building.

- `npm run build` runs your build script (e.g. `tsc` to compile TypeScript).

- The full unminified source code will be compiled during the build.

- The output files will still be minified for production.

- Heroku will install dependencies in production mode.

So in summary, it allows compiling the source code on Heroku while retaining production optimization for the final built artifacts.

Note the name sounds like "postbuild" but it's actually overriding the entire build chain

Let me know if you have any other questions!

---

Yes, the heroku-postbuild script in the package.json file can be thought of as overriding the default build chain on Heroku. 

Here are a few key points about the heroku-postbuild script:

- Heroku runs the npm install command by default to install dependencies, then runs the start script to launch the app.

- By adding a heroku-postbuild script, you can execute custom build steps after the dependencies are installed but before the app is launched.

- This allows you to override the default build process and add additional build steps like compiling assets, running tests, etc.

- The heroku-postbuild script will run on both deployments to Heroku and whenever you run `heroku run npm run heroku-postbuild` manually.

- So in effect it lets you hook into the middle of the Heroku build chain and execute your own custom commands.

- This can be useful for things like compiling Sass/CoffeeScript files, minifying assets, running tests, or any tasks that need to happen after install but before starting the app.

So in summary, yes the heroku-postbuild script allows you to override and customize the default Heroku build chain to suit your needs. It gives you more control over the deploy and build process.