 If you have CORS enabled at the vhost level, you do NOT need CORS at the server.js process level because otherwise the frontend will error about having multiple asterisk values, E.g.:
```
The 'Access-Control-Allow-Origin' header contains multiple values '*, *', but only one is allowed.
```

A good practice especially if you migrate between local and multiple online servers, is to use .env variables to control whether or not CORS is needed at the server.js code:

.env:
```
CORS_NEEDED_AT_PROCESS=0
```

.server:
```
if(process?.env?.CORS_NEEDED_AT_PROCESS && parseInt(process?.env?.CORS_NEEDED_AT_PROCESS)) {
  app.use(cors({
    origin: '*'
  }));
}
```