Required: Understand [[Shell Scripting - Checking Exit Status in Bash Scripts (Exit Status Codes)]]

---

## 🧪 Real-World Examples of Using Exit Status in Shell Scripts

---

### 📅 1. **Cron Job Health Check**

Automatically run a job and send an alert only if it fails.

```bash
#!/bin/bash

ping -c 1 example.com > /dev/null

if [ $? -ne 0 ]; then
  echo "Ping failed! Sending alert..."
  curl -X POST -d "Ping failed" https://hooks.slack.com/services/your/webhook/url
fi
```

> ✅ _Use case: Monitor uptime or connectivity in a background task._

---

### 🚀 2. **Deployment Script with Rollback**

You try to restart a service. If it fails, roll back.

```bash
#!/bin/bash

systemctl restart myapp.service

if [ $? -ne 0 ]; then
  echo "Restart failed! Rolling back..."
  cp /backups/myapp.conf.backup /etc/myapp.conf
  systemctl restart myapp.service
fi
```

> ✅ _Use case: Keep production services running even after bad updates._

---

### 🔁 3. **Loop with Retry on Failure**

Retry a flaky command (e.g. API call or download) up to 3 times.

```bash
#!/bin/bash

for i in {1..3}; do
  curl -f https://api.example.com/data && break
  echo "Attempt $i failed, retrying..."
  sleep 5
done

if [ $? -ne 0 ]; then
  echo "All retries failed. Exiting with error."
  exit 1
fi
```

> ✅ _Use case: Network scripts that must handle intermittent failures._

---

### ✅ 4. **CI/CD Pipeline Conditional Step**

A build script that only runs tests if dependencies install correctly.

```bash
#!/bin/bash

npm install
if [ $? -ne 0 ]; then
  echo "Dependency installation failed."
  exit 1
fi

npm test
```

> ✅ _Use case: Ensure clean builds in automated deployment systems._

---

### 🧼 5. **System Cleanup Script**

Only delete files if a backup succeeds.

```bash
#!/bin/bash

tar -czf /backups/data.tar.gz /important/data
if [ $? -eq 0 ]; then
  echo "Backup successful. Cleaning up..."
  rm -rf /important/data/*
else
  echo "Backup failed. Aborting cleanup!"
fi
```

> ✅ _Use case: Prevent accidental data loss._

---

### 💡 Bonus: `set -e` for Short Scripts

If you want your script to stop immediately when _any_ command fails:

```bash
#!/bin/bash
set -e  # Exit script on first failure

npm install
npm run build
npm test
```

> 🚨 _Caution: Use with care—`set -e` stops the whole script if anything fails._
