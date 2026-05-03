Relevant to: `Dockerfile`, Docker Compose, local development

When you are still developing a Docker-based app, it is common to start, stop, rebuild, and test containers many times.

A good daily habit is:

```bash
docker compose down
docker compose up
```

Run `docker compose down` first when you start work for the day, especially if you often run one-time containers and sometimes stop containers with `CTRL+C` (out of convenience when the same console is taken up with an active foreground container process).

This helps clean up old containers from previous runs so you do not accidentally stack duplicate containers, stale processes, or leftover container state, swelling up storage use. Then `docker compose up` starts the app again from a cleaner Compose state.