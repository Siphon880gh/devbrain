Config variables = environmental variables in Heroku

Under the app's Settings tab, you can set the config vars:
![[Pasted image 20250609024811.png]]

**Scripting / CLI:**
Only if you have the local repo connected to Heroku or this is being run on another server that has a repo on that machine connected to Heroku:
```
heroku config:set BASE_URL=https://your-app-name.herokuapp.com
```