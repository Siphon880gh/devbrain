Recall Docker Hub is a registry of Docker images that you can easily pull using the Docker pull command or the Docker run command (will automatically look up image at Docker Hub network if no such named image locally on your machine).


At Docker Hub (https://hub.docker.com/), look for the software etc that you want, and go to tags area. Often you will see different versions of the image available to pull or run on the fly via the tagging mechanism:
![[Pasted image 20250610193315.png]]

As you can see, the recommended pulling command is bare basics. Normally you may want to ask more from Docker than just pulling the image.

For example, this command pulls a specific version of n8n that's been tagged as the version number. It'll make sure to keep the process manageable at the forefront of the terminal (rather than going to the background), and it makes sure that the data persists (eg. user data) because it's been mounted outside of the container onto your computer where it is not ephemeral. It also makes sure that the container is not left on the list after you exit the process that's attached to your terminal (because then running the container in the future will cause conflicts).
```
docker run -it --rm --name n8n -p 5678:5678 -v n8n_data:/home/node/.n8n docker.n8n.io/n8nio/n8n:1.94.1
```