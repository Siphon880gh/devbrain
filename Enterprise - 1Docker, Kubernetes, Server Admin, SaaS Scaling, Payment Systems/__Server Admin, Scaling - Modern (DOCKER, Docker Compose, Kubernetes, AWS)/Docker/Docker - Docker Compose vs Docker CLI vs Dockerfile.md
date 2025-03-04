When you're downloading libraries to use for your server, you may encounter a `docker-compose.yml` file. That's the file that Docker Compose (`docker compose` commands) reads in order to download/build/run containers automatically. Note this is different from a Dockerfile which is used to build an image that can be built into a container. And note that `docker run` commands do not read the `docker-compose.yml` file and instead read directly your options in the command line (Often multi line with `\`).

Meanwhile, Dockerfile is a file that has commands to prepare your app, open any port for the container, and what command to run to start your app. So a Dockerfile can have commands to setup a NodeJS app (Select Node version, select working directory, copy over the files into the image directory, running `npm install`), a Dockerfile setting to enable port 3000 (with `EXPOSE 3000`), and then `node server.js` as a command (In that case it's: `CMD ["node", "server.js]"` in the Docker file)

---


Both the CLI and Compose:
Specifies what ports are mapped between container and host machine, any mounting to persist data, etc

Compose focuses on multicontainer starting and management. It can specifies what images are required, then you can defined Docker Compose rules for those dependencies in the same file. It'll start the dependencies in the order inferred by `deps:`.

Dockerfile can specify what command should be ran when they start up, and what port is exposed