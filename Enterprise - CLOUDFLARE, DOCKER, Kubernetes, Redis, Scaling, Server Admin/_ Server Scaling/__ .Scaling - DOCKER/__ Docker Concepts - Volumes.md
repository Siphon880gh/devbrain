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

Another place where named volumes come from is when you run a container off the image but mount using a Docker named volume in place of a host path. Notice:
- `docker run -it -v ~/fbdata:/opt/focalboard/data -p 80:8000 focalboard`
- `docker run -it -v "fbdata:/opt/focalboard/data" -p 80:8000 focalboard`

The first command mounts to hosting machine, whereas the second command mounts to a Docker-managed named volume called `fbdata`.

---
  
**What exactly does it mean that Docker manages the volumes?**

If you run an inspect to get the folder path to a Docker managed volume: `docker volume inspect docker_pgdata` 

You get a path like: `/var/lib/docker/volumes/docker_pgdata/_data

But you can't view that on your computer system. Docker managed volumes are mounted to folders inside a VM!

---

To see contents of that VM mounted folder (For Docker managed volumes), you can run a container that mounts the volume and lets you `ls` inside

- At `-v langflow-data:/data` 
	- langflow-data is the Docker-managed volume listed by `docker volume ls` 
	- The `:/data`  is just some folder we're using to peek into the Docker managed volume. That folder's created in the new alpine container. We could've called it `:/data2`  if we wanted.
	- Mnemonic: You can think of the syntax for -v as **D**ocker-Volume:**T**emporary-Folder-on-Alpine-Container. Alphabetically left to right.
- The. container with --rm means to auto remove the container after it exists (so doesn't stick around at `docker ps -a`  and cause errors about it already existing when you try to run it again. Mnemonic: `--rm`  is slave to `docker run`  because it's an option, and it affects the behavior of running. The actual command `docker rm CONTAINER_ID`  would remove exited containers from `docker ps -a`
- The format is `docker run --rm -it -v CONTAINER_ID:/MADEUP_FOLDER_NAME alpine sh`
```
docker run --rm -it -v langflow-data:/data alpine sh
```


Then inside the container, you can see files in that path with:
```
ls /data
```

---

**Docker Compose: Mount Volume to Your Host System Instead of Relying on Docker-Managed Volumes**

What if you prefer the docker-compose.yml volumes to be mounted to your system rather than managed by Docker's VM?

You can rebind from the docker-compose.yml:
```
volumes:
# Remove or comment out this section if you're switching to host-based

services:
  langflow:
    volumes:
      - ./my-local-folder:/app/langflow
```

**Why Mount a Docker Volume to Your Host System?**

Sometimes, it's useful to mount a volume from a Docker container to your local file system instead of relying solely on Docker-managed volumes. For example, consider an app that doesn’t support email alerts but stores its data—such as a SQLite database—in a mounted volume.

By mounting that volume to your host, you can set up a separate cron job outside the container to watch for changes (like updates to `database.db`). That script can then trigger custom notifications, such as sending emails to the appropriate users. This approach extends the app’s functionality without needing to modify the container itself.