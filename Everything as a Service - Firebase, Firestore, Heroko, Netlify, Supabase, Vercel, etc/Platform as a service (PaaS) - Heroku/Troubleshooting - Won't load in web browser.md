After pushing to heroku sever, you open the app on the web browser remotely, but it won't load. The interface for logged errors is on your terminal. The terminal will connect to the heroku where the local files are hosted and also show the online server errors:
```
heroku logs --tail
```