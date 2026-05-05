You may want to use these cpu monitoring commands to diagnose what's causing the problem especially if your web-host reports high cpu (ether they alert you by email or you see it on dashboard), usually correlated with a slow website, because the server or Linux is too bogged down to serve the web-site efficiently .

## Bread and butter

See processes taking up CPU ranked from worse to best:
```
ps aux --sort=-%cpu | head -25
```

---

### Real-time CPU usage (live view)

Best first step when something feels slow:

```bash
top
```

- Updates every few seconds
    
- Shows CPU %, memory, load average
    
- Press `P` to sort by CPU (if not already)
    

---

### Better version of top (if installed)

Much easier to read:

```bash
htop
```

- Color-coded, interactive UI
    
- Scroll, search, kill processes (`F9`)
    
- If not installed:
    
    ```bash
    sudo apt install htop
    ```
    

---

### Per-core CPU breakdown

Useful if one core is maxed out:

```bash
mpstat -P ALL 1
```

- Shows CPU usage per core every 1 second
    
- Helps detect single-thread bottlenecks (common with Node/Nginx workers)
    

---

### System-wide bottleneck view

Quick “what’s wrong with my system” command:

```bash
vmstat 1
```

- Shows CPU, memory, IO, processes
    
- Look at:
    
    - `r` (run queue → CPU contention)
        
    - `wa` (IO wait → disk bottleneck)
        

---

### Live process monitoring (lightweight)

Good alternative to `top`:

```bash
top -o %CPU
```

Or limit noise:

```bash
top -n 1 | head -20
```

---

### Memory + CPU together

Sometimes high CPU is actually memory pressure:

```bash
free -h
```

And:

```bash
top
```

→ check if swap is being used heavily

---

### 🔍 Track a specific process (PID)

If you already know the culprit:

```bash
top -p <PID>
```

Or:

```bash
watch -n 1 "ps -p <PID> -o %cpu,%mem,cmd"
```

---

### 🌐 See connections (useful for bot attacks)

High CPU can be traffic-related:

```bash
ss -s
```

Or:

```bash
netstat -an | grep :80 | wc -l
```

---

### 🧠 Quick mental model (when debugging)

- **High CPU + low traffic** → bad code / infinite loop (like your PM2 example)
- **High CPU + many connections** → bots / traffic spike
- **High CPU + high IO wait (`wa`)** → disk bottleneck
- **One core maxed** → single-threaded app issue