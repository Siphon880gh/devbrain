##### After restoring files on a new server

Make sure they have proper ownerships and permissions. Refer to [[Website files and folders with proper ownership and permissions]]

**Concerns?**
On WordPress, needs to write uploads/plugins/themes through PHP-FPM, and PHP-FPM runs as `USER`, so while the instructions above refer to normal websites, it should be fine as well.