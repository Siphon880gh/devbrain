Assuming you already build the image from a Dockerfile or you loaded in the image into Docker Desktop (or equivalently, you pulled the image using `docker pull` into the local Docker folder), THEN you can create a container from the image. (To review what's an image and what's a container - [[Docker - _PRIMER Concept]])

```
docker run -p 3000:3000 my-node-app
```

The commands you most likely will run are:
```
docker ps
docker run <image-name>

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