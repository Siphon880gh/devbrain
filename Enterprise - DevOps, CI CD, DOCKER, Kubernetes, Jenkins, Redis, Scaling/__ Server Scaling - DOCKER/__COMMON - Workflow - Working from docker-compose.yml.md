### 📦 What is `docker-compose.yml`?

`docker-compose.yml` is a configuration file used to define and manage **multiple containers** (called **services**) as a **single unit**.

Think of it as a **service manager for Docker**, like how an operating system manages background services.

---

## 🧱 1. Define Multiple Services (Each Can Build Its Own Image)

```
version: '3.8'  
  
services:  
  web:  
    build:  
      context: ./web  
      dockerfile: Dockerfile  
    image: myapp-web  
    ports:  
      - "3000:3000"  
  
  api:  
    build:  
      context: ./api  
      dockerfile: Dockerfile  
    image: myapp-api  
    ports:  
      - "4000:4000"  
  
  db:  
    image: postgres:15  
    environment:  
      POSTGRES_PASSWORD: example
```

### 🔍 Key Concepts:
- `web` and `api` services **each build their own Docker image** using a `Dockerfile`
- `db` service uses a **pre-built public image** (`postgres`)
- Each service can expose ports and define volumes, networks, etc.

---
## 🛠️ 2. Build Images from Compose

Run this command:
```
docker compose build
```

This builds **all services with a `build:` key** into Docker images:
- `web` becomes `myapp-web`
- `api` becomes `myapp-api`

🧠 Think of this like compiling services into bootable packages.

✅ You can verify with:
```
docker image ls  
```

---

## 🚀 3. Run the Services

Run command:
```
docker compose up -d
```

This will
- Start **containers** from the built images
- Use **your custom `container_name`** (if set), or auto-generate one
- Set up **networks** so services can talk to each other (e.g., `api` can connect to `db` using just `db:5432`)

✅ You can verify running containers with:
```
docker ps
```

Or see **all** (even stopped):
```
docker ps -a
```

---

## 🔄 4. Restart, Stop, and Tear Down

docker compose restart        # Restart all services  
docker compose down           # Stop and remove containers, but not images  
docker compose down --volumes # Also removes volumes  

---

## ✅ Summary

| Action                   | Command                  |
| ------------------------ | ------------------------ |
| Build all defined images | `docker compose build`   |
| Start all containers     | `docker compose up -d`   |
| List all images          | `docker image ls`        |
| List all containers      | `docker ps -a`           |
| Restart all services     | `docker compose restart` |
| Stop & remove containers | `docker compose down`    |
