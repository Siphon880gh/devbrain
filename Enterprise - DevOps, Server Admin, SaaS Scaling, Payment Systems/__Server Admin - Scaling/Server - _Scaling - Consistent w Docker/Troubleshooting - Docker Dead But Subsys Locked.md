
Docker failing to work. 

When you run `sudo service docker status`, you get this error `docker dead but subsys locked`

This is called a deadlock error.

---

There could be multiple causes. 

One scenario is when starting the Docker service, it’ll say fail connecting, then hangs on starting. 

The reason why is because you don't get a chance to run `sudo service docker stop` to stop the service gracefully, so the file that's supposed to be removed at `/var/lock/subsys/docker` doesn't get removed.


---

## Short Fix:

Remove the locked file

```
sudo rm /var/lock/subsys/docker
```

---

## Long Term Solution

Figure out what's wrong. Likely you need to update Docker.