
## ⚠ Important Change Notice

Please note that this release contains a **security improvement** for the **Docker image**. We went from running as the `root` user to a non-root `botpress` user by default. For more details about the Dockerfile `USER` instruction, please refer to this documentation: [https://docs.docker.com/develop/develop-images/dockerfile_best-practices/#user](https://docs.docker.com/develop/develop-images/dockerfile_best-practices/#user).

Those changes will most likely **not impact existing users** but might require some to execute manual changes before being able to use the new image.

Only those who use or count on using [local bind mounts](https://docs.docker.com/storage/bind-mounts/) for the `/data` folder will need to follow these steps:

1. On the host machine, create a `botpress` user with `UID=999` and `GID=999`.
    - E.g. on ubuntu the commands would look like: `groupadd -g 999 botpress && useradd -m -r -u 999 -g botpress botpress`
2. Change the ownership of the local `/data` folder to the newly created user.
    - E.g.: `chown -R botpress:botpress <path to /data>`
3. Now you can start the docker image using the `botpress` account and use the host mount with all the security improvements.

Or those that extend the `botpress/server` image:

```diff
FROM botpress/server:v12_30_0
# Changes the user to root so you can run privileged commands.
+USER root
# Code that requires superuser privilege
# ...
# Switch back to the botpress user to keep the security improvement.
+USER botpress
```

---

News posted at:
- https://github.com/botpress/botpress/releases/tag/v12.30.0
- https://newreleases.io/project/github/botpress/botpress/release/v12.30.0
