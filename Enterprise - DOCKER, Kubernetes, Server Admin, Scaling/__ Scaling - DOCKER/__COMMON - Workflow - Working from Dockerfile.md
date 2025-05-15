### Required Knowledge

- Image and Containers
	A single Docker **image** can be used to create multiple **containers**. Each container runs independently, even if based on the same image. For example, you can launch three containers from the same image and map them to different host ports like `3000`, `3001`, and `3002`.
	
	Why: This separation between image and container is what makes Docker inherently scalable — you can spin up as many container instances as needed from the same base image. This was the original intention for Docker.

- Dockerfile
	These are instructions on how to build the image. The instructions could contain things like installing an os, installing certain packages, creating folders, copying files from hots machine into the image.
	
	You build from the Dockerfile using the `docker build` command

### 1. **Build an Image from a Dockerfile**

To create a Docker image from a `Dockerfile`:
```
docker build -t myapp-image -f path/to/Dockerfile .  
```

Explanation:
- `-t myapp-image`: gives your image a custom name (tag)
- `-f path/to/Dockerfile`: specify the location of your Dockerfile
- `.`: context (directory to include in build)
    

✅ After building, list your images with:
```
docker image ls
```

---

### 2. **Run a Container from an Image**

To create and start a container from your image:

docker run -d --name myapp-container -p 8080:80 myapp-image  

- `-d`: detached mode (runs in background)
    
- `--name myapp-container`: custom name for easier management
    
- `-p 8080:80`: maps port 80 in container to 8080 on host
    

✅ List all containers (running or not):

docker container ls -a  

---

### 3. **Restart a Stopped Container**

If a container has stopped, restart it using its **name** (or ID):

docker start myapp-container  

You can also stop, remove, or view logs using the name:

docker stop myapp-container  
docker rm myapp-container  
docker logs myapp-container  

---

### ✅ Summary

|   |   |
|---|---|
|Concept|Command Example|
|Build image|`docker build -t myapp .`|
|List images|`docker image ls`|
|Run app|`docker run -d --name myapp -p 8080:80 myapp`|
|List containers|`docker ps -a`|
|Restart|`docker start myapp`|

---

Would you like this turned into a Markdown file or shell cheat sheet?