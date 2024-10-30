Assuming you already build the image from a Dockerfile or you loaded in the image into Docker Desktop (or equivalently, you pulled the image using `docker pull` into the local Docker folder), THEN you can create a container from the image. (To review what's an image and what's a container - [[Docker - __PRIMER Concept]])

```
docker run -p 3000:3000 my-node-app
```

The commands you most likely will run are:
```
docker ps
docker run <image-name>
docker stop <image-name>
docker rm <image-name>
docker restart


docker run \  
-p 3500:3000 \  
-e MB_JETTY_PORT=3000 \  
stephaneturquay/metabase-arm64:latest

docker -d run \  
-p 3500:3000 \  
-e MB_JETTY_PORT=3000 \  
stephaneturquay/metabase-arm64:latest

docker volume list
docker volume rm postgres-data
```

The sequence to shutdown the container is to stop it, THEN remove it

There seems to be an extra step. This is a common pattern outside of Docker. The reason is to have a stage of recent items that you can restart. The command `docker restart..` lets you restart what's been stopped (but not removed):
`docker restart <image-name>`

You see all that have been stopped (aka Exited) and all that are running with this command:
```
docker ps -a
```
^ `-a` for all