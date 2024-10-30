Docker Compose is for managing multiple containers because of the "deps" field.

When you're downloading libraries to use for your server, you may encounter a `docker-compose.yml` file. That's the file that Docker Compose (`docker compose` commands) reads in order to download/build/run containers automatically. Note this is different from a Dockerfile which is used to build an image that can be built into a container. And note that `docker run` commands do not read the `docker-compose.yml` file and instead read directly your options in the command line (Often multi line with `\`)

For an example of docker-compose.yml file and its usage to install Metabase with PostgresQL, refer to [[Metabase BI - _PRIMER]]

In that example, running `docker compose up` would read the `docker-compose.yml` file at the working directory, then downloads if not already exist, the postgres image, then starts a container off postgres. After this, then it finally downloads/run the container for metabase-arm64. These images have been published to Docker so they are looked up and downloaded automatically when you run the docker compose up command:

The usual workflow to write a docker-compose.yml is to figure out the options to properly run the image using `docker run`, and this is because it'll give you errors right away. Options that are ran successfully can be later translate into your docker-compose.yml file. The [[Metabase BI - _PRIMER]] follows this workflow in order to successfully run Metabase on Mac M1/M2 or ARM64 chip using the Metabase ARM 64 docker compose file.

If you are running a service off Docker and it only requires ONE image, you can run it using `docker run`. But if the options are too extensive to bother typing or memorizing or that one image requires other images to be already running as containers (for example, databases or libraries), then you'll want to stick with `docker compose` commands which runs from docker-compose.yml file. 

For managing these containers with Docker compose, know some technicalities:
- The commands you most likely will run are:
```
docker compose down
docker compose up
docker compose up -d
```
- Restarting the Metabase container (`docker compose restart`) will not automatically restart the PostgreSQL container, even though Metabase depends on PostgreSQL in the `docker-compose.yml` file. Dependencies in Docker Compose ensure that containers start in the correct order on the initial run, but they don’t enforce a restart order. So, if you restart Metabase, PostgreSQL will continue running independently. The purpose of restart in Docker Compose is: Restarts all stopped and running services, or the specified services only.