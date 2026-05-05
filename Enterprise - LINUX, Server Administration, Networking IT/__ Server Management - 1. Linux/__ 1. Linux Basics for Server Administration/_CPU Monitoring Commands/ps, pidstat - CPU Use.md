```
ps aux --sort=-%cpu | head -25
```

For example, this shows that the nginx worker processes are abnormally at 96% CPU (I was getting DDoS attacks when Cloudflare wasn't working)
![[Pasted image 20260321055000.png]]

**1b**. Polling:
```
pidstat -p $(pgrep -d, nginx) 1
```


