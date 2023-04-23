An Express server is basically a node process you leave running in the background so that the machine can act as a server that listens for requests and sends server responses. Then you can deploy this Express server on an online server that supports the node command. 

You'd run the node in the background, then it'd setup a port where clients (browser, apps, users) send requests with methods GET, POST, DELETE, PUT, etc, and the Express server will return a file, text, or JSON information. For example, it could setup localhost:3001 to serve websites or API resources.

1. Start npm project, install express, then create the node script:

1a. Common convention for the node script is: 
```
server.js
```

1b. Common convention for npm script is (and online deployments like Heroku will look for this):
```
"start": "node server.js"
```

2. At the top of server.js:
```
const express = require("express");
const app = express();
```

3. Setup any middlewares. Middleware runs on the client request. After middleware is run on the client request, then the modified request may pass to the code at the specific route and method, and the modified request gets processed by the code, and then the server sends the response to the client. 

These middleware are recommended on every Express server because it helps Express parse the most common formats of incoming requests. Parse encoded URL including its extended aka nested information. Parse JSON information:
```
app.use(express.urlencoded({ extended: true }));
app.use(express.json());
```

4. Setup routes that handle the client request and have the server sends back a response. 

4a. In this exhaustive API example, you get client request of different formats. And you send back JSON. You can get FormData from client request (for example, `fetch("url", formObject)` or $.get("url", formObject)`. You can get URL parameter which is much like there is a variable between or after a forward slash; the variable name is what your code has preceded with double-colon :, and the value is what the client sends in that position of the URL slashes. Finally, URL query that follows the format `?key1=value&key2=value` can also be retrieved:
```
app.get("/api/:subpath?key1=value&key2=value", (req, res) => {
	let data1 = req.body;
	let data2 = req.params.subpath;
	let data3 = req.query.key;
	let data4 = req.query.key2;

	res.json({success:true});

});
```

4b. In this example, the client requests for a webpage or other file to be served. Instead of sending json as a response, you serve the filepath. Remember, that filepath has to exist. We will use path module because it builds the filepath with forward-slashes or backward-slashes depending on the server's operating system.
```
const path = require("path");

app.get("/", (req, res) => {
	res.sendFile(path.join(__dirname, "public", "animals.html"));

});
```

4c. We covered sending JSON and files. You can also send raw text:
```
	res.send("We see you there. The API is not finished. Please come back later!");
```


5. Setup listening on your server at a specific port. Run the server.js node process in the background. Then send a request to the same port
```
let port = 3001;

if (process && process.env && process.env.PORT)
    port = process.env.PORT;

server.listen(port, () => {
    console.log(`Server listening at ${port}`);
});
```

6. Start the server on your localhost. Remember that npm scripts like start doesn't need the run in `npm run start`. If you want hotloading, you can globally install nodemon and run the server.js with `nodemon server.js`: 
```
npm start
```

Now you can request at
```
http://localhost:3001/url
```