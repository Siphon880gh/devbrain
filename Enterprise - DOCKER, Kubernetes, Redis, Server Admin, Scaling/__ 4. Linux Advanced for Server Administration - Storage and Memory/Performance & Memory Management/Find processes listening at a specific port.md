Find processes listening at a specific port
```
ps aux | grep USER; ps aux | grep 5001
```

Notice it's a command pipe separated by a semi-colon, followed by another command pipe. Had we grepped for just the port number, then the header row wouldn't have shown up. But since we grepped for the USER column first, the header column will show up before the port number greps

For information on the column names, refer to [[Audit how much memory a process uses]]