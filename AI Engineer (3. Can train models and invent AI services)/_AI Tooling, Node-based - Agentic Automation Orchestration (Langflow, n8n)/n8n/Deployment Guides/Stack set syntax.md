```
heroku stack:set container -a myapp
```

really means:

> “Switch this app so Heroku treats it as a container-stack app.”

That matters because Heroku needs to know **how** to build/run/deploy the app. If the app is on a normal **buildpack stack**, Heroku expects source code and buildpacks. If it’s on the `container` stack, Heroku expects a Docker image workflow instead

So in this case it's **buildpack stack** vs **container stack**.