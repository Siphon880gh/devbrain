# These are the basic steps to deploy an Express server to Heroku and some basic troubleshooting if it fails:

1. Login at heroku.com on web browser
2. Create app on web browser.
3. If haven't already, install Heroku CLI
```
brew install heroku
```

4. Make sure your app is a git repository on your machine.

5. There is the command instructions to add heroku origin:
```
heroku git:remote -a APP_NAME
```

If that doesn't work, try `git remote add heroku https://git.heroku.com/APP_NAME.git`

6. Make sure if app is an express server, that the PORT is set correctly. Heroku assigns the port for you, so you can't set your own. You will have to read in the port number from the PORT environment variable:
```
const port = process.env.PORT || 4000;
server.listen(port, () => {
    console.log(`Server listening at ${port}`);
});
```

Although they assign their own port, that port is not accessible to the public. When visiting the app, you still have to go through port 80 first, which is the default port for websites, so your URL does not specify port number, so your URL becomes https://APP-NAME.herokuapp.com/api/route/you/want

7. Make sure package.json and .git/ exists at root folder of app. Package.json must have a start script for Heroku to run it:
```
"scripts": {
    "start": "node server.js"
}
```

8. Make sure the dependencies are all saved in package.json because heroku will install the node modules on their server.


9. Make sure your cli is logged into the correct heroku account:
```
heroku logout
heroku login
```

9. Push your git repository to the Heroku git repository. It will detect the programming language, run node_modules, and run the npm start script. Push with:
```
git push heroku master
```

10. Your app is accessible at 
https://APP-NAME.herokuapp.com/API/ROUTE/YOU/CODED

If App fails to load, connect to the remote heroku logs from your cli:
```
heroku logs --tail
```

11. Slow? Note on free version of heroku, first run in one hour is slow because it gets started up again. After an hour of inactivity, the script is closed.