Docker is the tech that lets you use particular os and particular interpreters (node 14, node 16, or Python 3 etc). It's self contained files and makes sure dependencies and files stay the same regardless where you run it. It's secured requiring you to control what port is exposed etc.

It's also very relevant in balancing/recruiting more servers because you'll have the same environments and installed dependencies spun up. With many tools built on libraries other developers built which may require specific environment (like a specific Linux distro) and other dependencies at specific versions (that your package installer may not respect with it going for the newest version), you need this consistency in the former of containerized docker images that you run in order to run more servers. This is basically required for modern SaaS facing online traffic and scaling up to be a profitable business.

The basis for Docker is the `docker run` commands taking the image file, then creating a container. This environment is consistent and isolated from the host OS and from other containers, which makes it portable and ensures it runs the same way everywhere. The container itself is an active, in-memory instance of an application, running all the required processes for the app. It shares the host machine's OS kernel but runs in an isolated user space.

In order to create an image file yourself, because you want to offer images for your customers to install your app, you have to author a Dockerfile and know the `docker build` command.

If you need multiple containers (like other libraries or databases) or what you downloaded needed multiple images, it would come in the form of Docker Composer's `docker-compose.yml` file and its `docker compose` commands.

For deeper comparisons, you can refer to [[Docker - Docker Compose vs Docker CLI vs Dockerfile]]

Here are guides for each Docker workflow:
- [[Docker CLI - _Management]]
- [[Docker - Dockerfile for image - _PRIMER]]
- [[Docker compose yml - _PRIMER]]

---

The major operations are

- Build container from image  (Docker Desktop or Docker CLI)
- Run container (Docker Desktop or Docker CLI)
- Create image (Dockerfile) (if you’re authoring images for other developers)
- Running a container that requires other containers (Docker Compose)

---


For many of the Docker commands, you need to have a Docker daemon running. It'll complain a Docker daemon isn't detected otherwise.

To run Docker daemon
- Either having installed and run Docker daemon
- Or having installed and run Docker Desktop (GUI for Docker).

---

Docker can be used in many ways for many purposes involving VM and containerization. It can get overwhelming. So I recommend deep diving into the purposes you often need Docker for. So invest in the skill tree branches that benefits you. You may choose to master all skill tree branches.

Here is someone complaining about how Docker is so complicated, but others mention that although it's complicated, Docker has official documentations on each approach (Docker Compose, etc):
https://www.reddit.com/r/docker/comments/797rwg/does_anyone_actually_think_docker_is_easysimple/
