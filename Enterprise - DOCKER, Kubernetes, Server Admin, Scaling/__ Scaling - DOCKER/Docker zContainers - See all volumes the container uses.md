
To list **all volumes** that a container uses—whether they are:
- **Docker-managed volumes** (`docker volume ls`) which are volumes inside VM's d
- **Bind mounts** (mounted to a host path)
    
—you can use the following command:
```
docker inspect CONTAINER_ID
```


If you don't know the CONTAINER_ID, list all running containers with `docker ps` to find your container. You can list all running AND exited containers with `docker ps -a`.


At the inspection report, look for "Mounts" section. That will provide you the Name and the Source. That Source is the volume path.

If you see a path similar to a Docker volume then that means you didn't mount to host path when you ran the container off the image:
Eg. `/var/lib/docker/volumes/b3d9e096a3f8e9b26180789a45e786e1b9f685abf423fdd08404319fa09363c1/_data`

---

**Want to see inside the volume path?** (Like `ls`)

If it's a host volume path, you can easily cd into that with your own terminal.

If it's a Docker volume, it's being managed by the Docker VM, then you need to find the section "To see contents of that VM mounted folder" at [[_ Docker Concepts - Volumes]]