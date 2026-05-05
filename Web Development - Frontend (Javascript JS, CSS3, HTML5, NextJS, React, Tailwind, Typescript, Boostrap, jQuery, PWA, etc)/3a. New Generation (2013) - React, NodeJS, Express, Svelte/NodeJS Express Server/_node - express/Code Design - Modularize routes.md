# Express modularizing the routes
Tutorial: https://medium.com/@catherinelau/how-to-modularize-routes-with-the-express-router-5ce46f9bb2bd

## Flat approach
Instead of using `app = require("express");` to setup routes GET/POST/PUT/DELETE/ ROUTE,
you can setup multiple routes in separate files than combine them at server.js.

The separate files would all require a Router object that's returned: `Router = require("express").Router();`

Each file with Router will route to "/api/users", "api/books" just like app would. All those files would be in a folder like /routes.

Then ./server.js has the usual `app = require("express")` but also `routes = require("./routes)` and then you can load those routes into app with `app.use("/", usersRoutes)`,  `app.use("/", booksRoutes);`

## Cascade approach
Alternately, the route files can be inside deeper and deeper folders. Say you have the file hierarchy routes/api/users. Each folder would have their own index.js and is required.

At ./server.js, `const routes = require('./routes');` would actually import ./routes/index.js. 

Then at ./routes/index.js, you need `const routes = require('./api');. You do the same at ./routes/api/index.js.

At the deepest level or at each folder, you can import other files like `apiRoutes.js` or `userRoutes.js` into their respective index.js. These non-index files can set the routes to /api or /api/users.

At all these files (index and non-index), make sure to export (module.exports).
## Listen on the main ./server.js

// Listen to port code
app.listen(3001, () => {
    console.log(`App listening on PORT 3001`);
});
```


The routes/htmlRoutes.js uses router instance to route
```
const express = require('express');
const router = express.Router(); // notice we are not using Express app like in index.js. We are using Express router for the "Express modules".
const path = require('path');


router.get('/', (req, res) => {

  res.sendFile(path.join(__dirname, '../../public/index.html'));

});


router.get('/animals', (req, res) => {

  res.sendFile(path.join(__dirname, '../../public/animals.html'));

});


router.get('/zookeepers', (req, res) => {

  res.sendFile(path.join(__dirname, '../../public/zookeepers.html'));

});


module.exports = router;
```

