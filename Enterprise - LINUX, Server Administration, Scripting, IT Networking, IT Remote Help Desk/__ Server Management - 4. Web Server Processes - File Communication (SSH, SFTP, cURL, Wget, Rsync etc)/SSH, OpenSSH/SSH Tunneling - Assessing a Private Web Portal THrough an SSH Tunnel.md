
You can block a web portal like **cPanel, CloudPanel, Webmin, a Node.js dashboard, or a Flask/FastAPI app** from being accessed directly through the public internet.

Instead of opening the portal in a public browser URL, you connect to the remote server through **SSH** from your local machine and create a tunnel from the server’s web portal port to your own `localhost` port.

This lets you open the remote portal safely from your local browser.

---

## Example remote ports

On the remote server, you may have web apps running on ports like:

```
3000
```

For a Node.js or Next.js app.

```
5000
```

For a Python app, such as Flask, FastAPI, or a Gunicorn app.

```
8443
```

For CloudPanel, which commonly uses port `8443`.

---

## SSH tunnel format

Run this command from your **local machine terminal**, not from inside the remote server:
```
ssh -L LOCAL_ASSIGNED_PORT:REMOTE_HOST:REMOTE_PORT user@server_ip
```

This means:
```
localhost:LOCAL_ASSIGNED_PORT on your computer
        ↓ through SSH
REMOTE_HOST:REMOTE_PORT on the remote server
```

---

## Example: tunnel into CloudPanel

```
ssh -L 8443:1.22.333.444:8443 root@1.22.333.444
```

Yes, the IP address looks redundant because you are using the same server IP twice.

The first part:
```
8443:1.22.333.444:8443
```

means:
```
local port 8443 → remote server IP 1.22.333.444 → remote port 8443
```

The last part:
```
root@1.22.333.444
```

means SSH into the server as root

Your terminal appears to have SSH’d in. You are keeping this connection opened by not logging out or closing the SSH terminal.

SSH terminal must remain opened for the localhost:REMOTE_PORT to work on web browser


---

## More common version

Usually, you can use `127.0.0.1` for the remote host:
```
ssh -L 8443:127.0.0.1:8443 root@1.22.333.444
```

This is often easier to type. If it gets confusing, think:
```
ssh -L ... root@1.22.333.444
```

-L means local port forwarding

The first double colon separated value is the port you want to map from your local machine (it’s right after -L)

You’re still going SSH in. SSH terminal must remain opened for the localhost:LOCAL_ASSIGNED_PORT to work on web browser

---

## Open it in your browser

After the tunnel is running, open this on your local machine:
```
https://localhost:8443
```

Or using the generic format:
```
http://localhost:LOCAL_PORT
```

For CloudPanel, use:
```
https://localhost:8443
```

You may see a browser certificate warning because the certificate was not issued for `localhost`. That can be normal for private admin panels.