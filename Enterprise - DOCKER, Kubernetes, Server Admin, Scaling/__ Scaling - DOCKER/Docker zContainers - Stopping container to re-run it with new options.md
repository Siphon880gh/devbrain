You have to delete the container (even if it has been stopped, its trace remains). Then you can run it, otherwise it'll complain the container already exists.

List all containers:
```
docker ps -a
```

Remove with:
- But stop first with `docker stop CONTAINER_ID`
```
docker rm CONTAINER_ID
```

Now can run `docker run...`  with the new preferred settings