Compare `nginx -t` with reload and restart. They are not interchangeable.

## `nginx -t` — test / validate only

```bash
sudo nginx -t
```

This checks the config syntax and that included files can be read. It does **not** apply the new config. It does **not** touch running workers or drop connections.

If this fails, do not reload or restart. Fix the config first.

## Reload — apply config without dropping connections

```bash
sudo nginx -s reload
```

or, preferred on most systemd servers:

```bash
sudo systemctl reload nginx
```

Reload tells the already-running master process to load the new config and start new workers. Existing connections finish on the old workers. This is the usual move after a vhost edit.

`systemctl reload` vs `nginx -s reload` is a separate nuance: [[_Configure Site (Nginx Fundamental)]].

## Restart — full process restart

```bash
sudo systemctl restart nginx
```

This stops the process and starts it again. In-flight requests can drop. Use restart when reload is not enough: Nginx will not start, a module/binary changed, or you need a clean process (for example after some OS-level permission or user changes).

Do **not** use restart as the default “I edited a vhost” command.

## Habit

```bash
sudo nginx -t && sudo systemctl reload nginx
```

Test first. Reload if the test passes. Restart only when you need a full process bounce.
