
You may want to read contents of a file in the container and you know its path

It's required you know the Container OS' path to that file. This is not the path on the host machine. You usually know this if you had previously shelled into the container to traverse documents / list files using [[Docker zContainers - Shell into the container (which is a Linux distro with usually an app running at a port)]], or if you are privy into the setup at the Dockerfile that originally built the image, or you have documentation

```
docker exec -it focalboard cat /opt/focalboard/config.json
```
