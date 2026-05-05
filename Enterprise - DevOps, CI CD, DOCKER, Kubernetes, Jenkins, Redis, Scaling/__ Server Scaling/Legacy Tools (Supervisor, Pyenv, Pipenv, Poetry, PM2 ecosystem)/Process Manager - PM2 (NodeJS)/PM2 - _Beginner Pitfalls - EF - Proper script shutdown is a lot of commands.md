EF = Easily forgotten

---

Let's say you want to stop a script from ever persistently running with pm2:
1. `pm2 list` to identify script name
2. `pm2 stop NAME` to stop the script
3. `pm2 delete NAME` to remove from showing at `pm2 list`
4. You might even delete the script file
5. But don't forget to run `pm2 update`

If you miss these steps, the script will continue to run the next time the server reboots. Even worse, if you deleted the script file without the `pm2 update`, your CPU use might jump to over 100% sustained until you complete the pm2 script shutdown process (this could get your webhost to suspend or ban you because it thinks you're abusing their system). For a case study of the 100% cpu, refer to [[PM2 - _Beginner Pitfalls - Preventing Infinite Restart Loops and High CPU Usage 2 (Script file missing and or pm2 not updated)]]