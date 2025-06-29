Want your Python app to always run on a specific port (e.g., `8001`) — even after crashes or restarts? Here's how to do it using a `.sh` startup script and **Supervisor** on a Linux server.

This setup:

- Ensures your app auto-restarts if it fails
    
- Launches your Python script from a `.sh` file
    
- Uses `pyenv` to manage your Python version
    
- Runs the app at a specific port (like `8001`)
    
- Works great for production environments
    

---

## 🚀 Deploying `abc123` with Supervisor (Production Setup)

Ensure your Python app runs continuously and restarts if it crashes using **Supervisor**.

---

## 📁 1. Create Startup Script

Set up a shell script that activates `pyenv`, installs dependencies, and starts the app.

### ➤ Create Script Directory

```bash
sudo mkdir -p /opt/abc123
```

### ➤ Create Script

```bash
sudo vi /opt/abc123/start_abc123.sh
```

Paste:

```bash
#!/bin/bash
set -e

cd /home/path/to/app/abc123

export PATH="$HOME/.pyenv/bin:$PATH"
eval "$(pyenv init -)"
eval "$(pyenv virtualenv-init -)"

export PYENV_VERSION=3.8.18
pip install -r requirements.txt

exec python run.py --port 8001
```

Or see [Final Working Script](https://chatgpt.com/c/68613e61-caf4-800f-9e29-cbd42565ec7e#-11-final-working-script) below for a more robust version.

### ➤ Make Executable

```bash
sudo chmod +x /opt/abc123/start_abc123.sh
```

---

## ⚙️ 2. Set Up Supervisor

### ➤ Install

```bash
# Ubuntu/Debian
sudo apt-get install supervisor

# CentOS/RHEL
sudo yum install supervisor || sudo dnf install supervisor
```

### ➤ Create Config

```bash
sudo vi /etc/supervisor/conf.d/abc123.conf
```

Paste:

```ini
[program:abc123]
command=/opt/abc123/start_abc123.sh
directory=/home/path/to/abc123-community/n8n-workflows
user=USERNAME
autostart=true
autorestart=true
redirect_stderr=true
stdout_logfile=/var/log/supervisor/abc123.log
stdout_logfile_maxbytes=10MB
stdout_logfile_backups=5
startsecs=10
stopwaitsecs=30
killasgroup=true
stopasgroup=true
```

🔍 **Replace `USERNAME` with the user who owns the app folder.**

- If `pyenv` is installed under `/root/.pyenv`, the `user` **must be `root`**, or Supervisor won’t have permission to access it.
    
- After changing the `user=...`, **you must run**:
    

```bash
sudo supervisorctl reread
sudo supervisorctl update
```

Supervisor caches config files — it won’t reload changes without the above commands.

---

## ▶️ 3. Start with Supervisor

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start abc123
```

### 🔧 Common Commands

```bash
sudo supervisorctl status abc123
sudo supervisorctl tail abc123
sudo supervisorctl restart abc123
sudo supervisorctl stop abc123
```

---

## 🧰 4. Troubleshooting Supervisor

### 🔌 Daemon or Socket Errors

```bash
sudo systemctl status supervisor
sudo systemctl start supervisor
sudo systemctl enable supervisor

sudo mkdir -p /var/run/supervisor
sudo chown root:root /var/run/supervisor
sudo chmod 755 /var/run/supervisor
sudo rm -f /var/run/supervisor.sock /tmp/supervisor.sock
sudo systemctl restart supervisor
```

### 🧪 Config Test

```bash
sudo supervisord -c /etc/supervisor/supervisord.conf -t
```

### 🐛 Manual Debugging

```bash
sudo supervisord -c /etc/supervisor/supervisord.conf -n
```

### 📜 Log Files

```bash
sudo tail -f /var/log/supervisor/supervisord.log
sudo journalctl -u supervisor -f
```

---

### 🧪 Run Startup Script Directly

If `supervisorctl tail abc123` shows **no output**, and `curl 127.0.0.1:8001` fails to connect:

```bash
curl 127.0.0.1:8001
```

Run the script manually to expose any hidden errors:

```bash
/opt/abc123/start_abc123.sh
```

---

### ❗ `pyenv: version \`3.8.18' not installed` (But It Is)

Even if `pyenv versions` shows `3.8.18`, Supervisor might not find it. This is usually due to an incomplete environment.

---

#### ✅ Fix 1: Use Full Python and pip Paths in `.sh` Script

Instead of relying on pyenv initialization or `pyenv local`, hardcode the full paths:

```bash
/root/.pyenv/versions/3.8.18/bin/pip3 install -r requirements.txt
/root/.pyenv/versions/3.8.18/bin/python run.py --port 8001
```

✅ **How to find those paths**:

Use `pyenv`’s own lookup (not `which python`):

```bash
pyenv which python
pyenv which pip
```

This avoids confusion with system Python binaries.

---

#### ✅ Fix 2: Hybrid Approach (if you must use pyenv)

```bash
export PATH="/root/.pyenv/bin:$PATH"
eval "$(/root/.pyenv/bin/pyenv init -)"
eval "$(/root/.pyenv/bin/pyenv virtualenv-init -)"

export PYENV_VERSION=3.8.18
```

Still, you may prefer the simplicity and reliability of Fix 1.

---

## 🌐 5. Test the App

```bash
curl -I https://wengindustries.com/app/n8n-templates/abc123-community/
curl https://wengindustries.com/api/abc123/workflows
curl https://wengindustries.com/api/abc123/workflows/some-workflow.json
curl -I https://wengindustries.com/api/abc123/workflows/some-workflow.json/download
```

---

## 🛠 6. Common Issues

### ❌ 404s

- Make sure app is listening on port `8001`
    
- Check `/api/abc123` route is used properly in frontend
    
- Confirm reverse proxy rules are active
    

### ❌ CORS

- Set appropriate `Access-Control-Allow-Origin` headers
    

### ❌ Static Files

- Test locally: `http://127.0.0.1:8001/`
    
- Verify `proxy_pass` is pointing to the correct internal port
    

### ⏱ Timeouts

- Adjust timeout settings in Nginx/Apache proxy
    
- Watch for long-running backend operations
    

---

## 🧪 7. Debugging Tools

```bash
netstat -tlnp | grep 8001
curl http://127.0.0.1:8001/api/workflows

tail -f /var/log/nginx/error.log
tail -f /var/log/apache2/error.log

nginx -t
apachectl configtest
```

---

## 🔒 8. Security Best Practices

- 🔐 **Authentication:** Protect sensitive endpoints
    
- 🔒 **Firewall:** Block port `8001` from public access
    
- 🚫 **Rate Limiting:** Throttle high-volume requests
    
- 🔒 **HTTPS:** Use TLS for all traffic
    

---

## 🚀 9. Performance Optimization

- 🧠 **Caching:** Enable browser/server-side cache
    
- 📦 **Compression:** Use `gzip` or `brotli`
    
- 🔁 **Connection Pooling:** Let proxy keep upstream connections open
    

### Example `nginx` snippet:

```nginx
location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg)$ {
    expires 1y;
    add_header Cache-Control "public, immutable";
    proxy_pass http://127.0.0.1:8001;
}
```

---

## 📊 10. Monitoring Suggestions

- ✅ Confirm port `8001` stays responsive
    
- 🕵️ Track 4xx and 5xx error rates
    
- ⏱ Monitor response latency
    
- 📉 Watch server metrics (RAM, CPU, disk I/O)
    

---

## 📝 11. Final Working Script

Here’s the final working `start_abc123.sh` script based on my server (Debian 22.04 on Hostinger VPS KVM2), and this would have to be re-adjusted depending on the server - just to show how far we've gone from the original .sh file to get it working:

```bash
#!/bin/bash

# Exit on any error
set -e

# Set the working directory
cd /home/path/to/abc123

# Initialize pyenv (adjust path as needed for your system)
# export PATH="$HOME/.pyenv/bin:$PATH"
export PATH="/root/.pyenv/bin:$PATH"
eval "$(/root/.pyenv/bin/pyenv init -)"
eval "$(/root/.pyenv/bin/pyenv virtualenv-init -)"

# Set Python version (disabled — using full paths below)
# pyenv local 3.8.18
# export PYENV_VERSION=3.8.18

# Ensure dependencies are installed
/root/.pyenv/versions/3.8.18/bin/pip3 install -r requirements.txt

# Start the application
/root/.pyenv/versions/3.8.18/bin/python run.py --port 8001
```

