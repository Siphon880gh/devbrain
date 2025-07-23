To change the **default port** when starting a **Next.js production server**, you can do it in a few different ways depending on how you're starting the server.

How is this useful? You may have multiple next js apps running on the same server, especially if it's VPS or dedicated server.

---

### ✅ Method 1: Using the `-p` flag

If you're using the `next start` command directly, you can specify a custom port like this:
```
next start -p 4000
```

This starts your production server on port `4000` instead of the default `3000`.

---

### ✅ Method 2: Setting the `PORT` environment variable

You can set the `PORT` environment variable before running the command:

#### Unix/macOS:
```
PORT=4000 next start
```

#### Windows (CMD):
```
set PORT=4000 && next start
```

#### Windows (PowerShell):
```
$env:PORT=4000; next start
```