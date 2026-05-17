
Below is a curated Debian 12-friendly list of lightweight tools for monitoring and auditing server behavior.

The focus is on production-friendly CLI utilities that help you investigate suspicious activity, debug high CPU usage, trace processes, analyze network traffic, and audit file changes.

Each tool category is also split into:

- **Usually installed**
- **Usually not installed**

This was based on a Debian 12 server running CloudPanel in **April 2026**. Your Debian 12 server may be different when it comes to which packages are already installed.

---

# 1. System Call and Process Tracing

## Usually already installed

### `ps`, `top`, etc

```bash
sudo apt install procps
```
^ Namesake: `procps` stands for **processes**. It provides command-line utilities for monitoring system processes and resources by interacting with the `/proc` filesystem.

Common tools included:

- `ps` → snapshot of running processes
    
- `top` → live process and CPU viewer
    
- `free` → memory usage
    
- `kill` → terminate processes
    
- `pgrep` → search for process IDs by name
    
- `vmstat` → virtual memory and system performance statistics


These utilities are foundational for Linux performance analysis, troubleshooting, and process management.


### `lsof`

```bash
sudo apt install lsof
```

Shows open files, sockets, deleted files still held open, and which process is using a port.

Useful for:

- finding which service owns a port
    
- detecting suspicious outbound connections
    
- finding deleted files still consuming disk space
    
- inspecting open file handles
    

---

### `htop`

```bash
sudo apt install htop
```

Friendlier live process viewer than `top`.

Useful for:

- quickly sorting by CPU or memory
    
- viewing process trees
    
- identifying runaway worker processes
    
- interactively killing tasks
    
---

## Usually not installed

### `strace`

```bash
sudo apt install strace
```

Traces system calls from a process. Useful when Nginx, PHP-FPM, SSH, or another service has high CPU, hangs, or repeatedly opens suspicious files.

---

### `auditd`

```bash
sudo apt install auditd audispd-plugins
```

Kernel-level auditing for:

- sensitive file access
    
- command execution
    
- privilege escalation
    
- permission changes
    
- authentication events
    

Very useful for forensic investigation and compliance logging.

---

# 2. Network Traffic Analysis

## Usually already installed

### `ss`

```bash
sudo apt install iproute2
```

Modern replacement for many `netstat` use cases.

Useful for:

- viewing listening ports
    
- checking established connections
    
- identifying suspicious remote IPs
    
- associating sockets with processes
    

### `tcpdump`

```bash
sudo apt install tcpdump
```

Captures packets directly from the command line.

Useful for:

- analyzing bot traffic
    
- checking direct-to-IP attacks
    
- debugging DNS issues
    
- inspecting suspicious outbound traffic
    
- verifying whether requests are real browser traffic
    

Very powerful while remaining lightweight.


---

## Usually not installed

### `iftop`

```bash
sudo apt install iftop
```

Live bandwidth viewer by connection.

Useful for:

- identifying traffic spikes
    
- seeing which IPs consume the most bandwidth
    
- quickly spotting abusive clients
    

---

### `nethogs`

```bash
sudo apt install nethogs
```

Shows bandwidth usage by process instead of by connection.

Useful when:

- CPU or bandwidth spikes occur
    
- you need to know which service is responsible
    
- a process is unexpectedly uploading data
    

---

### `conntrack`

```bash
sudo apt install conntrack
```

Inspects Linux connection tracking tables.

Useful for:

- firewall debugging
    
- NAT troubleshooting
    
- detecting excessive connection counts
    
- investigating SYN flood style behavior
    

---

# 3. File Integrity Monitoring

## Usually already installed


### `debsums`

```bash
sudo apt install debsums
```

Verifies installed Debian package files against package checksums.

Useful for:

- detecting modified system binaries
    
- checking for tampered package files
    
- verifying package integrity after compromise


---

## Usually not installed

### `aide`

```bash
sudo apt install aide
```

File integrity monitoring tool.

Creates a baseline of important files and later reports modifications.

Useful for monitoring:

- `/etc`
    
- web roots
    
- scripts
    
- binaries
    
- cron jobs
    
- SSH configuration
    

---

### `inotify-tools`

```bash
sudo apt install inotify-tools
```

Provides real-time filesystem monitoring using Linux inotify.

Useful for:

- watching upload directories
    
- monitoring config changes
    
- detecting unexpected file creation
    
- triggering alerts/scripts when files change
    

---

# 4. Rootkit and Malware Indicators

## Usually already installed

None worth assuming on a minimal Debian 12 VPS.

---

## Usually not installed

### `chkrootkit`

```bash
sudo apt install chkrootkit
```

Scans for signs of known rootkits.

Useful as a quick first-pass security check after suspected compromise.

---

### `rkhunter`

```bash
sudo apt install rkhunter
```

Checks for:

- rootkit indicators
    
- suspicious files
    
- hidden processes
    
- insecure permissions
    
- known malware signatures
    

Good periodic auditing tool for VPS environments.

**Note:** Rootkit scanners can generate false positives. Treat findings as investigation leads, not definitive proof.

---

# 5. Login, User, and Command Auditing

## Usually installed

### `last`, `lastb`, `who`, `w`

```bash
sudo apt install util-linux
```

**Note**: You usually **do not** check whether `util-linux` is installed by running `util-linux --version` or `whereis util-linux` because `util-linux` is a package name only here, not usually a command you run directly. Different Linux distributions may also report package paths differently. Instead, check for one of the actual commands that comes from `util-linux`, such as `last --version`, `who --version`, `w --version`, `lsblk --version`

- **Login history**
    - Shows previous successful logins, reboots, and session durations.
    - Commands:
        ```bash
        last
        last -a
        last -n 20
        ```
        
- **Failed login attempts**    
    - Shows failed login attempts, if your system is configured to record them.
    - Commands:
        ```bash
        sudo lastb
        sudo lastb -a
        sudo lastb -n 20
        ```
        
- **Currently logged-in users**
    - Shows who is logged in right now, their terminal, login time, and source.
    - Commands:
        ```bash
        who
        w
        users
        ```
        
- **Active SSH sessions**
    - Shows current remote sessions and helps identify where users are connected from.
    - Commands:
        ```bash
        who
        w
        ss -tnp | grep ssh
        ps aux | grep sshd
        ```

Many of these commands show an event timestamp, such as when a user logged in, logged out, or attempted to connect. To compare those timestamps against the server’s current time, run `data`.

Helpful during SSH abuse investigations.

---

## Usually not installed

### `acct`

```bash
sudo apt install acct
```

Enables process accounting.

Useful for:
- tracking executed commands    
- auditing user activity
- reviewing historical process usage
- investigating suspicious shell activity

---

# 6. Service and Log Investigation

## Usually already installed

### `journalctl`

```bash
sudo apt install systemd
```

Reads and filters systemd logs.

Useful for:

- SSH logs
    
- Nginx logs
    
- PHP-FPM crashes
    
- Fail2Ban activity
    
- cron jobs
    
- kernel warnings
    
- service failures
    

One of the most important built-in troubleshooting tools on Debian.

---

## Usually not installed

### `logwatch`

```bash
sudo apt install logwatch
```

Generates readable summaries from logs.

Useful for:

- daily server summaries
    
- spotting repeated attacks
    
- reviewing authentication failures
    
- reducing manual log scanning
    

---

### `lnav`

```bash
sudo apt install lnav
```

Interactive log viewer.

Useful for:

- browsing large logs quickly
    
- filtering errors
    
- searching Nginx/access/auth logs
    
- correlating events across multiple logs
    

Much easier than manually grepping giant log files.

---

# 7. Firewall and Ban Visibility

## Usually already installed

### `nft`

```bash
sudo apt install nftables
```

Usage is with the command:
```
nft
```


eg. `nft list ruleset`

Modern Linux firewall framework.

Useful for:

- viewing active firewall rules
    
- checking blocked traffic
    
- inspecting packet filtering behavior
    
- replacing older iptables setups
    


---

## Usually not installed

### `fail2ban`

```bash
sudo apt install fail2ban
```

Installation alone may not be enough for Fail2Ban to work correctly. Depending on your server, you may need extra configuration, such as setting the correct jail, backend, and log source. For the full setup guide, see: [[_PRIMER - Fail2Ban]]

Usage is with the command:
```
fail2ban-client
```

Monitors logs and bans abusive IPs automatically.

Common protections include:
- SSH brute-force attacks
- web login abuse
- repeated authentication failures
- suspicious request patterns

Works by reading logs and dynamically updating firewall rules.

---

# Lightweight Recommended Starter Stack

For a production server, this is a strong lightweight baseline installation command (even those usually installed added here in case you're using a different distro):

```bash
sudo apt install strace lsof htop tcpdump iftop nethogs auditd aide debsums fail2ban lnav
```

This provides:
- process tracing
- network visibility
- log investigation
- file integrity monitoring
- bandwidth analysis
- automated IP banning

…without adding excessive overhead to the server.