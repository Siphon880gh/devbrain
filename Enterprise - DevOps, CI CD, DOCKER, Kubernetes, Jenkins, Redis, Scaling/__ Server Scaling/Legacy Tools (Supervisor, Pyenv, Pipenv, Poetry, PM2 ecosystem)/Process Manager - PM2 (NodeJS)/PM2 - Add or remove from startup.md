## Adding or Removing PM2 From Startup

PM2 can automatically restart your Node.js apps when the server reboots. This is useful for production apps, but sometimes you may want to remove PM2 from startup.

To **remove PM2 from startup**, run:

```bash
pm2 unstartup
```

This disables the startup script that makes PM2 launch automatically after a reboot.

Later, to **add PM2 back to startup**, run:

```bash
pm2 startup
```

PM2 will usually print another command that you need to copy and run with `sudo`. After that, save your current PM2 process list:

```bash
pm2 save
```

Simple rule:

```bash
pm2 unstartup   # remove PM2 from startup
pm2 startup     # add PM2 back to startup
pm2 save        # save current running apps for reboot
```