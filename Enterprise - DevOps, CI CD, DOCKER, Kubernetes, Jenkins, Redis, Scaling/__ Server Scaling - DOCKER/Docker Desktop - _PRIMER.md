If managing Docker on desktop, you can go with Docker Desktop instead of the docker cli, and in that way you have a GUI. Either Docker cli or Docker Desktop will run the docker daemon that allows the docker commands to work.

Docker Desktop is a Software that lets you load in Images and then Run Containers off them. Mac, Linux, Windows. Get here https://www.docker.com/products/docker-desktop/

Search the internet (aka Docker Hub) for images here:
![](4hi7FLW.png)
^Containers just search locally which ones you have running from Docker Desktop

From Images, you choose which one to Play
![](3tFUTOe.png)

Then it creates a random name for the container name. You can manage running or stopped containers (aka Exited) at Containers. Recommend you name the containers customly so you know what they are, otherwise, refer to Image column:
![](kmtirzp.png)

You can look into the files of a container. 
Keep in mind they’re ephemeral so your file changes are dropped when it shuts down and does not resume your changes on next restart.

Other points to remember:
- You can run the terminal associated with the container while inside the GUI
- App does not automatically expose the container’s app port to your computer. Refer to [[Docker Desktop - Ports]]

---

Remember ports are not automatic


Running a container off an image in docker desktop DOES NOT automatically make it available as a port you can access on the web browser

Proof:
In Container, if you copy the docker run, and you paste it somewhere, you’ll see there’s no port command:
![](h3b8Clg.png)
