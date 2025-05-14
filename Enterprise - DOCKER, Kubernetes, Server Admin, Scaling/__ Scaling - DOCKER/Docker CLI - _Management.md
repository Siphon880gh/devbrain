
## Installation

Here are the instructions to install Docker CLI for Mac and Debian 12:

### On Mac (using Homebrew)
1. Update Homebrew:
   ```bash
   brew update
   ```
2. Install Docker:
   ```bash
   brew install docker
   ```

### On Debian 12
Let's install Docker without relying on `lsb_release` or needing extra dependencies. Here’s a streamlined method that works for Debian 12:

1. **Add Docker’s GPG Key**:
   ```bash
   sudo mkdir -p /usr/share/keyrings
   curl -fsSL https://download.docker.com/linux/debian/gpg | sudo gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg
   ```

2. **Manually Add the Docker Repository**:
   Add the `docker.list` file with Debian 12’s codename directly (using `bookworm`):
   ```bash
   echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/debian bookworm stable" | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
   ```

3. **Install Docker CLI**:
   Now update the package index and install Docker:
   ```bash
   sudo apt-get update
   sudo apt-get install -y docker-ce docker-ce-cli containerd.io
   ```

This setup should work without additional dependencies. Let me know if you encounter any more issues!

After installation, you can test Docker with:
```bash
docker --version
```

---

## Usage with Image

Assuming you already build the image from a Dockerfile or you loaded in the image into Docker Desktop (or equivalently, you pulled the image using `docker pull` into the local Docker folder), THEN you can create a container from the image. (To review what's an image and what's a container - [[_ PRIMER - Docker Concepts]]) (To get an image, refer to [[Docker Images - Get Images]])

```
docker run -p 3000:3000 my-node-app
```

The commands you most likely will run are:
```
docker ps
docker run <image-name>
docker stop <image-name>
docker rm <image-name>
docker restart


docker run \  
-p 3500:3000 \  
-e MB_JETTY_PORT=3000 \  
stephaneturquay/metabase-arm64:latest

docker -d run \  
-p 3500:3000 \  
-e MB_JETTY_PORT=3000 \  
stephaneturquay/metabase-arm64:latest

docker volume list
docker volume rm postgres-data
```

The sequence to shutdown the container is to stop it, THEN remove it

There seems to be an extra step. This is a common pattern outside of Docker. The reason is to have a stage of recent items that you can restart. The command `docker restart..` lets you restart what's been stopped (but not removed):
`docker restart <image-name>`

You see all that have been stopped (aka Exited) and all that are running with this command:
```
docker ps -a
```
^ `-a` for all