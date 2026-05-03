If you deployed through **Heroku Container Registry**, the usual flow was:

```bash
# one-time login
heroku login
heroku container:login

# create app on the container stack
heroku create <app-name>
heroku stack:set container -a <app-name>

# from folder with Dockerfile
heroku container:push web -a <app-name>

# make that pushed image live
heroku container:release web -a <app-name>
```
^ FYI, if the stack:set syntax is confusing, here's a writeup to orientate yourself to it: [[Stack set syntax]]

That is the standard Heroku Container Registry flow: set the app stack to `container`, push the image for a process type like `web`, then release that process type. ([Heroku Dev Center](https://devcenter.heroku.com/articles/container-registry-and-runtime?utm_source=chatgpt.com "Container Registry & Runtime (Docker Deploys)"))

If you had multiple process types, it could look like this:

```bash
heroku container:push web worker -a <app-name>
heroku container:release web worker -a <app-name>
```

Heroku also supports recursive pushes when using files like `Dockerfile.web` and `Dockerfile.worker`:

```bash
heroku container:push --recursive -a <app-name>
heroku container:release web worker -a <app-name>
```

Those commands are part of the Heroku CLI’s documented `container:push` and `container:release` workflow. ([Heroku Dev Center](https://devcenter.heroku.com/articles/heroku-cli-commands?utm_source=chatgpt.com "Heroku CLI Commands"))

If instead Heroku was building the image for you from source, then you likely used **`heroku.yml` + `git push heroku main`**, which is a different Docker-on-Heroku path from pushing a prebuilt image directly to Container Registry. ([Heroku Dev Center](https://devcenter.heroku.com/articles/build-docker-images-heroku-yml?utm_source=chatgpt.com "Building Docker Images with heroku.yml"))

So if you’re trying to remember how **your** app got there, the main clues are:

- If you used `heroku container:push ...`, you deployed a Docker image directly.
    
- If you used `git push heroku main` with a `heroku.yml`, Heroku built the Docker image for you.
    
- If you used plain `git push heroku main` without Docker config, that was buildpacks, not Container Registry. ([Heroku Dev Center](https://devcenter.heroku.com/articles/container-registry-and-runtime?utm_source=chatgpt.com "Container Registry & Runtime (Docker Deploys)"))
    

A very common exact command was probably:

```bash
heroku container:push web -a n8n-tc
heroku container:release web -a n8n-tc
```
