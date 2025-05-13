When a Dockefile has a `VOLUME` instruction like:
```
VOLUME /data
```

And then you build an image from that Dockerfile.

The containers you run from that image are expected to mount to a folder outside the container so that user changes are persistent (since containers are ephemeral)

If you do not explicitly mount anything when running the container, Docker will still create a volume behind the scenes to store data written to the container's /data (with this example above).

This is called an anonymous volume and they can be managed with docker volume ls 

That docker volume ls  shows Docker-managed volumes (anonymous and named):
![[Pasted image 20250513025411.png]]

When you bind a volume like in this case running a container:
```
sudo docker run -it --name zadam-trilium -p 127.0.0.1:8080:8080 -v ~/trilium-data:/home/node/trilium-data zadam/trilium:latest
```

It wont appear at `docker volume ls`  because it's not a Docker managed volume. It's completely managed b your own system: You can check if successfully mounted and saved data by running  `ls ~/trilium-data` 

---

**Notice from the screenshot that not all Docker managed volumes are anonymously named**. 

So where the named volumes come from? In docker-compose.yml, you can request Docker to manage the volumes:

docker-compose (partly):
- These volumes listed under volumes: field without any path after the ":" - they are named volumes you want Docker to create and manage internally.
```
volumes:  
  langflow-postgres:  
  langflow-data:
```

- Then you reference a Docker volume in a service like this in order to mount data persistently outside the ephemeral container:
```
volumes:  
  - langflow-data:/app/langflow
```

---
  
**What exactly does it mean that Docker manages the volumes?**

If you run an inspect to get the folder path to a Docker managed volume: `docker volume inspect docker_pgdata` 

You get a path like: `/var/lib/docker/volumes/docker_pgdata/_data

But you can't view that on your computer system. Docker managed volumes are mounted to folders inside a VM!

---

To see contents of that VM mounted folder, you can run a container that mounts the volume and lets you `ls` inside

- You can think of the syntax for -v as Docker-Volume:Temporary-Container-Volume
- The. container with --rm means to auto remove the container after it exists (so doesn't stick around at `docker ps -a`  and cause errors about it already existing when you try to run it again. Mnemonic: `--rm`  is slave to `docker run`  because it's an option, and it affects the behavior of running. The actual command `docker rm CONTAINER_ID`  would remove exited containers from `docker ps -a`

```
docker run --rm -it -v langflow-data:/data alpine sh
```


Then inside the container, you can see files in that path with:
```
ls /data
```