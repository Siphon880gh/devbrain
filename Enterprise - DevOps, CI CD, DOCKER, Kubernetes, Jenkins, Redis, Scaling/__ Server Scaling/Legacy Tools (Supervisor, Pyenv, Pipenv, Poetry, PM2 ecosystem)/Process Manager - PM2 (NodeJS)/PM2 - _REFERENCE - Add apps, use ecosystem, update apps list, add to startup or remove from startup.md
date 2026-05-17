PM2 can automatically restart your Node.js apps when the server reboots. This is useful for production apps because your apps can come back online after a restart without you manually starting them again.

PM2 startup applies to the apps currently managed by PM2 — the ones you see when you run:

```bash
pm2 list
```

You can add apps to that list one at a time:

```bash
pm2 start server.js --name my-app
```

Or you can define multiple apps in an `ecosystem.config.js` file:

```bash
pm2 start ecosystem.config.js
```

Then save the current PM2 process list:

```bash
pm2 save
```

To **remove PM2 from startup**, run:

```bash
pm2 unstartup
```

This disables the startup script that makes PM2 launch automatically after a reboot.

Later, to **add PM2 back to startup**, run:

```bash
pm2 startup
```

PM2 will usually print another command that you need to copy and run with `sudo`. After that, save your current PM2 process list again:

```bash
pm2 save
```

Simple rule:

```bash
pm2 start app.js              # add an app to PM2
pm2 start ecosystem.config.js # add apps from a config file
pm2 save                      # save the current PM2 list
pm2 startup                   # enable PM2 on server reboot
pm2 unstartup                 # remove PM2 from server startup
```