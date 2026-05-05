When something breaks, logs are one of the fastest ways to find the cause. Instead of reading the entire file, search for **keywords tied to failures** like `error`, `failed`, `denied`, or `permission`.

---

## 🧭 Manual Search vs CLI (Quick Tip)

You can open logs directly and search manually. For example, in `vim`:

- Type `/permission` or `/error` to search
    
- Press `n` to jump to the next match
    

This is useful for deeper inspection.  
👉 But the CLI method is faster when you just want a **quick signal**.

---

## ✅ Core Pattern (Fast Check)

```bash
tail -n 200 /path/to/logfile.log | grep -Ei "error|fail|failed|denied|permission"
```

### Why this works:

- `tail -n 200` → focuses on recent activity (where failures usually occur)
    
- `grep -Ei` → filters for multiple failure keywords (case-insensitive)
    

👉 In seconds, you’ll know if logs already point to the issue.

---

## 🚀 Common Variations

### 1. Real-time monitoring

```bash
tail -f /path/to/logfile.log | grep -Ei "error|fail|failed|denied|permission"
```

Use this while restarting a service:

```bash
sudo systemctl restart your-service
```

---

### 2. Search entire log

```bash
grep -Ei "error|fail|failed|denied|permission" /path/to/logfile.log
```

---

### 3. Add context around matches

```bash
grep -Ei -C 3 "error|fail|failed|denied|permission" /path/to/logfile.log
```

---

## 🎯 Choosing Keywords

Start broad, then narrow down.

- General:
    
    ```bash
    error|fail|failed|warning
    ```
    
- Permissions:
    
    ```bash
    permission|denied|access|not permitted
    ```
    
- File/system:
    
    ```bash
    cannot|unable|missing|no such file
    ```
    
- Network:
    
    ```bash
    refused|timeout|unreachable
    ```
    

---

## ⚡ Use as a Quick CLI Check (or Automation)

You can use this as a simple health check.

```bash
if tail -n 200 /path/to/logfile.log | grep -qiE "error|fail|failed|denied|permission"; then
  echo "Issue detected"
else
  echo "No obvious issue found"
fi
```

👉 Useful for:

- Post-deploy checks
    
- Cron monitoring
    
- Quick debugging loops
    

---

## 🧩 Example: MongoDB Permission Issue

If MongoDB is not running and you suspect permissions:

### Quick check (your example)

```bash
tail /var/log/mongodb/mongod.log | grep Permission
```

### Better (more reliable)

```bash
tail -n 200 /var/log/mongodb/mongod.log | grep -i permission
```

### Broader search

```bash
grep -Ei "permission|denied|failed|unlink" /var/log/mongodb/mongod.log
```

### What you might see:

- `Permission denied`
    
- `Failed to unlink socket file`
    
- `Operation not permitted`
    

👉 These indicate filesystem ownership or access issues.

---

## 🔄 Simple Debug Workflow

```bash
# 1. Restart service
sudo systemctl restart your-service

# 2. Check logs quickly
tail -n 200 /var/log/your-service.log | grep -Ei "error|fail|denied"

# 3. Expand if needed
grep -Ei -C 5 "error|fail|denied" /var/log/your-service.log
```

---

## 📌 Key Takeaway

- Logs are noisy → filter aggressively
    
- Keywords surface most real issues
    
- CLI search is faster than manual scanning
    
- Works across any service (MongoDB, Nginx, Flask, MySQL, etc.)
    

👉 You’re not reading logs—you’re **querying them for failures**.