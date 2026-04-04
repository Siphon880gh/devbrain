
Take a look at:
```
docker run -d --restart=unless-stopped --name focalboard -p 8000:8000 focalboard
```

The --name flag is used to assign a custom name to your container, in this case, the name is focalboard. This makes it easier to refer to the container when managing it (e.g., stopping, starting, or inspecting the container) instead of using the container's ID, which is a long string (that you would have to get by listing all containers with `docker ps -a` ).

---

But what if your container in `docker ps` or `docker ps -a` has a random or hashed name, and you want to give it something more descriptive?

Rename it with:
```bash
docker rename <old_name_or_id> <new_name>
```

Then you can start the exited container with:
```
docker start botpress
```