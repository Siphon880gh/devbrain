
If you're using Docker Desktop, you can delete the images that have been pulled/downloaded. But if you don't have Docker Desktop (server for example, using the docker daemon instead):

- `docker image ls`: To see the list of all the available images with their tag, image id, creation time and size.
- `docker rmi <image_id>`: To delete a specific image.
- `docker rmi -f <image_id>`: To delete a docker image forcefully

If errored: `Error response from daemon: conflict: unable to remove repository reference "stephaneturquay/metabase-arm64" (must force) - container 43fd144f73c0 is using its referenced image 5ad4cb76807f`

The more elegant way is to run `docker ps -a` which shows all containers including those exited (aka stopped). Then you want to `docker rm <image_that_exited>`, then try to remove the docker image again: `docker rmi <image_id>`