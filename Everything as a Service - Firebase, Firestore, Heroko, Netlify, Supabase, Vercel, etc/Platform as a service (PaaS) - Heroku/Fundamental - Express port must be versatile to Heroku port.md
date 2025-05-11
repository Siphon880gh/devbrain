
At your express server.js, you need to yield to Heroku's platform:
```
const PORT = process.env.PORT || 3000;
```

And that's because their PORT number is always different. However, Heroku saves the port number into an environmental variable `PORT` so that the server code can start at the correct port.

Here a short circuiting using OR operator lets you use port 3000 for local development.