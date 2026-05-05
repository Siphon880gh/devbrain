So you're NOT going to run a node server that sends over build/index.html at GET / and have all relative fetches to asset files (css, js, json) be done at the static path configured at server.js

The path where you build folder will be on your apache server is where you want static files to fetch from and possibly you may not even have a build folder (moving out all build/ contents) into your a folder.

You'll have to keep in mind when you transpile the build folder (running `npm run build`), that the webpack from React-Scripts would create URLs to assets like /build/assets/img, etc that matches what's in your public/ folder. Because a path like "/build/assets/img" is actually thought of as an absolute path (it's not ./build/assets/img), and the domain is omitted in a short form (just like you can omit http: in your script and link tags), that's actually reading from yourdomain.com/build/assets/img. Review that build combines both public/ and src/ and configurations from package.json.  The public had the index.html and asset files where src has some boilerplate and components. As a consequence, you must:
- Define a "homepage": "https://mywebsite.com/myapp", in the package.json.
- Alternately, you do not have to adjust the package.json for each server migration (different domains or path), if you use .htaccess at the server side. More info below

---

<<
After react-scripts creates the build folder, can I deploy the build folder into any folder path on my website or does it have to be at root?


>>
The `build` folder created by `react-scripts` during the build process is essentially a set of static files, meaning you can deploy it at any location on your server - it doesn't necessarily have to be the root.

However, there's one caveat: the paths to the resources (scripts, images, etc.) in the HTML and CSS files are by default set as absolute paths (e.g., `/static/js/main.chunk.js`). This means they'll be loaded from the root of your domain regardless of where you've put the `build` folder. If you deploy your app in a subdirectory, this will cause problems because the browser will still try to load resources from the root directory.

If you plan to serve your app from a subdirectory, you need to set the `homepage` field in your `package.json` file to the URL of your subdirectory before building your project. For example, if you're planning to serve your app from `https://mywebsite.com/myapp`, you should set:

```json
"homepage": "https://mywebsite.com/myapp",
```

Then, when you run the build process (`npm run build`), `react-scripts` will correctly set up paths to be relative to `/myapp/` instead of the root.

Remember to take into account that any changes in `package.json` require a new build to take effect. 

For local testing of this setup, you can use a static server that allows setting the base URL, like `serve`:

```bash
npm install -g serve
serve -s build -l 3000
```
This will serve your application under `http://localhost:3000`.
  
If you're using routing in your application, make sure that it's set up to work with subdirectories. If you're using `react-router-dom`, you should use the `<BrowserRouter basename="/myapp">` prop to set the base URL.


\<<
If I upload to a server that supports .htaccess, can this all be taken care of without adding a homepage property intro package.json?

\>>
Yes, if you're deploying your React application on a server that supports `.htaccess` like Apache, you can use `mod_rewrite` to handle the routing to your app, without the need to set the `homepage` property in your `package.json`.

Here's an example of a `.htaccess` file that could be used to serve a React app from a subdirectory:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /myapp/
    RewriteRule ^index\.html$ - [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-l
    RewriteRule . /myapp/index.html [L]
</IfModule>
```


This `.htaccess` file tells Apache to serve the `index.html` file (which is the entry point to your React app) for any requests that don't correspond to an existing file or directory. This is necessary because React apps are single-page apps, so all requests should be handled by `index.html`.

This file should be placed inside the `/myapp/` directory on your server.

However, this will only take care of the routing. It won't make the browser load static assets (JS, CSS, images, etc.) from the `/myapp/` directory, so you might still need to set the `homepage` property in your `package.json` to `"https://mywebsite.com/myapp"`.

Another thing to note: even though you can solve this on the server side, it's still a good idea to make your app aware of its base path if it's going to be anything other than the root. This way, things like client-side routing with `react-router` will work correctly.