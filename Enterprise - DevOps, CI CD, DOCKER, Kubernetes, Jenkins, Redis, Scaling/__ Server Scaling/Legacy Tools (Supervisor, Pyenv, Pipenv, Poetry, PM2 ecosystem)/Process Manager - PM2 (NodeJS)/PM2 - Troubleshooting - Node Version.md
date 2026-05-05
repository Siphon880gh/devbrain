If you suspect your script is not running because of a NodeJS incompatibility issue, make sure to install another node version with NVM which will create standalone node interpreter executables.

Run the pm2 like this with --no-daemon so all terminal output is bought to the foreground and run with --log

By including `--log` without specifying a path, it ensures that PM2 enables logging, but it will still use the default logging locations:

```
pm2 start app.js --interpreter /root/.nvm/versions/node/v22.8.0/bin/node --env production --no-daemon --log
```

Logs usually located
- **Standard Output (logs):** `~/.pm2/logs/app-out.log`
- **Standard Error (error logs):** `~/.pm2/logs/app-error.log`

Unless you specified the log path 

```
pm2 start app.js --interpreter /root/.nvm/versions/node/v22.8.0/bin/node --env production --no-daemon --log /path/to/your/logfile.log
```

NOTE: If using cluster (instead of the default fork for exec_mode), interpreter is ignored. To adjust the node version for cluster mode, refer to [[PM2 Cluster mode's node path]]