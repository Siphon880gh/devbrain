
You might inadvertently waste a lot of storage space if you're an avid user of Docker

---

## Clean images

Run `docker images` :
Eg.
```
REPOSITORY                       TAG        IMAGE ID       CREATED         SIZE
express-app                      latest     6ad8c46b4542   14 hours ago    1.1GB
<none>                           <none>     9f07ade3f7e4   15 hours ago    454MB
ffmpeg-shell                     latest     617b6ba5b2e3   15 hours ago    454MB
<none>                           <none>     fcbdd9656320   15 hours ago    454MB
inq-app                          latest     5a6866e832e9   16 hours ago    1.1GB
siphon880d/inq-app               latest     5a6866e832e9   16 hours ago    1.1GB
<none>                           <none>     1519f0de1802   17 hours ago    1.1GB
node-app                         latest     2d6994d47dcf   17 hours ago    1.1GB
ev_app                           latest     14aaf394ff5d   18 hours ago    1.09GB
env_vars                         latest     14aaf394ff5d   18 hours ago    1.09GB
consistent_node2                 latest     1c1491610513   18 hours ago    1.1GB
consistent_node                  latest     1c1491610513   18 hours ago    1.1GB
<none>                           <none>     6ae6fb54f031   18 hours ago    1.1GB
<none>                           <none>     2ee56397c412   18 hours ago    1.1GB
consistent_python                v1.1       0c72cb25c384   19 hours ago    162MB
<none>                           <none>     57e74b48fcb7   19 hours ago    162MB
test                             v1.0       4cdf725beed5   22 hours ago    274MB
langflowai/langflow              latest     98b73dc06f40   3 weeks ago     2.29GB
postgres                         16         8cd7dffc3a75   4 weeks ago     454MB
redash-scheduler                 latest     43a26587288d   4 months ago    1.68GB
redash-server                    latest     6fb1133d8e74   4 months ago    1.68GB
redash-worker                    latest     906efdfaba5a   4 months ago    1.68GB
pgautoupgrade/pgautoupgrade      latest     c8c0e4b34d3e   4 months ago    631MB
redis                            7-alpine   ea69eadb8dc3   5 months ago    42.3MB
postgres                         latest     6c9aa6ecd71d   5 months ago    456MB
alpine                           latest     c157a85ed455   5 months ago    8.83MB
demucs-separation                latest     bd6bab327850   11 months ago   2.17GB
<none>                           <none>     b01cad5d903e   11 months ago   2.17GB
<none>                           <none>     c6e3e6b5ea82   11 months ago   1.42GB
<none>                           <none>     a1a2e86cd71a   11 months ago   1.42GB
<none>                           <none>     86070ab1bab3   11 months ago   1.53GB
audio-separation                 latest     5e9923cfef99   11 months ago   3.5GB
stephaneturquay/metabase-arm64   latest     5ad4cb76807f   13 months ago   576MB
neo4j                            5.15       345d13bbe837   13 months ago   488MB
<none>                           <none>     48ada8c06341   14 months ago   883MB
<none>                           <none>     edef2158a4c9   14 months ago   883MB
<none>                           <none>     29036d3a3f0d   14 months ago   883MB
maildev/maildev                  latest     c6ea8028b390   19 months ago   196MB
```

If a repository is `<none>`, you can still delete by the IMAGE ID

The delete command is rmi (remove image):  
```
docker rmi --force REPO_OR_CONTAINER_ID
```


Eg.
```
docker rmi --force consistent_python:v1.1
```

---


## Cleanup Containers

Check if any containers running then you can close them (Remember some may be running detached aka daemon aka background mode)

```
docker ps
```

```
docker kill CONTAINER_ID
```


---

## Cleanup Volumes

You may have setup volumes through docker-compose that are no longer needed because you have since not used their containers:

Check for any volumes mounted that are irrelevant
```
docker volume ls
```

And you can remove a volume with:
```
docker volume rm VOLUME_NAME
```


----

### Cleanup Builds

Go to Docker Desktop -> Builds

![[Pasted image 20250518022322.png]]

Check them all and delete. 
![[Pasted image 20250518022346.png]]

Make sure to go to next pages too, if applicable


---

## Cleanup Misc

### 🔍 1. **Check What's Taking Up Space**

Run:

```
docker system df
```

This shows how much space is used by:
- Images (including dangling ones)
- Containers
- Volumes
- Build cache

### 🧹 2. **Remove Failed/Unused Layers**

#### 🗑️ Remove all **dangling images** (often from failed builds):

```
docker image prune

```
#### 🧹 Remove all **build cache and dangling images**:

```
docker builder prune
```

#### 🚿 Remove **everything unused** (images, containers, networks, and volumes not referenced by any containers):

> **Careful**: This can delete useful items.

```
docker system prune -a
```

---

### 🔁 3. **Reclaim Volume Space (if used unintentionally)**  
WARNING! This will remove anonymous local volumes not used by at least one container.

```
docker volume prune
```
