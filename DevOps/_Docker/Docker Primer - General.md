# Why Docker (TLDR)
========
https://www.reddit.com/r/learnprogramming/comments/j6ityv/i_cant_understand_docker/


Why Docker
========

Some command line tools may require a lot of dependencies and environment paths that are not straightforward to install on your system. So Docker came up with the solution of offering the right dependencies and environment paths in virtual machine images called Docker images. Also an added advantage is you do not have to install anything extra on your own computer since you can load the Docker image instead. Some command-line tools or software decided to come included with instructions on how to **build** a compatible Docker image - these instructions are usually in a file named Dockerfile.

It gets a bit more complicated than that in the Docker world though. "Since images are, in a way, read-only, you cannot start or run them. What you can do is use that template as a base to build a container. A container is, ultimately, just a running image. Once you create a container, it adds a writable layer on top of the immutable image, meaning you can now modify it." - https://phoenixnap.com/kb/docker-image-vs-container

So you are actually running a Docker Container which is based off a Docker image. When it comes to cli and gui uses, you **build** images and you **create** a container from an image. You can build an image from a textfile of instructions named Dockerfile. You **run** a container when you're running an OS on Docker.

For example, look at this OCR command-line tool. You can install dependencies to make it work on your terminal. Or you can build a Container image from the Dockerfile and have the OCR command-line tool ready to be used when you load the Container image with Docker.
https://github.com/yardstick17/image_text_reader

Here's how to build from Dockerfile:
```
docker build - < Dockerfile
```

Here's how to run in your terminal:
```
docker run -e LC_ALL=C.UTF-8 -it yardstick17/image-text-reader bash -c "PYTHONPATH='.' python3 read_image.py read_text_from_local_image -f images/sample_image.jpg"
```

Installation
============
Installs both the GUI and CLI:
https://hub.docker.com/editions/community/docker-ce-desktop-mac/

Tutorial 1 (How to check out)
=================================
Let's load the Alpine linux distro with its bash terminal (and its versions of commands). More info on the Alpine distro:
https://hub.docker.com/r/alpine/git

# Get their Dockerfile:
```
git clone https://github.com/docker/getting-started.git
```

Make sure to cd into the folder you cloned.

# Build the image from their Docker file
```
docker build -t docker101tutorial .
```

# Create a container named docker-tutorial from the image, then run it:
Start a container based on the image you built in the previous step. Running a container launches your application with private resources, securely isolated from the rest of your machine.
```
docker run -d -p 80:80 --name docker-tutorial docker101tutorial
```

Then the image and container will appear on the docker GUI dashboard too so you can easily manage them (such as deleting them to save storage space). With Docker account you can share your own images. Remember you **run** containers.

Alternately, you can create and save a Container from the remote image:
```
docker run --name repo alpine/git clone https://github.com/docker/getting-started.git
```

Tutorial 2 (How to persist files)
=================================
Docker's philosophy is that Containers are ephemeral, eg not permanent, and are meant for process isolation. This would mean whatever files you create on that Container does not get saved for the next time you load it. But there is still a way. 

Because of this philosophy, you'll have to formally commit changes to your image on your computer files, then next time you run the container off it, you'll have the file changes (such as saved files or edited files).

Let's get an OS (Docker container) that is ready for tensor flow (machine learning using python):
```
docker pull tensorflow/tensorflow:nightly-jupyter
```

Run the image name interactively aka on the fly. It'll create a container ID for you on the fly (rather than you running a container)
```
docker run -it tensorflow/tensorflow:nightly-jupyter bash
```
Or: ```docker run -it -p 8888:8888 tensorflow/tensorflow:nightly-jupyter bash```

On a separate terminal (because you've logged in your bash into a container and no longer have access to your usual commands like docker) - find out the container ID it created for the run-on-the-fly container:
```
docker ps -a
```

Make the changes you want. Notice that this tensorflow does not easily allow you to edit python files for you to run, so let's update python then install vim (vi will be vim because is the latest):
```
apt-get upgrade
apt-get install vi
```

Save to a new image or the same image name:
```
docker commit CONTAINER_ID NEW_IMAGE_NAME
```
eg. docker commit 5a43c7f3d048 tf-vim

Then next time after you close the current session, you can run the newly commited image:
```
docker run -it -p 8888:8888 tf-vim bash
```

You can verify an image exists with:
`docker images` or `docker image ls`
Or click the Images tab in the Docker GUI


Troubleshooting
===============
A port already in use? Want to stop all containers?
```
docker stop $(docker ps -q)
```

Essentials
==========
You can save an image in tar. Note it'll look like the system is hanging, but will take a while to produce the file where your terminal is at. Eg. Could end up being ~1.7gb
```
docker save tensorflow/tensorflow:nightly-jupyter > tf-vim
```

You can verify an image exists with:
`docker images` or `docker image ls`
Or click the Images tab in the Docker GUI

Cheat Sheet
===========
https://gist.github.com/spyesx/10c6ee350d760651f1fdb805611fc8fd

Aka Containerized,
===
Yes, "dockerized" is often used interchangeably with "containerized," especially in contexts where Docker is the containerization technology being used. 

- **Containerized**: This term refers to the general concept of encapsulating or packaging software in containers. Containerization involves encapsulating an application and its dependencies into a container that can run on any compatible system, regardless of the underlying infrastructure. This approach ensures consistency across multiple development, testing, and production environments.

- **Dockerized**: Specifically refers to the process of packaging an application and its dependencies into a Docker container. Since Docker is one of the most popular containerization platforms, the term "dockerized" is commonly used to describe applications that have been prepared to run in Docker containers.

So, while all dockerized applications are containerized, not all containerized applications are dockerized, as there are other container technologies besides Docker, such as Podman, rkt, and LXC. However, in many modern software development contexts, Docker has become synonymous with containerization due to its widespread adoption and influence.
