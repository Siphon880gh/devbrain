Besides image name, you can be specific on which version of the image through the tag. The tag is usually latest or a specific version

Eg. docker-compose.yml:
```
version: '3.8'

services:
  metabase:
    image: metabase/metabase:latest
```

Eg. docker run command:
```
docker run \
-p 3500:3000 \
-e MB_JETTY_PORT=3000 \
metabase/metabase:latest
```

The tag here is "latest"

You can see the tags available for an image at Docker Hub, eg.
https://hub.docker.com/r/metabase/metabase/tags
