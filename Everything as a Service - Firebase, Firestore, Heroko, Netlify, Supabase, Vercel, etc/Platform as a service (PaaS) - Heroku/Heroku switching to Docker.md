
If you’re switching an existing Heroku app to Docker, you **must remove any previously set buildpacks**, because:
- Heroku associates your app with a specific environment (e.g. Node.js, Python) via buildpacks.
- Even if you add a `Dockerfile`, **Heroku will still try to rebuild using the old buildpacks unless you clear them.**
- This leads to conflicting behavior, broken builds, or the Dockerfile being ignored entirely.

Run this command:
```bash
heroku buildpacks:clear -a your-app-name
```

Then continue deploying with Docker.