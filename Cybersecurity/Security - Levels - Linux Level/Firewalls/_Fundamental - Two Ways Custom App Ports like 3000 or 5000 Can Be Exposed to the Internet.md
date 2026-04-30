
A custom app port like `5000` can be exposed publicly in two common ways.

### Option 1: No firewall is blocking it

If your app listens on all network interfaces:

```bash
flask run --host=0.0.0.0 --port=5000
```

or:

```bash
gunicorn --bind 0.0.0.0:5000 app:app
```

Then port `5000` may be reachable from the internet **if no firewall is blocking it**.

This is often the “default danger” on a new server: the app is listening publicly, and there is no active firewall rule stopping outside traffic.

### Option 2: UFW is enabled and port `5000` is allowed

If UFW is active, then the app port usually needs an allow rule before outside visitors can reach it:

```bash
ufw allow 5000
```

You can check UFW status with:

```bash
ufw status
```

If you see something like this:

```bash
5000/tcp ALLOW Anywhere
```

Then port `5000` is publicly allowed through the firewall.

### Safer Default for Reverse Proxy Setups

For most Nginx or Apache reverse proxy setups, do **not** expose `5000` publicly.

Instead, bind the app to localhost:

```bash
gunicorn --bind 127.0.0.1:5000 app:app
```

Then let Nginx proxy to it internally:

```nginx
proxy_pass http://127.0.0.1:5000;
```

Simple rule:

> `0.0.0.0:5000` means potentially public. `127.0.0.1:5000` means local-only.