
### Why Use Child Processes?

In Node.js, long-running or CPU-intensive tasks can block the event loop, stalling your server. To offload such work, you can spawn **child processes**. Common use cases include:

- Server-side rendering (e.g., a prerender script using Puppeteer or Playwright)
- Image or video processing
- Data scraping or transformation
- Worker scripts handling background jobs

Node offers several APIs for this:

- `child_process.spawn()` – great for running binaries or scripts
- `child_process.fork()` – optimized for spawning other Node.js modules with IPC support

---

### Starting a Child Process

Here’s an example of starting a Node.js prerender script as a child process using `spawn`:

```js
const { spawn } = require('child_process');

let prerenderProc = null;

function startPrerender() {
  prerenderProc = spawn('node', ['prerender.js'], {
    stdio: 'inherit', // Pipe child's stdout/stderr to parent
  });

  prerenderProc.on('exit', (code, signal) => {
    console.log(`[Prerender] exited with code ${code}, signal ${signal}`);
  });
}
```

> Tip: If you want to communicate between the parent and child process, use `fork()` instead, which enables IPC messaging.

---

### Why You Must Gracefully Shut Down Child Processes

When your main application shuts down—due to `Ctrl+C`, a system restart, a Docker container stop, etc.—child processes **do not automatically terminate**. If you forget to kill them, you risk:

- **Zombie processes** consuming CPU and memory
- **Port conflicts** (child bound to ports won’t release them)
- **Locked files/resources** lingering after shutdown
- **Broken monitoring / logging** due to orphaned tasks

---

### How to Gracefully Shut Down Child Processes

Here’s a safe and effective shutdown pattern:

#### 1. **Track the Child Globally**

```js
let prerenderProc = null;
```

#### 2. **Send SIGTERM First**

Attempt a soft kill, allowing the child to perform its own cleanup.

```js
if (prerenderProc && !prerenderProc.killed) {
  console.log('[Shutdown] Sending SIGTERM to child process...');
  prerenderProc.kill('SIGTERM');
}
```

#### 3. **Wait for Exit or Force Kill**

Wait up to 5 seconds for a clean exit. If it hangs, send `SIGKILL`.

```js
setTimeout(() => {
  if (prerenderProc && !prerenderProc.killed) {
    console.log('[Shutdown] Force killing child process...');
    prerenderProc.kill('SIGKILL');
  }
  process.exit(0);
}, 5000);
```

#### 4. **Hook Into Process Signals**

Make sure this logic runs on shutdown.

```js
process.on('SIGINT', () => gracefulShutdown('SIGINT'));
process.on('SIGTERM', () => gracefulShutdown('SIGTERM'));
```

**Full Example**

```js
const gracefulShutdown = (signal) => {
  console.log(`\n[${signal}] Starting graceful shutdown...`);

  if (prerenderProc && !prerenderProc.killed) {
    prerenderProc.kill('SIGTERM');

    setTimeout(() => {
      if (!prerenderProc.killed) {
        prerenderProc.kill('SIGKILL');
      }
      process.exit(0);
    }, 5000);
  } else {
    process.exit(0);
  }
};
```


---
### Recommended Signal and Error Handlers

To build a truly robust child process or server runner, you should handle not just shutdown signals (`SIGINT`, `SIGTERM`) but also unexpected errors that could crash the process.

Here’s a complete recommended setup:

```js
// Handle shutdown signals
process.on('SIGINT', () => {
  console.log('[Static HTML Generator] Received SIGINT, shutting down gracefully...');
  process.exit(0);
});

process.on('SIGTERM', () => {
  console.log('[Static HTML Generator] Received SIGTERM, shutting down gracefully...');
  process.exit(0);
});

// Handle unexpected errors
process.on('uncaughtException', (error) => {
  console.error('[Static HTML Generator] Uncaught Exception:', error);
  process.exit(1);
});

process.on('unhandledRejection', (reason, promise) => {
  console.error('[Static HTML Generator] Unhandled Rejection at:', promise, 'reason:', reason);
  process.exit(1);
});
```

#### Why This Matters

|Handler|Purpose|
|---|---|
|`SIGINT`|Captures manual `Ctrl+C` or container stop|
|`SIGTERM`|Captures termination signal from orchestrators (like Docker, systemd)|
|`uncaughtException`|Catches exceptions not wrapped in `try/catch`|
|`unhandledRejection`|Catches `Promise.reject()` calls without a `.catch()`|

---

### Best Practices

- **Contextual Errors**: Always log the signal or error with context so you can trace back root causes later.
- **Avoid Detaching**: Use `detached: false` so the child belongs to the same process group and receives signals.
- **Capture `exit` Events**: Log or act upon child shutdown to aid in debugging.
- **Manage Multiple Children**: If spawning many processes, store them in a list and shut them down in parallel or sequentially.
- **Zombie Processes**: If you're running a long-lived worker or utility script like a static HTML generator, these handlers are essential to avoid silent failures or zombie processes.


---

### Summary

|Task|Action|
|---|---|
|Start child process|Use `spawn()` or `fork()`|
|Track it|Store globally|
|Graceful shutdown|Send `SIGTERM`, then fallback to `SIGKILL`|
|Signal listening|Hook `SIGINT` / `SIGTERM` in the parent|
|Multiple children|Loop over an array and shut down each|

Child processes are powerful—but come with responsibility. Managing their lifecycle properly ensures clean, predictable app behavior across all environments.