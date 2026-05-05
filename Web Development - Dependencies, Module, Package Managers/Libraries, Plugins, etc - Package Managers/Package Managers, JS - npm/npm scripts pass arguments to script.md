
Let's say your app expects:
```
node app.js arg1 arg2 arg3
```

This will work too:
```
npm start arg1 arg2 arg3
```

When package.json has (Look at `start` field):
```
{
  "name": "email-sender",
  "version": "1.0.0",
  "description": "Email sender",
  "main": "app.js",
  "scripts": {
    "start": "node app.js"
  },
  "dependencies": {
    "dotenv": "^16.5.0",
    "nodemailer": "^7.0.3"
  }
}

```

Npm scripts can take in arguments automatically and pass them to the command found in package.json. It'll make sure to have added a space between `node app.js` and `arg1 arg2 arg3` when the user runs `npm start arg1 arg2 arg3` so that the underlying command is actually `node app.js arg1 arg2 arg3`