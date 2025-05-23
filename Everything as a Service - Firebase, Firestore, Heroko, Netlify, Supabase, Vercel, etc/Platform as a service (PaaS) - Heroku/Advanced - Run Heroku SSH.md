Advanced - Run Heroku SSH:
`heroku run bash --app APP_NAME`

Then you can do simple commands like cd or ls or cat. You can even run `npm install` but there is no reason to because everytie you push your repository up to heroku, it automatically installs any missing npm modules. Vi and vim is not supported on the heroku server.
