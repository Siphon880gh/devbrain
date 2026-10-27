`depends_on` does **not** wait for the other service to be healthy. It only waits for the container to start.

This is why an app can boot, try to connect to Postgres, and crash with a connection refused — even though `depends_on` listed `db`.

## Start-only (the default)

```yaml
services:
  app:
    image: my-web-app
    depends_on:
      - db

  db:
    image: postgres
    environment:
      POSTGRES_PASSWORD: secret
```

Compose starts `db` first, then starts `app`. “Started” means the container process launched, not that Postgres is accepting connections.

For how services talk to each other after they are up, see [[Docker compose yml - Services communicating to each other]].

## Wait until healthy

You need a `healthcheck` on the dependency **and** `condition: service_healthy`:

```yaml
services:
  app:
    image: my-web-app
    depends_on:
      db:
        condition: service_healthy

  db:
    image: postgres
    environment:
      POSTGRES_PASSWORD: secret
    healthcheck:
      test: ["CMD-SHELL", "pg_isready -U postgres"]
      interval: 5s
      timeout: 5s
      retries: 5
```

Without both pieces, Compose still only waits for start. A working example is in [[Docker n8n community locally (Advanced)]].
