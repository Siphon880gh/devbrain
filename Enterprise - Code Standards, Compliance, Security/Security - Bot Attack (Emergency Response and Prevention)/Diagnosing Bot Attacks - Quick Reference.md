For a high level explanation, refer to [[Diagnosing Bot Attacks - Detecting Traffic Bot Problems vs. Other Causes]]

---
## Managing nginx (esp after changing conf / vhost)

```
sudo nginx -t && sudo systemctl reload nginx
```

```
sudo nginx -t && sudo systemctl start nginx
```

```
sudo systemctl stop nginx
```

---

## Checking nginx cpu %

```
ps aux --sort=-%cpu | head -25
```

---

## Core ngxin.conf settings

Modify at
```
vi /etc/nginx/nginx.conf
```

Check at
```
nginx -T > nginx.full.txt
tail nginx.full.txt
```

---

## Logs

Your system might vary:

```
tail -f /var/log/nginx/access.log /var/log/nginx/error.log
```

Here’s bots scanning for vulnerabilities or to identify your app stack (so it can adjust its vulnerability scanning strategies):
![[Pasted image 20260321055631.png]]

---
## See what the hot workers are doing right now

Attach `strace` to one worker for a few seconds. `strace` records the system calls a process is making. ([man7.org](https://man7.org/linux/man-pages/man1/strace.1.html?utm_source=chatgpt.com "strace(1) - Linux manual page"))

GET THE PID for -p at `ps aux --sort=-%cpu | head -25` then:
```
sudo strace -tt -T -p 289756 -o /tmp/nginx-PID.strace
```

Let it run for 5 to 10 seconds, then press `Ctrl+C`, then inspect:
```
tail -100 /tmp/nginx-PID.strace
```

What to look for:

- lots of `accept4` / `recvfrom` / `sendfile` / `writev` = heavy request traffic
- lots of `epoll_wait` = mostly idle, not your main issue
- lots of repeated file opens or stat calls = bad file/path behavior
- lots of upstream socket reads/writes = proxy/backend issue