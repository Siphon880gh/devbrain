1. Downgrade node version at Heroku server via package.json
```
"engines": {
   "node": "14.15.1"
 }
```


2. Specify web service/process using a Procfile

Procfile:
```
web: node server.js
```


From:
https://stackoverflow.com/questions/43596835/heroku-is-giving-me-a-503-when-trying-to-open-my-web-app-works-on-local-host#answer-67544081