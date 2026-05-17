### Using `strace` to Debug High CPU Usage

`strace` is a Linux debugging tool that shows what a running process is doing at the system-call level.

In simple terms, it lets you see what files a process is opening, what network activity it is handling, what errors it keeps hitting, and whether it is stuck repeating the same action over and over.

This is useful when a process has high CPU usage and you do not know why.

For example, if **Nginx** is using too much CPU, `strace` can help you see whether Nginx is:

* Serving too many requests
* Repeatedly looking for missing files
* Getting stuck in redirects or rewrite loops
* Handling compression work
* Being hammered by bots or scrapers

Nginx is just one example. You can use the same method for other Linux processes too.

---

### Install `strace`

`strace` is not installed by default, but it is very useful to have. Sometimes the process causing high CPU usage is a process your server actually needs, so you cannot just stop it. In those cases, `strace` helps you identify the real problem and fix it properly.

```bash
sudo apt update
sudo apt install strace
```


---

### Find the Process ID

First, find the process using high CPU:

```bash
top
```

Look for the process name, such as `nginx`, and note the **PID**.

You can also search for Nginx directly:

```bash
ps aux | grep nginx
```

---

### Run `strace` on That Process

Once you have the PID, attach `strace` to it:

```bash
sudo strace -p PID
```

Replace `PID` with the actual process ID:

```bash
sudo strace -p 12345
```

To save the output to a file:

```bash
sudo strace -p 12345 -o strace-nginx.txt
```

View the trace details:
```
tail -100 strace-nginx.txt
```

From this point on, you can either:
- Analyze the log yourself and try to fix it
- Copy the log to ChatGPT and ask for help analyzing it.

---
### Example Prompt for AI Analysis

After running `strace` on the high-CPU process, copy the output and ask:

```text
Help me analyze why my CPU use is high. Here's a strace of a process __process_name__:

__copy and paste strace output here__
```

---

### My Example

In my case, people were hammering my `devbrain/` coder notes app.

The issue was not expensive compression. I had already set:

```nginx
gzip_comp_level 2;
```

That was reasonable for my server size, so Nginx was not wasting CPU on overly aggressive compression.

The real issue was excessive traffic. `strace` helped confirm that Nginx was actively handling repeated requests instead of being stuck because of one bad setting.
