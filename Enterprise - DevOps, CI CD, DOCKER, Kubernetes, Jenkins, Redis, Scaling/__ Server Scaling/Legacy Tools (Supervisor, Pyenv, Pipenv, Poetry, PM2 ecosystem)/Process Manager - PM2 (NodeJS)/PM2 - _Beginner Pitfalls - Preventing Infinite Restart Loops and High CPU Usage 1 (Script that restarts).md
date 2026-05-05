**Fundamental: Preventing Infinite Restart Loops and High CPU Usage in PM2**

**Caveat**: This is only one pitfall to the infinite loop. There is more than one. Look into the note's folder.

---

When running apps or NodeJS Script files with PM2, the key question is simple: **does the script exit?** If it exits, PM2 starts it again. If it stays alive, PM2 leaves it alone.

That is why a script like `console.log("hi")` is bad to keep under PM2. It has no `listen`, `setInterval`, `setTimeout`, or other waiting mechanism, so it finishes almost immediately. PM2 then restarts it again and again, which can create a very fast restart loop, flood logs, and increase CPU usage (especially as the log file becomes larger in size). At first CPU doesn't spike, but after a few days, depending on the hardware and how quickly the script keeps restarting, you may see CPU usage climb to around 10% more. 

Here's an example after 3 days jumped to 10%, then immediately closing the hello.js script:
![[Pasted image 20260420062619.png]]

By contrast, a script with an active waiting mechanism is fine because it keeps the Node.js event loop alive. That means the process does not exit, so PM2 does not restart it over and over.

This is okay - `some_pm2_script.js`:

```js
setInterval(() => {
  console.log("hi");
}, 1000);
```

^ That script stays in one running process and logs once every second. It does **not** restart so many cycles within milliseconds.

This is NOT okay - `some_pm2_script.js`:
```js
console.log("hi");
```

A similar example is an Express server using `app.listen(...)`. The server stays alive waiting for requests, so PM2 does not keep restarting it.

The rule is simple: **script exits = PM2 restarts it. Script stays alive = PM2 does not.** Understanding that difference helps prevent infinite restart loops, runaway logs, and unnecessary CPU usage.