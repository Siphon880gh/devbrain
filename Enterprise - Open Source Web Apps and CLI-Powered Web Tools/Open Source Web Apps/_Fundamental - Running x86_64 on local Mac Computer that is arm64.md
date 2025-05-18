
One common challenge arises when the Docker image for your open source app is only available to x86_64 aka amd, and not available to arm64 (Mac M1/M2/M3) but you want to test the app locally on your computer first. You looked and cannot find an arm64 version image.

You can try to build for your Mac computer (with the source code and Dockerfile, running build on your local computer would usually run `npm install` or `yarn install` via Dockerfile and create the dependencies that are compatible with your OS and chip architecture set). This may not always be technically feasible. Usually if there's no multi arch or arm64 image, it's because things start breaking with the Node dependencies on arm64 so the developers skipped an arm64 version of the image. 

Although you can probably still run the x86_64 container on an Arm64 Apple computer, it will be sluggish because there would be emulation. That sluggishness can be equatted to 3-5 mins to start a container and 3-5 mins to shut down a container, and sluggish updates in the apps as well (which could cause sync problems if it's multiple users).

You could just host the open source app on a Linux server or get a Windows computer. 

To read the rest, continue to [[Docker zContainers _Nuance - Containers running on host machine with different architecture set (amd or x86_64, OR arm64)]]