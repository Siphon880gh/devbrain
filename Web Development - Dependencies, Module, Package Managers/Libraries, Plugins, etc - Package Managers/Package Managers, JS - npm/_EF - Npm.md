Easily forgotten cheat sheet. Let's say you changed developer career and haven't touched this technology in a while. These are the things that are more likely to be forgotten if you took a long hiatus because they're inherently tricky or arbitrary.

How to use: Turn on persistent table of contents

---
## Postbuild Intricacies

Keep in mind the intricacies of build scripts
- When you run `npm run build`, npm executes `build`, then `postbuild` if it exists.
- If on Heroku, you need `postbuild-heroku script`. Heroku does not run `build` script prior, and it expects your heroku postbuild script to control for that
	- `postbuild-heroku: "npm run build && node scripts/prerender.js"`

---

## ENV Variable in CLI and in npm script

### The convention for production env in node apps is:
`NODE_ENV=production`

### In an .env file, env variables:
```
NODE_ENV="production"
```

### Terminal (One-off inline run):

```bash
NODE_ENV=production node server.js
```

This sets `NODE_ENV` only for the `node server.js` command. No need for `export` or `&&`.

### Terminal (Persistent for session):

```bash
export NODE_ENV=production
node server.js
```

### npm script (package.json):

```json
"scripts": {
  "start": "NODE_ENV=production node server.js"
}
```

### For Windows users, if needed

Window users would need a different syntax (`set NODE_ENV=production && node server.js`), or use the `cross-env` package for cross-platform support:

```
"start": "cross-env NODE_ENV=production node server.js"
```

This is usually not a problem if you're creating a server for your own company instead of creating a library for public use. If you do use cross-env, you install with: `npm install --save-dev cross-env`


---

## Npm scripts with multiple commands

Sure! Here's a **quick guide** to using `&&`, `;`, and `concurrently` in **npm scripts**:

### Run multiple commands only on prior successes

```json
"scripts": {
  "build-and-start": "npm run build && node server.js"
}
```

- Runs `npm run build`
- Then runs `node server.js` **only if build succeeds**

### Run multiple commands regardless of success

```json
"scripts": {
  "build-then-start": "npm run build ; node server.js"
}
```

- Always runs `node server.js`, even if `build` fails
- Mostly identical to `&&` in **Unix**, but **not supported on Windows**

⚠️ Not cross-platform! Avoid in shared projects.

### Run multiple commands in parallel

```bash
npm install --save-dev concurrently
```

```json
"scripts": {
  "dev": "concurrently \"npm run server\" \"npm run client\""
}
```

- Runs both commands **at the same time**
- Great for dev servers, watch tasks, frontend/backend

💡 You can add prefixes and color:

```json
"dev": "concurrently -n SERVER,CLIENT -c blue,green \"npm run server\" \"npm run client\""
```

---
## CommonJS vs ESM / ECMA

Your `package.json` determines whether files are treated as **CommonJS** or **ESM**:

### Option 1: Default (CommonJS)

You may even **SKIP this entry**. It's the default as of June 2025.
```json
// package.json (OPTIONAL)
{
  "type": "commonjs"
}
```

- You can use `require()` freely.
- To use `import`, you need to use `.mjs` file extension **or** transpile with Babel or use dynamic import.
- To make a module available to be other us files, `module.exports = fxn` for the default exporting, `module.exports = {fxn1, fxn2}` for the named exporting.
- Mnemonic: "Commonly required, Modularly exported"


### Option 2: Enable ESM

```json
// package.json
{
  "type": "module"
}
```

- Enables `import/export` in `.js` files.
- You **must use `import`/`export` syntax**
- To use CommonJS code:
    
    ```js
    import pkg from 'some-cjs-lib';
    ```

- Mnemonic:  "Import module, Export Module, Easy as pie (**E**S6 ECMA)"