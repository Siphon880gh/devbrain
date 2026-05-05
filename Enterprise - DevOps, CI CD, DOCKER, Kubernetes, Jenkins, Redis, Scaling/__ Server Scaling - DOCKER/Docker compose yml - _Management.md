Assuming you're at the working directory with the `docker-compose.yml` file, the commands you most likely will run are:
```
docker ps
docker compose down
docker compose up
docker compose up -d

docker volume list
docker volume rm postgres-data
```

^ -d means detached mode so it can run in the background (useful for production). Not having `-d` is usually when you're still figuring out how to make Docker work for your particular image(s) for `docker-compose.yml` or to troubleshoot why it didn't work (since background is less obvious with the errors).

However, you can view the logs for a specific image with even if they were at background with:
```
`docker compose logs <service_name>`
```


You can **specify** the container image:
`docker compose up app -d` runs the service named `app` from the `docker-compose.yml` file in detached mode (background), as long as there is a service defined with that name in the `docker-compose.yml` file. The commands down and options -d also work