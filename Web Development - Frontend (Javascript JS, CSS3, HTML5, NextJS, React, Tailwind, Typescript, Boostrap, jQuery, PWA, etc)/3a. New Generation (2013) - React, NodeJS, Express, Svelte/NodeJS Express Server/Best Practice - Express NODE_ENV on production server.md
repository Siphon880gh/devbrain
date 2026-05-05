
Set your production server to have NODE_ENV=production. 

This could be done various ways, such as through .bash_profile or equivalent, through the .env file at your remote app folder. It’s recommended that the NODE_ENV is set at .bash_profile or equivalent so it's production for all apps at your remote server

Then your server.js dynamically loads additional settings for in production aka on your remote server. And you develop on your local computer. Often times when the express server is coupled with a React app:

```
if (process.env.NODE_ENV === 'production') {  
    app.use(express.static(path.join(__dirname, '../client/build')));  
}
```

And to be certain, your npm start script can have:
```
"start:prod": "export NODE_ENV=production; cd server && npm start",
```

Or, depending on your convention:
```
"start": "export NODE_ENV=production; cd server && npm start",
```