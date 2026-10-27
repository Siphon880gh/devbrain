Follow a systemd service in the journal:

```bash
journalctl -u nginx -f
```

Remember `-u`, not `--unit`, when you are tired. They are the same flag (`-u` is `--unit`). `-f` is follow, like `tail -f`.

This shows **service** events: start, reload, restart, config errors Nginx sent to stderr, crashes. It is not the same as the access/error log files.

Access and error files: [[Logging - Determining where logging is]] and [[Linux Logging - Paths and Timestamp Comparison]].

Other units use the same shape:

```bash
journalctl -u ssh -f
journalctl -u fail2ban -f
```

Without `-f` you get history. Add `-n 100 --no-pager` when you want the last lines and then your prompt back.
