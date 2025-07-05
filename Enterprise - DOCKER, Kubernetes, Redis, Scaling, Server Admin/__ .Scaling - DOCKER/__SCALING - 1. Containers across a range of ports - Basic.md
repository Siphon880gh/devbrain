### Scaling Up with Docker: Running Multiple Instances

To scale up using Docker, you can simply start additional containers from the **same image**, each mapped to a **different host port**. This is especially useful when you're running multiple versions of the same application (e.g., for testing or load balancing).

For example, if your original container runs on:

```bash
-p 3000:3000
```

Then you can spin up new containers like so:

```bash
-p 3001:3000
-p 3002:3000
```

Each container maps a **different host port** (e.g. 3001, 3002) to the same **internal container port** (3000), all using the same Docker image.

---

### Forgot the Image Name?

If you didn’t note the image name used by your container, you can retrieve it easily:

1. List running containers:
    
    ```bash
    docker ps
    ```
    
2. Identify the container you want, then inspect it:
    
    ```bash
    docker inspect <CONTAINER_ID>
    ```
    
3. Look for the `"Image"` field in the output — this shows the image ID or name.
    

---

### Run Another Instance

Once you have the image name or ID, start a new container with:

```bash
docker run -p 3001:3000 IMAGE_NAME [OPTIONS]
```

Repeat with different host ports to run as many instances as you need.

---

You're right — the section titled **"Is your app okay?"** doesn't clearly convey its purpose. It's really about **how to safely scale your app**, with a focus on **data sharing limitations** and **storage architecture** when running multiple containers. Here's a clearer rewrite with a more accurate heading and improved readability:

---

### ⚠️ Data Sharing When Scaling: Is Your App Ready?

Let’s compare two example Docker commands:

```bash
docker run -it -v ~/fbdata:/opt/focalboard/data -p 8000:8000 focalboard
docker run -it -v ~/fbdata2:/opt/focalboard/data -p 8001:8000 focalboard
```

Each container is using a **different volume** (`fbdata` vs `fbdata2`). That’s fine for development or testing, but it **won’t work for scalable production** — the containers don’t share state or data.

If your app stores persistent data, you'll need to decide how containers share that data safely. Here are two common approaches:
#### ✅ Option 1: Use a Shared Docker Volume (With Caution)

You can mount the **same named volume** into multiple containers:

```bash
docker volume create focalboard-data
```

```bash
docker run -d -v focalboard-data:/opt/focalboard/data -p 80:8000 focalboard
docker run -d -v focalboard-data:/opt/focalboard/data -p 81:8000 focalboard
```

> ⚠️ **Be careful**: Most apps (like Focalboard) aren’t built to support multiple instances writing to the same local storage. This can lead to **data corruption** or race conditions.

#### ✅ Option 2: Externalize App State (Recommended for Scaling)

For proper horizontal scaling:

- Run the app in **server mode** (if available) and connect to an external **database** (e.g., PostgreSQL or MySQL)
    
- Store uploads (like attachments) in **external object storage** (e.g., AWS S3)
    
- Containers now become **stateless app servers**, free to scale up/down
    

This is the approach used by scalable architectures — each container runs independently and talks to a shared backend.

---

## ✋ Orchestration?

But you ask: There's gotta be an easier way, like a script or a load balancer that automatically spins up the containers and adds them to the next available port in some defined range. Also, it ought to automatically exit containers (and maybe have to remove them?) when user activity dies down.

Yes! Continue to:  [[__SCALING - 2. Containers across a range of ports - Auto-Orchestration]]