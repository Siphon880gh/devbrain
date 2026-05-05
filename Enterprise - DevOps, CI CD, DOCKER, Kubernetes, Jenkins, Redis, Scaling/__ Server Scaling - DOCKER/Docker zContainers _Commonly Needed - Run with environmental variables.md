
Let's say you're passing environmental variables into a n8n container. Upon running it:
```
docker run -it --rm --name n8n -p 5678:5678 -v n8n_data:/home/node/.n8n --env NODE_ENV=production --env API_KEY=12345 docker.n8n.io/n8nio/n8n
```