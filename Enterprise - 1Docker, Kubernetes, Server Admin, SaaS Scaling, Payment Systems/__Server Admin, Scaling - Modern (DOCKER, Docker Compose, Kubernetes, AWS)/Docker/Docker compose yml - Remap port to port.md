
A docker compose yml file:
```
ports:
- "3500:3000"
```

That means that although the app runs port 3000, it's been captured by the container its in, and the traffic allows your local machine to access the container's app through port 3500. This means:
- Left side is host machine's port to access the container's app
- Right side is the app's default port inside the container

Remember, Docker is host-centric so the host machine's port is set first. Also, if you have downloaded and ran many nodejs containers, often times their developer choose port 3000 out of convention, so you want the option to rewrite it to another port number so that you can run all container apps without conflicts. Also, you can access the app on the web browser at localhost:300X if it's a backend web app, and therefore, Docker Compose has host remapping.