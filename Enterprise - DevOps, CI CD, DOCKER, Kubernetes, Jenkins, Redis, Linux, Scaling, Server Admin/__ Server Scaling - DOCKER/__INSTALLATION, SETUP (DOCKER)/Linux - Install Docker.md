**How to use:** Turn on persistent "Table of Contents".

## 🖥️ Install Docker CLI (Docker Engine) on Server via SSH

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


