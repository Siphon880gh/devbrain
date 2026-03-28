
If you want a container to always restart whether because the container crashed or the server restarted:
```
docker run -d --restart=unless-stopped your-image
```

This is called adding a restart policy.

By default, Docker containers do not automatically restart.