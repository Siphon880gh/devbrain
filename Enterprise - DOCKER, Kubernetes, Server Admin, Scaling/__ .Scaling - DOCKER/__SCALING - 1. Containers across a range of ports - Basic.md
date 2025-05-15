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

## ✋ Orchestration?

But you ask: There's gotta be an easier way, like a script or a load balancer that automatically spins up the containers and adds them to the next available port in some defined range. Also, it ought to automatically exit containers (and maybe have to remove them?) when user activity dies down.

Yes! Continue to:  [[__SCALING - 2. Containers across a range of ports - Auto-Orchestration]]