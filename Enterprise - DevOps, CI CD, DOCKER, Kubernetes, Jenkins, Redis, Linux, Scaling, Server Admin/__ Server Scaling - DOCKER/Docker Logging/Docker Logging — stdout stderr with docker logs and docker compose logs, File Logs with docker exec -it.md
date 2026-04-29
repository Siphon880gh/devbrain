**How to use:** Recommend opening a floating table of contents

## Understanding `docker logs` and `docker compose logs`

### How Docker Captures stdout/stderr — and What To Do When Apps Write to Log Files Instead

Docker logging becomes much easier once you understand one core idea:

Docker is usually **not reading your app’s `.log` files**.

Instead, Docker captures the container process’s:

- stdout (standard output)
    
- stderr (standard error)
    

This is essentially the same output you would have seen if you ran the application directly in your terminal in the foreground.

---

## Part 1 — How `docker logs` Works

When you run a container in the foreground:

```bash
docker run myapp
```

you might see output like:

```text
Server started
Connected to database
Prisma schema loaded
```

That output is coming from the application process itself through:

- stdout
- stderr

Now suppose you instead run the container detached:

```bash
docker run -d myapp
```

The container is now in the background, but Docker still captures that same stdout/stderr stream internally.

You can retrieve it later with:

```bash
docker logs CONTAINER_NAME
```

or follow it live:

```bash
docker logs -f CONTAINER_NAME
```

Conceptually:

```text
Application stdout/stderr
            ↓
Docker logging driver
            ↓
Stored by Docker
            ↓
docker logs reads it back
```

So `docker logs` is basically replaying the terminal output of the container process.

---

## Part 2 — `docker logs` vs `docker compose logs`

### `docker logs`

Use this when working directly with standalone containers.

Example:

```bash
docker ps
docker logs my-container
```

Follow live logs:

```bash
docker logs -f my-container
```

Show only recent lines:

```bash
docker logs --tail 100 -f my-container
```

---

### `docker compose logs`

Use this when your containers are managed through a:

```text
docker-compose.yml
```

or:

```text
compose.yaml
```

file.

Instead of container names, Compose uses **service names**.

Example:

```yaml
services:
  app:
  postgres:
  redis:
```

You would view logs like:

```bash
docker compose logs app
docker compose logs postgres
```

Follow live logs:

```bash
docker compose logs -f app
```

See all services together:

```bash
docker compose logs -f
```

This is extremely useful because you can watch:

- Prisma errors
    
- database startup
    
- Redis connections
    
- API requests
    

all in one combined stream.

---


### Why `docker logs` and `docker compose logs` Usually Work

A common first step when checking container logs is to use:

```bash
docker logs
```

or:

```bash
docker compose logs
```

These commands read the container’s **standard output** and **standard error** streams.

In plain English, they show the same kind of output you would see if the process were running directly in your terminal.

This works well because modern containerized applications are usually expected to send logs to:

- `stdout`
    
- `stderr`
    

Then the container runtime or orchestrator collects those logs for you.

That is the common pattern used by:

- Docker
    
- Kubernetes
    
- Amazon ECS
    
- Google Cloud Run
    
- Heroku
    

Because these platforms are widely used and considered standard industry infrastructure, many application developers design their logging systems around this same pattern. As a result, modern applications often intentionally send their logs and errors to terminal output so they integrate cleanly with container platforms and cloud logging systems.

This is useful because you can see both normal output and error output together. That helps you understand not only **what error happened**, but also **what was happening before and around the error**.

---


## Part 4 — What If the App Writes to Log Files Instead?

Some applications do not primarily log to stdout/stderr.

Instead they write to files like:

```text
/var/log/nginx/access.log
/app/logs/server.log
```

In that situation:

```bash
docker logs
```

may show little or nothing useful.

This confuses many developers because they expect Docker to automatically inspect log files. It does not.

Docker mainly captures:

- stdout
    
- stderr
    

from the main container process.

---

### What To Do Instead

You usually need to shell into the container:

```bash
docker exec -it CONTAINER_NAME sh
```

or:

```bash
docker exec -it CONTAINER_NAME bash
```

Then inspect the log files manually:

```bash
tail -f /app/logs/server.log
```

or:

```bash
tail -f /var/log/nginx/error.log
```

You can also search:

```bash
find / -name "*.log"
```

if you are unsure where logs are stored.

---

## Why Modern Containers Prefer stdout/stderr

Modern container platforms expect applications to log directly to stdout/stderr because it makes centralized logging easier.

This is how platforms like:

- Docker
    
- Kubernetes
    
- Amazon ECS
    
- Heroku
    
- Cloud Run
    

typically operate.

For example:

```js
console.log("Server started");
console.error("Database failed");
```

works perfectly with container logging systems.

This is why many modern apps avoid writing traditional `.log` files unless necessary.

---

## Common Docker Logging Commands

### Find running containers

```bash
docker ps
```

---

### Include stopped/crashed containers

```bash
docker ps -a
```

Very important when containers crash immediately.

---

### View logs

```bash
docker logs CONTAINER
```

---

### Follow live logs

```bash
docker logs -f CONTAINER
```

---

### Show recent lines only

```bash
docker logs --tail 100 -f CONTAINER
```

---

### Compose logs

```bash
docker compose logs SERVICE
```

Example:

```bash
docker compose logs prisma
```

---

### Follow Compose logs live

```bash
docker compose logs -f
```

---

### Open shell inside container

```bash
docker exec -it CONTAINER sh
```

or:

```bash
docker exec -it CONTAINER bash
```

---

## Prisma Example

Prisma usually logs directly to stdout/stderr.

That means Prisma migration or startup errors commonly appear immediately in:

```bash
docker logs
```

or:

```bash
docker compose logs
```

Examples:

```bash
npx prisma migrate deploy
npx prisma generate
```

Common issues you may see in logs:

- invalid `DATABASE_URL`
    
- database unreachable
    
- migrations missing
    
- Prisma Client not generated
    
- schema validation failures
    
- binary compatibility problems
    

Because Prisma logs to stdout/stderr properly, Docker logging is usually enough to debug the issue without entering the container.