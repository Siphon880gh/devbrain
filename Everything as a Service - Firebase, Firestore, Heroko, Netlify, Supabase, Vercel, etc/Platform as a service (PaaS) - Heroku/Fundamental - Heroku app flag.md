Many Heroku commands, such as `logs`, allow you to specify the app in two ways:

```bash
heroku logs --tail -a APP_NAME
```

or

```bash
heroku logs --tail --app APP_NAME
```

Both `-a` and `--app` do the same thing—specify which Heroku app the command should run against.