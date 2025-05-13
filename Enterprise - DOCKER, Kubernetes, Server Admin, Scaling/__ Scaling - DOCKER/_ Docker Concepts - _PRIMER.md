Purpose: Foundational
### 🐳 What Is Docker and Why It Matters

Docker is a platform that allows you to run applications in **self-contained environments** called containers. Each container runs on a specific operating system and interpreter (e.g., Node.js 14, Node.js 16, Python 3) with a fixed set of dependencies. This ensures that your app behaves **exactly the same** across development, testing, and production—regardless of the underlying host machine.

#### 🔐 Security and Isolation

Docker containers are **isolated** from each other and from the host OS. Each container runs in its own user space, sharing the host's kernel but not its filesystem. You explicitly control what is exposed—such as which ports are open—making it more secure than traditional app deployments.

#### ⚙️ Portability and Consistency

Modern software relies heavily on packages written by other developers. These packages often require **specific environments or OS versions**, and package managers tend to pull the latest versions by default, which can cause compatibility issues. Docker solves this by **freezing the entire environment** into an image so it can be run consistently anywhere.

This is especially important when scaling SaaS applications to handle growing traffic or when deploying across many servers. Docker ensures each new server starts with the exact same setup—no “it worked on my machine” issues.

#### 🏗️ Images and Containers

- A **Docker image** is a blueprint—essentially a snapshot of the OS, application code, and all dependencies.
- A **Docker container** is a running instance of that image. You can have many containers running from the same image.

The core command to run a container from an image is:

```bash
docker run [options] your-image-name
```

#### 🚀 Scaling with Containers

One of Docker’s key benefits is the **separation between images and containers**, allowing you to **scale easily**. You can spin up multiple containers from the same image on different ports—like 3000, 3001, 3002, etc.—and distribute traffic between them via a load balancer. This is essential for horizontally scaling microservices or API servers in production.

#### 🧱 Building Your Own Image

If you want to distribute your application via Docker, you'll need to write a `Dockerfile`, which defines how the image is built. Then use:

```bash
docker build -t your-image-name .
```

This creates a custom image you can share or deploy. You can:

- **Share your image with the community** via a registry like Docker Hub, so others can download it using `docker pull your-image-name`.
    
- **Deploy it to your own server**, where you can run containers (active processes) based on the image—at any port or scale you need.

#### 🔗 Managing Multiple Services

If your app requires multiple services—like a database, cache, or other dependencies—you’ll use **Docker Compose**. Compose uses a `docker-compose.yml` file to define and manage multi-container setups:

```bash
docker compose up
```

This **spins up multiple independent containers** running along side but all part of the same **Docker network** (managed by Compose)

As multiple independent containers:
- Each service defined in your `docker-compose.yml` file becomes its **own standalone container**. There is **no nesting of containers inside a main one**—Docker doesn't support container-in-container setups by default.
- Can be **listed individually** with `docker ps`
- Can be **stopped/restarted individually** or together using `docker compose` commands (e.g., `docker compose stop`, `docker compose restart`)

Connected to the same network means:
- Each container can **communicate with other containers by service name as the host** (not just IP or `localhost`)
- You can connect to another container using its **internal port** — no need to expose it to the host with `-p`

In terms of service name as the host and the internal port:
- docker-compose.yml:
```
version: "3.8"
services:
  app:
    image: my-web-app
    ports:
      - "8080:80"  # Exposes internal port 80 to host port 8080
    depends_on:
      - db

  db:
    image: postgres
    environment:
      POSTGRES_PASSWORD: secret
    ports:
      - "5432:5432"  # Optional if only used internally

```

- The `db` container runs **PostgreSQL on internal port `5432`**.
- The `app` container can connect to the database using:    
    - Host being "db"
    - Port being 5432
    - So app container / process can make a request to the url `db:5432`?

---

So yes: after running `docker compose up`, you can run:

```bash
docker ps
```

…and you’ll see a separate container listed for each service (e.g., one for your app, one for your database, one for Redis, etc.).

Let me know if you want that explanation added to the article.

---

For deeper comparisons, you can refer to [[_ Docker Concepts - Encountered in the wild of open source codebases]]

Here are guides for each Docker workflow:
- [[Docker CLI - _Management]]
- [[Docker - Dockerfile for image - _PRIMER]]
- [[Docker compose yml - _PRIMER]]

---

The major operations are

- Build container from image  (Docker Desktop or Docker CLI)
- Run container (Docker Desktop or Docker CLI)
- Create image (Dockerfile) (if you’re authoring images for other developers)
- Running a container that requires other containers (Docker Compose)

---


For many of the Docker commands, you need to have a Docker daemon running. It'll complain a Docker daemon isn't detected otherwise.

To run Docker daemon
- Either having installed and run Docker daemon
- Or having installed and run Docker Desktop (GUI for Docker).

---

Docker can be used in many ways for many purposes involving VM and containerization. It can get overwhelming. So I recommend deep diving into the purposes you often need Docker for. So invest in the skill tree branches that benefits you. You may choose to master all skill tree branches.

Here is someone complaining about how Docker is so complicated, but others mention that although it's complicated, Docker has official documentations on each approach (Docker Compose, etc):
https://www.reddit.com/r/docker/comments/797rwg/does_anyone_actually_think_docker_is_easysimple/
