### Prerequisites
- Docker installed on your machine
- Port 5678 available

### Step 1: Pull the n8n Docker Image

**Latest version:**
```bash
docker pull n8nio/n8n:latest
```

**Specific version (1.115.3):**
```bash
docker pull n8nio/n8n:1.115.3
```

### Step 2: Run n8n Locally

**Basic command (latest):**
```bash
docker run -it --rm \
  --name n8n \
  -p 5678:5678 \
  -v ~/.n8n:/home/node/.n8n \
  n8nio/n8n:latest
```

**For specific version (1.115.3):**
```bash
docker run -it --rm \
  --name n8n \
  -p 5678:5678 \
  -v ~/.n8n:/home/node/.n8n \
  n8nio/n8n:1.115.3
```

**With environment variables (recommended):**
```bash
docker run -it --rm \
  --name n8n \
  -p 5678:5678 \
  -e NODE_ENV=123 \
  -v n8n_data\
  n8nio/n8n:latest
```

You may be interested in:
```
  -e N8N_BASIC_AUTH_ACTIVE=true \
  -e N8N_BASIC_AUTH_USER=admin \
  -e N8N_BASIC_AUTH_PASSWORD=yourpassword \
```

### Step 3: Access n8n

Open your browser and navigate to:
```
http://localhost:5678
```

### Step 4: Installing Community Nodes Locally

1. Go to **Settings** → **Community Nodes**
2. Click **Install a community node**
3. Enter the npm package name (e.g., `n8n-nodes-google-sheets`)
4. Click **Install**

The node will be installed in the Docker volume at `~/.n8n/nodes/`