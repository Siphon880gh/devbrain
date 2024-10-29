Note: This applies to python and nodejs but for our hypothetical situation and code snippets, I’ll be using nodejs

## Intro

### Situation
You have NodeJS apps that when ran, would listen to port 3001, 3002, 3003, etc

### Why public facing should not connect to your port directly
When you deploy it online, you dont want people to have to visit a URL like https://domain.tld:3001. That is just visually gnawing and also a security concern making your port numbers known to the internet.

Furthermore, when your frontpage connects to an api like in https://domain.tld, it could have CORS issues (unless you code the server code to account for CORS)

### Reverse proxy
That’s where reverse proxy comes into play. Instead of public facing being https://domain.tld:3001, the public facing can be https://domain.tld/app1/api. Furthermore, you can block 3001 from being accessed by the internet, but allow it to be accessed internally from your own server (If you’re a server admin, imagine the port is not opened to the router/gateway but kept within the private network).

### Reverse proxy causes API endpoint mismatch so we will adjust before API endpoint matching
Now the problem becomes the API endpoints in your server code (server.js, etc). The API end point would have to start with “/app1/api/songs/”. This conflicts with your local development where coding and testing, your api was matching end points “/songs/”. The solution is to strip the URL that your server code recorded, before passing it down the file to match the API endpoints.

## Server script on NodeJS

app1/server.js:
```
const express = require('express');
// const cors = require('cors');
const bodyParser = require('body-parser');
const fs = require('fs');
const app = express();

// Enable CORS for all routes
// app.use(cors({
//   origin: '*' // or '*' to allow any origin
// }));

// Middleware to parse JSON bodies
app.use(bodyParser.json());

// Get the PORT from environment variables, default to 3000 if not set
const PORT = process.env.PORT || 3001;

// Middleware to strip "/x/y/" from the URL path
app.use((req, res, next) => {
  if (req.path.startsWith('/server/')) {
    req.url = req.url.replace('/server/1', ''); // Strip from the URL path
    req.url = req.url.replace('/server/2', ''); // Strip from the URL path
    req.url = req.url.replace('/server/3', ''); // Strip from the URL path
  }
  next(); // Continue to the next middleware or route handler
});

app.get('/pm2', (req, res) => {
  res.status(200).json({ status: 'success', message: 'Reached API 1. And its process.env PORT is: ' + process.env.PORT });
});


// POST /test endpoint
app.post('/test', (req, res) => {
  const jsonData = JSON.stringify(req.body);

  // Append the received JSON data to a log.txt file
  fs.appendFile('log.txt', jsonData + '\n', (err) => {
    if (err) {
      console.error('Failed to write to file:', err);
      return res.status(500).json({ status: 'error', message: 'Failed to log data' });
    }

    console.log('Data received and logged:', jsonData);
    res.status(200).json({ status: 'success', message: 'Data received and logged' });
  });
});

// Start the server
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
```

app2/server.js:
```
const express = require('express');
// const cors = require('cors');
const bodyParser = require('body-parser');
const fs = require('fs');
const app = express();

// Enable CORS for all routes
// app.use(cors({
//   origin: '*' // or '*' to allow any origin
// }));

// Middleware to parse JSON bodies
app.use(bodyParser.json());

// Get the PORT from environment variables, default to 3000 if not set
const PORT = process.env.PORT || 3000;

// Middleware to strip "/x/y/" from the URL path
app.use((req, res, next) => {
  if (req.path.startsWith('/server/')) {
    req.url = req.url.replace('/server/1', ''); // Strip from the URL path
    req.url = req.url.replace('/server/2', ''); // Strip from the URL path
    req.url = req.url.replace('/server/3', ''); // Strip from the URL path
  }
  next(); // Continue to the next middleware or route handler
});

app.get('/pm2', (req, res) => {
  res.status(200).json({ status: 'success', message: 'Reached API 2. And its process.env PORT is: ' + process.env.PORT });
});

// Start the server
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
```

app3/server.js:
```
const express = require('express');
// const cors = require('cors');
const bodyParser = require('body-parser');
const fs = require('fs');
const app = express();

// Enable CORS for all routes
// app.use(cors({
//   origin: '*' // or '*' to allow any origin
// }));

// Middleware to parse JSON bodies
app.use(bodyParser.json());

// Get the PORT from environment variables, default to 3000 if not set
const PORT = process.env.PORT || 3000;

// Middleware to strip "/x/y/" from the URL path
app.use((req, res, next) => {
  if (req.path.startsWith('/server/')) {
    req.url = req.url.replace('/server/1', ''); // Strip from the URL path
    req.url = req.url.replace('/server/2', ''); // Strip from the URL path
    req.url = req.url.replace('/server/3', ''); // Strip from the URL path
  }
  next(); // Continue to the next middleware or route handler
});

app.get('/pm2', (req, res) => {
  res.status(200).json({ status: 'success', message: 'Reached API 3. And its process.env PORT is: ' + process.env.PORT });
});

// Start the server
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});
```

---

## Server script on Python

If you’re asking Python Flask, the equivalent is:
```
class StripApiMiddleware:
    def __init__(self, app):
        self.app = app

    def __call__(self, environ, start_response):
        # Strip "/api" from the request path if it exists
        if environ['PATH_INFO'].startswith('/api'):
            environ['PATH_INFO'] = environ['PATH_INFO'][4:]  # Remove "/api"
        return self.app(environ, start_response)

def create_app():
    app = Flask(__name__)
    app.wsgi_app = StripApiMiddleware(app.wsgi_app)
    CORS(app, resources={r"/*": {"origins": "*"}})
    # ...
```

---

## Vhost

This is for nginx, but if you use apache server, then perform the equivalent changes.

Here in the vhost file for your domain/subdomain for your server, perform a reverse proxy so that when the base path in the url is /server/1, your private network connects to a particular port. You are passing the data incoming and outgoing to this new URL with port number and the /server/1 address is acting as a proxy url.

vhost:
```
  location /server/1 {
    proxy_pass http://127.0.0.1:3001;
    proxy_read_timeout 300s;   # Adjust as needed
    proxy_connect_timeout 300s; # Adjust as needed
    proxy_send_timeout 300s;   # Adjust as needed
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto $scheme;

    # Enable CORS
    add_header 'Access-Control-Allow-Origin' '*' always;
    add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS' always;
    add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization' always;
    
    # Handle OPTIONS (preflight) requests
    if ($request_method = OPTIONS) {
      add_header 'Access-Control-Allow-Origin' '*';
      add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';
      add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization';
      add_header 'Access-Control-Max-Age' 1728000;
      return 204;
    }
  }
  
  location /server/2 {
    proxy_pass http://127.0.0.1:3002;
    proxy_read_timeout 300s;   # Adjust as needed
    proxy_connect_timeout 300s; # Adjust as needed
    proxy_send_timeout 300s;   # Adjust as needed
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto $scheme;

    # Enable CORS
    add_header 'Access-Control-Allow-Origin' '*' always;
    add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS' always;
    add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization' always;
    
    # Handle OPTIONS (preflight) requests
    if ($request_method = OPTIONS) {
      add_header 'Access-Control-Allow-Origin' '*';
      add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';
      add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization';
      add_header 'Access-Control-Max-Age' 1728000;
      return 204;
    }
  }
  
  
  location /server/3 {
    proxy_pass http://127.0.0.1:3003;
    proxy_read_timeout 300s;   # Adjust as needed
    proxy_connect_timeout 300s; # Adjust as needed
    proxy_send_timeout 300s;   # Adjust as needed
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto $scheme;

    # Enable CORS
    add_header 'Access-Control-Allow-Origin' '*' always;
    add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS' always;
    add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization' always;
    
    # Handle OPTIONS (preflight) requests
    if ($request_method = OPTIONS) {
      add_header 'Access-Control-Allow-Origin' '*';
      add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';
      add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization';
      add_header 'Access-Control-Max-Age' 1728000;
      return 204;
    }
  }
```

Then test by visting directly in the web browser:
https://wengindustries.com/server/1/pm2
https://wengindustries.com/server/2/pm2
https://wengindustries.com/server/3/pm2

And you should get a page showing:
Reached API X. And its process.env PORT is: 300X
where X is based on which “server” you visited