## General errors pathing (NOT recommended)

Logs usually located
- **Standard Output (logs):** `~/.pm2/logs/app-out.log`
- **Standard Error (error logs):** `~/.pm2/logs/app-error.log`

Unless you specified the log path 

```
pm2 start app.js --interpreter /root/.nvm/versions/node/v22.8.0/bin/node --env production --no-daemon --log /path/to/your/logfile.log
```

---

## General errors terminal (NOT recommended)
```
pm2 logs
```

That will in real time:
```
**[TAILING] Tailing last 15 lines for [all] processes (change the value with --lines option)**

/root/.pm2/pm2.log last 15 lines:
...
```

However this doesn't catch app specific errors, which is usually the case. So the next section is more recommended.

---

## App specific errors (RECOMMENDED):

```
pm2 logs --lines 100 | grep -i "APP_NAME"
```