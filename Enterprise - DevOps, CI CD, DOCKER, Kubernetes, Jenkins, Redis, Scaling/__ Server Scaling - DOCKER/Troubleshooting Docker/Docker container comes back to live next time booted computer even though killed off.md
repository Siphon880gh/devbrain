Titled: container comes back to live next time booted computer even though killed off

You probably started a container with restart=yes

---


Run `docker ps`  for container id

Let's say the container id is `804a0b995935`, then run:
```
docker inspect -f '{{ .HostConfig.RestartPolicy.Name }}' 804a0b995935
docker update --restart=no 804a0b995935  
docker kill 804a0b995935
```