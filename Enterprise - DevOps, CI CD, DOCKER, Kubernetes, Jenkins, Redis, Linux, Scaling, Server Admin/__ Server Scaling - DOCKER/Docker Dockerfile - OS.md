Let's say a Dockerfile setups NodeJS  because it'll expose an express port as the main application for the Docker container that will eventually run off the image that's being built from the Dockerfile. NodeJS process needs to be running inside an VM operating system so that a process listening at a port and a network exposing the port to outside the VM is possible.

The Dockerfile that installs NodeJS has already addressed the need of an OS already. 

See this Dockerfile:
```
FROM node:14
```

`FROM node:14` actually resolves to something like `node:14-buster` or `node:14-bullseye` depending on when the image is built, and that is a Debian based distribution coded in x86_64 architecture. The image will actually install an OS, then the NodeJS.

---

You can always indicate another OS and even what architecture the OS is coded in.

Here, we have a Debian OS coded in ARM64 (similar to Mac Apple Silicon chip like the M1) - Dockerfile:
```
FROM --platform=linux/arm64 node:12.18.1-alpine
```

Note not all OS distros has ARM64.