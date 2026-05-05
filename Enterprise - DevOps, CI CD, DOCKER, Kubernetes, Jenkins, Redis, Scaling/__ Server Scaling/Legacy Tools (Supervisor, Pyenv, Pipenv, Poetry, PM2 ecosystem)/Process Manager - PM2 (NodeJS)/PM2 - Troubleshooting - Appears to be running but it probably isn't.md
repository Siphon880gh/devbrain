Titled: Appears to be running but it probably isn't

Sometimes apps appear running but they have failed. If your app listens to a port, you can easily check

Check the ports are listening with, eg port 3313:
```
sudo netstat -tuln | grep :3313
```