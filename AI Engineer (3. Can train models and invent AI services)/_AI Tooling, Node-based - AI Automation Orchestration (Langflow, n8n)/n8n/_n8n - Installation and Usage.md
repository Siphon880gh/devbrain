For Docker, you can install the latest community self-hostable edition
- Pulls a Docker image if doesn't exist, or uses the Docker image already on your deviceo. Then it runs a container with persistent data via a mounted volume, and automatically removes the container on exit.:
```
docker run -it --rm --name n8n -p 5678:5678 -v n8n_data:/home/node/.n8n docker.n8n.io/n8nio/n8n
```

**The specific version** we are using is (for pulling in the image):
```
docker run -it --rm --name n8n -p 5678:5678 -v n8n_data:/home/node/.n8n docker.n8n.io/n8nio/n8n:1.94.1
```


---

When you launch n8n for the first time, you’ll be prompted to request a free activation key—choose **Yes**.  
Even if you’re running n8n locally, the key will arrive by email, so check your inbox.

Once you have the key, go to **Settings → Usage and plan**, paste it into the **Enter Activation Key** field, and save.