When checking logs in PM2, the easiest place to start is with the app itself. Use `pm2 logs <app-name>` to watch that process in real time. That is usually the most useful command because it keeps you focused on one app instead of mixing everything together.

If you want to see logs for everything PM2 is running, use `pm2 logs`. This can be helpful, but it often gets noisy when you have multiple processes.

PM2 also writes logs to files, usually in `$HOME/.pm2/logs`. By default, each app gets two main log files:

- Standard output: `~/.pm2/logs/<app-name>-out.log`
- Standard error: `~/.pm2/logs/<app-name>-error.log`

That means you can also inspect logs directly with tools like `tail -f` or `less` if you want more control.

If you need a quick overview of an app, `pm2 show <app-name>` is useful because it shows runtime details along with the log paths.

If you only want recent output, use `pm2 logs --lines 100`. And if you really need to filter from the terminal, you can pipe that output into `grep`, though that is usually optional since `pm2 logs <app-name>` already narrows things down well.

Example of starting with a custom log path:

```bash
pm2 start app.js \
  --interpreter /root/.nvm/versions/node/v22.8.0/bin/node \
  --env production \
  --log /path/to/your/logfile.log
```

A simple rule of thumb is: start with `pm2 logs <app-name>`, check `pm2 show <app-name>` if you need more detail, and go into `~/.pm2/logs` if you want the raw files.