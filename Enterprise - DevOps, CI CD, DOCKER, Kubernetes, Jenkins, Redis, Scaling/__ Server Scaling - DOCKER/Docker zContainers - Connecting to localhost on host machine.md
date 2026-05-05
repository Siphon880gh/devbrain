TLDR:
```
http://host.docker.internal:3000/webhook/1b238aa5-f88a-4482-97f6-039a28c5cc44
```

---

Explained in context of:

To send a webhook request from n8n, simply add an **HTTP Request** node.

If you're running n8n locally in a **Docker container** and want to send a request to another service also running on your machine (e.g. a local API or webhook endpoint), note the following:

### 🔁 Localhost in Docker

Normally, a POST request might look like this:

```
POST http://localhost:3000/webhook/1b238aa5-f88a-4482-97f6-039a28c5cc44
```

However, when **n8n runs in Docker**, `localhost` refers to the container itself — not your host machine. To reach services running on your host, use:

```
POST http://host.docker.internal:3000/webhook/1b238aa5-f88a-4482-97f6-039a28c5cc44
```

This special domain name `host.docker.internal` allows containers to talk to the host system.