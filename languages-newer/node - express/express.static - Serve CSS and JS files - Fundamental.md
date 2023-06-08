When using Express.js as a web server, you can have it serve .html files with res.sendFile (Refer to setup lesson if you are confused). But the problem is each time you have a <script src or <link href, it's actually sending GET requests to those URLs.

Then you end up having to create GET routes to those URLs. Otherwise, there the stylesheets and javascript files will not load and there will be 404 errors in DevTools. Imagine if you have many asset files. This is what express.static middleware helps with. 

You can use multiple express.static middleware's, for example, to js and css folder. The middleware will look into all the files in these folders recursively then generate the GET routes to those URLs. Now you can include those assets in your HTML file without problem.

```
server.use(express.static("css"));
server.use(express.static("js"));
```
