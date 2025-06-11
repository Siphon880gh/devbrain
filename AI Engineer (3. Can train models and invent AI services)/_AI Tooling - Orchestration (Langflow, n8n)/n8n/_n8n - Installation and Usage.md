For Docker, you can install the latest community self-hostable edition
- Pulls a Docker image, runs a container with persistent data via a mounted volume, and automatically removes the container on exit.:
```
docker run -it --rm --name n8n -p 5678:5678 -v n8n_data:/home/node/.n8n docker.n8n.io/n8nio/n8n
```

**The specific version** we are using is (for pulling in the image):
```
docker run -it --rm --name n8n -p 5678:5678 -v n8n_data:/home/node/.n8n docker.n8n.io/n8nio/n8n:1.94.1
```