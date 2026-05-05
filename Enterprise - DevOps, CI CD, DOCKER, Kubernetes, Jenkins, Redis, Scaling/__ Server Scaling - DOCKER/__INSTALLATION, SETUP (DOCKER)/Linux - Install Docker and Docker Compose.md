**How to use:** Turn on persistent "Table of Contents".

## 🖥️ Install Docker Engine and Docker Compose Plugin on a Server via SSH

> This assumes a Linux server such as **Ubuntu 22.04/24.04** or **Debian 11/12**. You will SSH into the server as `root` or a sudo user. Docker’s current Linux install guidance for Ubuntu and Debian uses Docker’s official apt repository and installs both **`docker-buildx-plugin`** and **`docker-compose-plugin`**. ([Docker Documentation](https://docs.docker.com/engine/install/ubuntu/?utm_source=chatgpt.com "Install Docker Engine on Ubuntu"))

### 🔐 Step 1: SSH into your server

```bash
ssh root@your-server-ip
```

If you are using a non-root sudo user:

```bash
ssh youruser@your-server-ip
```

---

### 🧹 Step 2: Remove old or conflicting Docker packages

Docker recommends removing unofficial or older packages first because they can conflict with the official Docker packages. That includes old packages such as `docker.io`, `docker-compose`, and sometimes `containerd` or `runc`. ([Docker Documentation](https://docs.docker.com/engine/install/ubuntu/?utm_source=chatgpt.com "Install Docker Engine on Ubuntu"))

```bash
apt remove -y docker docker-engine docker.io docker-compose docker-compose-v2 docker-doc podman-docker containerd runc
```

> `apt` may tell you some packages were not installed. That is fine.

---

### 📦 Step 3: Install required packages

```bash
apt update
apt install -y ca-certificates curl gnupg lsb-release
```

These packages are used to add Docker’s official repository and signing key. ([Docker Documentation](https://docs.docker.com/engine/install/ubuntu/?utm_source=chatgpt.com "Install Docker Engine on Ubuntu"))

---

### 🔑 Step 4: Add Docker’s official GPG key

For modern Ubuntu and Debian installs, Docker’s docs use `/etc/apt/keyrings` for the repository key. ([Docker Documentation](https://docs.docker.com/engine/install/ubuntu/?utm_source=chatgpt.com "Install Docker Engine on Ubuntu"))

**If server is Ubuntu:**
```bash
install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | gpg --dearmor -o /etc/apt/keyrings/docker.gpg
chmod a+r /etc/apt/keyrings/docker.gpg
```

**If server is Debian**, use Docker’s Debian key URL instead:

```bash
install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/debian/gpg | gpg --dearmor -o /etc/apt/keyrings/docker.gpg
chmod a+r /etc/apt/keyrings/docker.gpg
```

---

### 🗂️ Step 5: Add Docker’s official apt repository

**Ubuntu:**

```bash
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] \
  https://download.docker.com/linux/ubuntu \
  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
  tee /etc/apt/sources.list.d/docker.list > /dev/null
```

**Debian:**

```bash
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] \
  https://download.docker.com/linux/debian \
  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
  tee /etc/apt/sources.list.d/docker.list > /dev/null
```

Using `os-release` is aligned with Docker’s current repo setup examples. ([Docker Documentation](https://docs.docker.com/engine/install/ubuntu/?utm_source=chatgpt.com "Install Docker Engine on Ubuntu"))

---

### 🐳 Step 6: Install Docker Engine, Buildx, and the Compose plugin

This is the important part. Install all of these together:

```bash
apt update
apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```

Why this matters:

- `docker-ce` installs Docker Engine
    
- `docker-ce-cli` installs the Docker CLI
    
- `containerd.io` installs the container runtime
    
- `docker-buildx-plugin` helps modern build workflows
    
- `docker-compose-plugin` is what enables the **`docker compose`** command syntax ([Docker Documentation](https://docs.docker.com/engine/install/ubuntu/?utm_source=chatgpt.com "Install Docker Engine on Ubuntu"))
    

Without the Compose plugin, you may have Docker installed but still get errors when running commands like:

```bash
docker compose build
```

---

### ▶️ Step 7: Start and enable Docker

```bash
systemctl start docker
systemctl enable docker
```

This starts Docker now and makes it come up automatically on reboot. ([Docker Documentation](https://docs.docker.com/engine/install/ubuntu/?utm_source=chatgpt.com "Install Docker Engine on Ubuntu"))

---

## ✅ Step 8: Verify Docker, Buildx, and Compose plugin

Check Docker itself:

```bash
docker version
```

Check the Buildx plugin:

```bash
docker buildx version
```

Check the Compose plugin:

```bash
docker compose version
```

- And if you want to feel more confident about Compose, go ahead and run:
```
docker compose build
```
^ It might either build an image if you're in a docker folder, or it will error "no configuration file provided: not found", which is fine - either way shows docker compose is installed.

Docker’s official Compose install docs specifically use `docker compose version` to confirm the plugin is installed correctly. ([Docker Documentation](https://docs.docker.com/compose/install/linux/?utm_source=chatgpt.com "install the Docker Compose plugin"))

Also test the engine:

```bash
docker run hello-world
```

---

## 🔎 If `docker compose build` still fails

Run these checks:

```bash
docker compose version
docker buildx version
docker info
```

If `docker compose version` fails, the Compose plugin is likely missing or not installed correctly. Docker’s official Linux Compose instructions say the repository-based fix is:

```bash
apt update
apt install -y docker-compose-plugin
```

([Docker Documentation](https://docs.docker.com/compose/install/linux/?utm_source=chatgpt.com "install the Docker Compose plugin"))

If `docker compose version` works but `docker compose build` fails, then the issue is more likely related to:

- missing `docker-buildx-plugin`
    
- a bad `compose.yaml`
    
- a bad `Dockerfile`
    
- permission issues talking to the Docker daemon
    

---

## 📝 Notes

- Prefer **`docker compose`** over **`docker-compose`** for new setups. Docker treats the standalone `docker-compose` as legacy. ([Docker Documentation](https://docs.docker.com/compose/install/standalone/?utm_source=chatgpt.com "Install the Docker Compose standalone (Legacy)"))
	- In fact `docker-compose` would be phased out and be "command not found"
    
- Installing from Docker’s official apt repository is the recommended Linux approach for Ubuntu and Debian. ([Docker Documentation](https://docs.docker.com/engine/install/ubuntu/?utm_source=chatgpt.com "Install Docker Engine on Ubuntu"))
    
- The manual Compose plugin install exists, but Docker notes that manual installs do **not** auto-update, so repository install is easier to maintain. ([Docker Documentation](https://docs.docker.com/compose/install/linux/?utm_source=chatgpt.com "install the Docker Compose plugin"))