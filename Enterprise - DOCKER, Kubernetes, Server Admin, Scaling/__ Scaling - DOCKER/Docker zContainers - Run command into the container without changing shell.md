Without having to shell into the container (which is an OS running an app at a port), you can pass the command from your server's shell directly into the container, then get the output:

```
docker exec -it focalboard cat /opt/focalboard/config.json  
```

You still remain at your shell session and you see the result of that command (`cat ...json`)