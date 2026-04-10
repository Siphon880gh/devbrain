
Often on a new system or server, you want to install both Docker and Docker Compose so you can work with images, containers, and full application stacks.

On macOS, there are **two paths**:

- ✅ **Recommended (easy)** → Use Docker Desktop
- ⚙️ **Manual (advanced)** → CLI + Colima setup

---

# ✅ Option 1 — Use Docker Desktop (Recommended)

This avoids nearly all setup issues.

When you install Docker manually, you often run into:

- Missing `docker compose`
    
- Compose not integrated with Docker CLI
    
- Missing **buildx** (required for builds)
    
- Docker daemon not running (`docker.sock` errors)
    
- Plugin configuration issues
    

Docker Desktop solves all of this by bundling:

- Docker CLI
    
- Docker Compose (v2)
    
- Buildx
    
- Running Docker daemon
    
- Proper socket + permissions setup
    

---

## Install Docker Desktop

```bash
brew install --cask docker-desktop
```

Then open it once:

```bash
open -a Docker
```

---

## Verify it works

```bash
docker info
docker compose version
docker buildx version
```

If those work → you're done.

---

[!note] Why Docker Desktop is easier

> It installs everything together: CLI, Compose, Buildx, and daemon  
> You don’t need to manage `/var/run/docker.sock` manually  
> It behaves like a Linux Docker environment behind the scenes

---

# ⚙️ Option 2 — Manual Setup (CLI + Colima)

Use this if you **don’t want Docker Desktop**.

---

## Step 1 — Install CLI tools

```bash
brew install docker docker-compose docker-buildx
```

Verify:

```bash
docker --version
docker-compose --version
docker buildx version
```

---

> [!note] PATH issues
> If commands are not found, your Homebrew path may not be in `$PATH`  
> Add it to `~/.zshrc`, then run `source ~/.zshrc`
>

---

## Step 2 — Enable `docker compose` (plugin mode)

Modern Docker prefers:

```bash
docker compose build
```

Instead of:

```bash
docker-compose build
```

To enable this, configure plugins, creating this path if it doesn't exist:

```bash
mkdir -p ~/.docker
vi ~/.docker/config.json
```

Add:

```json
{
  "cliPluginsExtraDirs": [
    "/opt/homebrew/lib/docker/cli-plugins"
  ]
}
```

Then:

```bash
docker compose version
```

---

[!note] Compose v1 vs v2

> `docker-compose` = old standalone binary  
> `docker compose` = modern plugin system  
> Always prefer the latter

---

## Step 3 — Run a Docker daemon (THIS is what most people miss)

On macOS:

👉 Docker CLI **does NOT include a daemon**

That’s why you saw:

```
failed to connect to the docker API at unix:///var/run/docker.sock
```

---

## Step 4 — Install and start Colima

Use Colima as your Docker runtime.

```bash
brew install colima
```

Start it:

```bash
colima start
```

---

## Step 5 — Verify everything works

```bash
docker info
docker ps
docker buildx version
```

If `docker info` works → daemon is running ✅

---

## Step 6 — Auto-start on login

```bash
brew services start colima
```

---

## Optional — Run in foreground (debugging)

```bash
colima start --foreground
```

---

[!note] How this setup works

> Colima runs a lightweight Linux VM  
> Docker daemon runs inside that VM  
> Your Docker CLI talks to it via socket

---

# 🔥 Common Errors (and what they mean)

### ❌ `buildx command not found`

> Buildx plugin missing → install `docker-buildx`

---

### ❌ `docker compose build requires buildx`

> BuildKit is enabled but buildx not installed

---

### ❌ `failed to connect to docker.sock`

> No daemon running → start Docker Desktop or Colima

---

### ❌ `docker: command not found`

> Brew path not added to `$PATH`

---

# 🧠 Mental Model (important)

| Component     | What it does                                    |
| ------------- | ----------------------------------------------- |
| Docker CLI    | Commands (`docker`, `docker compose`)           |
| Docker Daemon | Actually runs containers                        |
| Buildx        | Builds images (modern builds)                   |
| Compose       | Multi-container orchestration                   |
| Colima        | Provides daemon on macOS without Docker Desktop |
