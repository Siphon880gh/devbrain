**Title:** `exec` in Bash: What It Does and When to Use It

**Introduction:**  
In Bash scripting, the `exec` command is often misunderstood. Unlike most commands, `exec` doesn't just run a program — it **replaces** the current shell process with a new one. This can be powerful when used intentionally but problematic if used incorrectly.

> Do not confuse with exec() in PHP and NodeJS

---

### 🔍 What `exec` Does

When you run:

```bash
exec some_command
```

The shell process is **terminated** and replaced by `some_command`. No lines after `exec` will be executed.

---

### ✅ When to Use `exec`

1. **Container/Process Startup (e.g., Docker)**
    
    - Replace the container’s PID 1 process to ensure proper signal handling.
        
    - Example:
        
        ```bash
        exec node server.js
        ```
        
2. **Process Hand-off**
    
    - When you want the script to hand over control to another process entirely (e.g., replacing the login shell).
        
    - Example:
        
        ```bash
        exec bash
        ```
        
3. **Avoiding Extra Processes**
    
    - `exec` prevents creating a child process, saving resources.
        

---

### ⚠️ When _Not_ to Use `exec`

- ❌ If you want to continue running additional lines after a command.
    
- ❌ If you need to inspect the result (exit code) of a command.
    

---

### Summary

|Use Case|Use `exec`?|
|---|---|
|Replace shell with new process|✅ Yes|
|Check exit status|❌ No|
|Run a sequence of commands|❌ No|
|Start a long-lived foreground process (like in Docker)|✅ Yes|
