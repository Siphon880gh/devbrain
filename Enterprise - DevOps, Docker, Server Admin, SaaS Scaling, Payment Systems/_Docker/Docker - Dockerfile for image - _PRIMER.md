Dockerfile is a file that has commands to prepare your app, open any port for the container, and what command to run to start your app. So a Dockerfile can have commands to setup a NodeJS app (Select Node version, select working directory, copy over the files into the image directory, running `npm install`), a Dockerfile setting to enable port 3000 (with `EXPOSE 3000`), and then `node server.js` as a command (In that case it's: `CMD ["node", "server.js]"` in the Docker file).

Here's a sample Dockerfile to build a node.js app:
```
# Use an official Node.js image from the Docker Hub as the base image
FROM node:14

# Set the working directory in the container
WORKDIR /app

# Copy the package.json and package-lock.json files
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy the rest of the application code to the container
COPY . .

# Expose port 3000 on the container
EXPOSE 3000

# Define the command to run your app
CMD ["node", "server.js"]
```

Then you'd run:
```
docker build -t my-node-app .
docker run -p 3000:3000 my-node-app
```

The docker build command looks for a Dockerfile in the specified directory (`.` in this case), then builds an image based off its instructions and tags the image (`-t my-node-app`) to make it easier for you to reference the image. The image file is stored at the Docker image cache on your machine.

The docker run command actually takes the image file, then create a container. This environment is consistent and isolated from the host OS and from other containers, which makes it portable and ensures it runs the same way everywhere. The container itself is an active, in-memory instance of an application, running all the required processes for the app. It shares the host machine's OS kernel but runs in an isolated user space.

With the cli option "-p 3000:3000", the left side is the host machine's port 3000 being opened to receive/send traffic to the container (which acts like a VM)'s port 3000.