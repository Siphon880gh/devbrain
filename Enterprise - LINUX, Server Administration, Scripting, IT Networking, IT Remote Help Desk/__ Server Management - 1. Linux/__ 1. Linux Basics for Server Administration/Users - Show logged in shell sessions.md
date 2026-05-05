The command is:
```
users
```


The `users` command in Linux shows the currently logged-in users by checking `/var/run/utmp`. When you see:

```
root root root
```

…it means **three sessions are active under the `root` user**. This typically happens when:

1. You have **multiple terminal windows/tabs** open, each logged in as root.
2. Background processes (like SSH, screen, tmux, or sudo sessions) are also running under root.
3. You may have logged in via **multiple methods** — e.g., SSH, direct console, or a pseudo-terminal.
    

To get more detail on these sessions, use:

```bash
who
```


Output could look like (XX.XX.XXX.XX is the IP address of the user's computer origin):
> root@www0:/home/path/to/user/htdocs# who
> root     pts/0        2025-07-06 19:19 (XX.XX.XXX.XX)
>

Or more verbose:

```bash
w
```

This will show:
- Who is logged in
- From where (IP or tty)
- Login time
- What command they're running

Output could look like  (XX.XX.XXX.XX is the IP address of the user's computer origin):
>  19:57:09 up 10 days, 15:29,  1 user,  load average: 0.00, 0.00, 0.00
>  USER     TTY      FROM             LOGIN@   IDLE   JCPU   PCPU  WHAT
>  root              XX.XX.XXX.XX     19:19    5:09m  0.00s  0.02s sshd: root@pts/

If you're trying to figure out **why so many sessions exist**, `w` is your best bet.