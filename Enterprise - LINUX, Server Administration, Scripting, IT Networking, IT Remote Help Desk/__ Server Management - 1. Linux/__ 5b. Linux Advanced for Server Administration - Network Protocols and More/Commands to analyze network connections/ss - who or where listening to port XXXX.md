The command:

```bash
sudo ss -tulpn | grep :8080
```

checks whether something on your Linux server is listening on port `8080`.

This is useful when you are running a local app, backend API, reverse proxy target, Docker container, Node.js app, Python app, or any service that should be available on a specific port.

---

## What the command does

```bash
sudo ss -tulpn
```

shows active network sockets.

Then:

```bash
grep :8080
```

filters the output to only show lines that mention port `8080`.

So the full command means:

```txt
Show me all listening TCP/UDP ports, then only show the ones related to port 8080.
```

---

## Breakdown of the command

```bash
sudo
```

Runs the command with admin permissions.

This matters because without `sudo`, Linux may hide the process name or PID.

---

```bash
ss
```

`ss` stands for **socket statistics**.

It is the modern replacement for older commands like:

```bash
netstat
```

---

```bash
-t
```

Shows **TCP** sockets.

TCP is commonly used for web servers, APIs, databases, SSH, and most app ports.

---

```bash
-u
```

Shows **UDP** sockets.

UDP is used by some DNS, VPN, streaming, and real-time services.

---

```bash
-l
```

Shows only **listening** ports.

A listening port means a program is waiting for incoming connections.

---

```bash
-p
```

Shows the **process** using the port.

Example:

```txt
users:(("node",pid=12345,fd=22))
```

That tells you a Node.js process is using the port.

---

```bash
-n
```

Shows numeric addresses and ports.

Without `-n`, Linux may try to resolve names, which can make the command slower or less direct.

---

## Example output

You might see something like:

```txt
tcp   LISTEN 0 511 0.0.0.0:8080 0.0.0.0:* users:(("node",pid=12345,fd=22))
```

This means:

```txt
A TCP service is listening on port 8080.
The service is available on all network interfaces.
The process using it is node.
The process ID is 12345.
```

---

## Common address meanings

```txt
127.0.0.1:8080
```

The service is only listening locally.

This is common when Nginx reverse proxies to an app:

```nginx
proxy_pass http://127.0.0.1:8080;
```

External visitors cannot directly access port `8080`.

---

```txt
0.0.0.0:8080
```

The service is listening on all IPv4 interfaces.

This means it may be reachable externally if your firewall and hosting provider allow it.

---

```txt
[::]:8080
```

The service is listening on IPv6.

Depending on system settings, this may also cover IPv4.

---

## Useful variations

Check port `3000`:

```bash
sudo ss -tulpn | grep :3000
```

Check port `5000`:

```bash
sudo ss -tulpn | grep :5000
```

Check only TCP listening ports:

```bash
sudo ss -tlpn
```

Check all listening ports:

```bash
sudo ss -ltnp
```

A cleaner way to check one exact port:

```bash
sudo ss -ltnp 'sport = :8080'
```

---

## When to use this

Use this command when you want to know:

```txt
Is my app actually running?
Which port is it listening on?
Is it listening on localhost or all interfaces?
Which process is using the port?
What PID should I restart or kill?
```

For example, if Nginx is supposed to proxy to:

```nginx
proxy_pass http://127.0.0.1:8080;
```

then this command helps confirm that something is actually running on port `8080`:

```bash
sudo ss -tulpn | grep :8080
```

If there is no output, nothing is listening on that port.
