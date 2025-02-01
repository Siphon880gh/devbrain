
Text line: Troubleshooting full stack cra or vite showing blank page for npm start

Problem statement: I have a full stack app that when I ran `npm start` from the root, it should have both started server.js and have server.js serve `client/dist/index.html` or `client/build/index.html`. When I visit localhost:3000/, I see a blank page.

## Requirements
Let's say your file structure is setup as:
```
./
./client
./server
```

And your packages, you have 3 packages, with the root package coordinating which page's scripts to run or whether to run the root package's scripts:
```
./package.json
./client/package.json
./server/package.json
```

And let's say your server.js looks like:
```
const express = require('express');
const path = require('path');
const db = require('./config/connection');
const routes = require('./routes');

const app = express();
const PORT = process.env.PORT || 3001;

app.use(express.urlencoded({ extended: true }));
app.use(express.json());

// if we're in production, serve client or build as static assets
if (process.env.NODE_ENV === 'production') {
  app.use(express.static(path.join(__dirname, '../client/dist')));
}

app.use(routes);

db.once('open', () => {
  console.log(`Environment: ${process?.env?.NODE_ENV || "Development"}`);
  app.listen(PORT, () => console.log(`🌍 Now listening on localhost:${PORT}`));
});

```

---

## Confirm dist or build

### Folder was created from building
Make sure you have ran `npm run build` and that a dist or build folder was created. Depending on cra or vite, you either have a dist or build folder. 

### Folder is referred to
Make sure server.js and any route files (if you chose to have route files) point to either dist or build as appropriately.

server.js:
```
if (process.env.NODE_ENV === 'production') {
  app.use(express.static(path.join(__dirname, '../client/dist')));
}
```

routes/index.js:
```
// serve up react front-end in production
router.use((req, res) => {
  res.sendFile(path.join(__dirname, '../../client/dist/index.html'));
});
```

^^ In these two examples, dist/ folder is pointed to, and my client folder has a valid folder path of client/dist. You need to understand how the pathing works in order to know it's appropriately pointed to: The way the pathing works here is `__dirname` gets the path to the current file the code is in, and appends it to the rest of the arguments. Of course "../" means go up a folder. The path.join makes sure in a cross OS way that the slashes / are appropriately changed if needed, making it robust for you to deploy to different servers

---

## Confirm Server.js environment logic

If the above solves the problem, then you are done.

### Environment logic
First we want to look at server.js

If you have this snippet:
```
// if we're in production, serve client or build as static assets
if (process.env.NODE_ENV === 'production') {
  app.use(express.static(path.join(__dirname, '../client/dist')));
}
```

You're managing the environment 's because:
- when you run `npm run dev` you want the watcher/Hot Reload Replacement (HMR) to take over and have cra or vite serves the pages and asset files, so you can edit your code as the webpage changes in the web browser.
- when you run` npm run start`, you want the server.js to be the sole process that sends pages over to the web browser, and you've coded server.js to send any js/css/json/etc files from ../client/dist because that folder path is hidden from the web browser URL. There is no HMR. And it is friendly to server deployments.

You will want to check the NODE_ENV when the server is ran with npm run start. Add a check like this:
```
  db.once('open', () => {
    app.listen(PORT, () => {
		console.log(`Environment: ${process?.env?.NODE_ENV || "development"}`);
	    console.log(`API server running on port ${PORT}!`);
    });
  });
```

If you find that `npm run start` runs the server in Development mode, you need to have better environment control.

### Environment consistency with cross-env

You need to guarantee that `npm run start` will run in production environment and `npm run dev` runs in development envrionment

Technical explanation (may skip): You can set the NODE_ENV variable in windows using `set` . If it'll be ran from PowerShell, you have to prefix even more. But in Mac/Linux/Unix-Like, you have to use `export` or prefix the node command. This leads to variations and is not friendly to future server deployments, team members, or contributors:
- set NODE_ENV=production
- set NODE_ENV=production && node server.js
- $env:NODE_ENV="production
- export NODE_ENV=production
- NODE_ENV=production node server.js

So forget all this and install cross-env:
- Make sure to NOT install it as a developer dependency so you have more flexibility in the future. Just run `npm install cross-env` inside ./server folder
- Make sure to install it for ./server/package.json
- Make sure root ./package.json does not run `node server/server.js` directly, but rather, it delegates to the server's package.json. So ./package.json should have `"start": "cd server && npm run start"`
- Your ./server/package.json should have: `"start": "cross-env NODE_ENV=production node server.js"`

---

## Client build

If the above solves the problem, then you are done.

### Asset pathing

Look into `client/index.html` or `build/index.html`

It could be either A or B:

#### A (./)
```
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/svg+xml" href="./vite.svg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Search Engine</title>
    <script type="module" crossorigin="" src="./assets/index-caa34026.js"></script>
    <link rel="stylesheet" href="./assets/index-04cdcdca.css">
  </head>

```

#### B (/)
```
  
<head>  
    <meta charset="UTF-8">  
    <link rel="icon" type="image/svg+xml" href="./vite.svg">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Video Search Engine</title>
    <script type="module" crossorigin="" src="/assets/index-caa34026.js"></script>  
    <link rel="stylesheet" href="/assets/index-04cdcdca.css">  
  </head>
```

To have complete control, it depends if you are on Vite or CRA:
- In Vite, you can change `client/package.json`'s build script to `"build": "vite build --base=/"` or `"build": "vite build --base=./"`. 
- In Create React App (CRA) project, you set the `homepage` field in `client/package.json`. That's `"homepage": "/"` or `"homepage": "."`

In a Create React App (CRA) project, the equivalent of changing the base URL for assets (similar to Vite's `--base` option) is done by setting the `homepage` field in the `package.json` file. This field specifies the base URL for all the webpack assets.

  
Which one should you choose? If you had server.js' static code pointing correctly, and that static code is running because you're in production when running `npm run start`, and the folder/file structure is appropriate (refer to the requirements section) and your server is serving the webpage at the root (not subdirectory deployment - refer to next section), then either would've worked. Firstly, you can switch between the two (/ or ./) to see if the blank page issue is fixed.

### Subdirectory Deployment

If you are deploying your application to a subdirectory (e.g., `http://example.com/myapp/`) in CRA, you can set the `homepage` to the subdirectory path:

   ```json
   "homepage": "/myapp"
   ```

   This setting tells CRA to adjust the paths of the generated assets so that they're correctly referenced relative to the specified base URL.

In Vite when you will be deploying your application to a subdirectory (e.g., `http://example.com/myapp/`), set the `--base` option in `client/package.json` like this:

```json
"build": "vite build --base=/myapp/"
```

This configuration ensures that all asset URLs are prefixed with `/myapp/`, aligning with the deployment subdirectory.

### Further debugging at Network tab

Open Inspect's Network tab and click your local assets (js, css, etc)

![](1Wzijw8.png)

![](kGGEarH.png)

![](HfGvQBM.png)


They are loading the front page instead of the asset because your routes/index.js has the frontpage served when there's a URL it doesn't recognize (you could've had this or a url endpoint to \*)
```
router.use((req, res) => {
  res.sendFile(path.join(__dirname, '../../client/dist/index.html'));
});
```

This tells you pathing is not correct. In this case, go over these notes again to make sure you didn't miss anything.