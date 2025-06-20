**Accessing Your Heroku Dyno: `heroku run` vs. `heroku ps:exec`**

Heroku dynos are ephemeral containers that run your application code in the cloud. Sometimes you need a quick, interactive shell to poke around—whether it’s diagnosing an issue, inspecting files, or running one-off commands. Heroku offers two primary ways to get shell access to a dyno:

1. **`heroku run bash`** – Spins up a new, one-off dyno just to run your shell session.
    
2. **`heroku ps:exec`** – Opens an SSH tunnel into an existing, running dyno.
    

---

## 1. One-Off Shell with `heroku run bash`

```bash
# Launches a new dyno, drops you into bash on that dyno
heroku run bash --app APP_NAME
```

- **What it does:** Provisions a fresh dyno, boots your app slug, then runs `bash`.
    
- **Common uses:**
    
    - Inspecting environment variables (`printenv` or `env`)
        
    - Examining temporary files or log output
        
    - Running database migrations or one-off scripts
        
- **Notes:**
    
    - Every time you push code, Heroku rebuilds and installs dependencies—so running `npm install` here isn’t necessary.
        
    - Because you’re on a brand-new dyno, any files you create or changes you make disappear once you exit the shell.
        
    - Editors like `vi` or `vim` are not available; stick to `cat`, `less`, `nano` (if installed), or copy/paste.
        

---

## 2. SSH into a Running Dyno with `heroku ps:exec`

Heroku’s `ps:exec` feature lets you open an SSH session directly into a dyno that’s already running your app—handy for live debugging or inspecting the exact environment your users see.

### 🔧 Setup

1. **Install the plugin (if needed):**
    
    ```bash
    heroku plugins:install @heroku-cli/plugin-ps-exec
    ```
    
2. **Enable Dyno SSH for your app:**
    
    ```bash
    heroku ps:exec:enable --app APP_NAME
    ```
    
3. **Ensure you’re on a Hobby or Performance dyno** (SSH into Free dynos is not supported).
    

### 🚀 Usage

```bash
# Lists all running dynos for your app
heroku ps --app APP_NAME

# Open an SSH session to a specific dyno (e.g. web.1)
heroku ps:exec --app APP_NAME --dyno web.1
```

Once connected, you’ll get a prompt inside that dyno:

```bash
~ $ pwd
/app
~ $ ls -la
total 64
drwxr-xr-x  8 root root 4096 Jun 20 00:00 .
...
~ $ echo $NODE_ENV
production
```

- **What it does:** Attaches you to the live dyno, so you see exactly what’s running in production.
    
- **Common uses:**
    
    - Live tailing logs or inspecting running processes
        
    - Checking environment/config files that aren’t part of your Git repo
        
    - Running diagnostic tools that need the full production context
        
- **Caveats:**
    
    - Any commands you run affect the live dyno—be cautious!
        
    - The filesystem is still ephemeral; changes won’t persist across dyno restarts.
        
    - Resource limits (memory/CPU) are the same as the running dyno—heavy commands may crash it.
        

---

## Quick Comparison

|Feature|`heroku run bash`|`heroku ps:exec`|
|---|---|---|
|Dyno instance|New, one-off dyno|Existing, live dyno|
|Persistence|Ephemeral; destroyed on exit|Ephemeral; but reflects current state|
|Risk to production|None (separate dyno)|High (affects live dyno)|
|Use cases|One-off scripts, migrations, temp debug|Live debugging, config inspection|
|Required dyno tier|Any|Hobby/Performance or above|

---

### Summary

- **Use `heroku run bash`** when you want a clean, safe environment that won’t impact production.
    
- **Use `heroku ps:exec`** when you need to dive into a running dyno and inspect the real, live environment your users interact with.
    

Both commands give you valuable shell access—pick the one that best fits your debugging or maintenance task!