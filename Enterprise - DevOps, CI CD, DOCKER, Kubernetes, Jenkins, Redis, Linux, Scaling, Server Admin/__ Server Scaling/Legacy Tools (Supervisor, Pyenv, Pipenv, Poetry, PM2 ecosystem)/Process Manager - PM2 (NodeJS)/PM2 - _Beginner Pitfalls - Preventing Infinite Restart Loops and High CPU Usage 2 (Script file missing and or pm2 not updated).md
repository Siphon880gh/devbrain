**Fundamental: Preventing Infinite Restart Loops and High CPU Usage in PM2**

**Caveat**: This is only one pitfall to the infinite loop. There is more than one. Look into the note's folder.

---

Let's say you've stopped then deleted a script from pm2 list:
1. `pm2 list` to identify script name
2. `pm2 stop NAME` to stop the script
3. `pm2 delete NAME` to remove from showing at `pm2 list`
4. You might even delete the script file
   
The **server reboots**. The pm2 services starts up. But now your server is overwhelmed.

When you inspect closer, you see now there is a `/usr/local/lib/node_modules/pm2/lib/ProcessContainerFork.js` process that's running over 100% as shown by a `ps aux --sort=-%cpu | head -25`:
![[Pasted image 20260420072239.png]]

This is because the shut off process is not entirely done yet. Even when `pm2 list` no longer showed the process, without running `pm2 update`, the daemon isn’t fully refreshed, so it may keep trying to manage something that no longer exists. Run this command:
```
pm2 update
```

The full shut off process involves running `pm2 update` at the end!