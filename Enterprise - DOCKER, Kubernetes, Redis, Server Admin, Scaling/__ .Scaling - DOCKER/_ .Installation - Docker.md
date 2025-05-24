**How to use:** Turn on persistent "Table of Contents".

Here’s a clear guide for installing **Docker CLI** and **Docker Desktop** on **macOS**, and just the **Docker CLI/Engine** on a **Linux server over SSH** (e.g., Ubuntu/Debian). Let's break it into two sections:

---

## 🧭 1. Install Docker Desktop + CLI on Mac

> This installs both **Docker Desktop** (GUI) and **Docker CLI** (terminal commands like `docker`, `docker compose`).

### ✅ Requirements

* macOS 11+ (Big Sur or later) with Apple Silicon (M1/M2/M3) or Intel chip.
* Admin permissions.

### 🔧 Steps

1. **Download Docker Desktop**:

   * Visit: [https://www.docker.com/products/docker-desktop/](https://www.docker.com/products/docker-desktop/)
   * Choose **Mac (Apple chip)** or **Mac (Intel chip)** accordingly.

2. **Install**:

   * Open the `.dmg` file.
   * Drag and drop Docker into the Applications folder.

3. **Run Docker**:

   * Open Docker from your Applications folder.
   * Grant permissions if prompted (network access, privileged access).
   * It will install **Docker CLI** tools like `docker`, `docker compose`.

4. **Verify Installation** (in Terminal):

   ```bash
   docker --version
   docker compose version
   ```

---

## 🖥️ 2. Install Docker CLI (Docker Engine) on Server via SSH

> This assumes a Linux server (e.g., Ubuntu 20.04+ or Debian). You’ll SSH into the server as root or a sudo user.

### 🔐 Step 1: SSH into your server

```bash
ssh root@your-server-ip
```

---

### 🛠️ Step 2: Install Docker (Ubuntu/Debian example)

#### Clean up any older versions:

```bash
apt remove docker docker-engine docker.io containerd runc
```

#### Install required dependencies:

```bash
apt update
apt install -y ca-certificates curl gnupg lsb-release
```

#### Add Docker’s official GPG key:

```bash
install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | \
gpg --dearmor -o /etc/apt/keyrings/docker.gpg
chmod a+r /etc/apt/keyrings/docker.gpg
```

#### Set up Docker repo:

```bash
echo \
  "deb [arch=$(dpkg --print-architecture) \
  signed-by=/etc/apt/keyrings/docker.gpg] \
  https://download.docker.com/linux/ubuntu \
  $(lsb_release -cs) stable" | \
  tee /etc/apt/sources.list.d/docker.list > /dev/null
```

#### Install Docker Engine:

```bash
apt update
apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```

#### Start and enable Docker:

```bash
systemctl start docker
systemctl enable docker
```

---

### ✅ Step 3: Test Docker

```bash
docker version
docker run hello-world
```


