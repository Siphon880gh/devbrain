AKA: Getting Started

A **cron job** is a scheduled command that your Linux server runs automatically at specific times. It's a great way to automate tasks like certificate renewals, backups, or health checks.

### Example

This command runs every day at 3:00 AM to silently renew SSL certificates and reload NGINX if needed:

```
0 3 * * * certbot renew --quiet && systemctl reload nginx
```

---

## 🚀 How to Set Up a Cron Job

1. SSH into your server with root access.
    
2. Launch the cron editor:
    
    ```
    sudo crontab -e
    ```
    
3. On your first run, you’ll be asked to choose a text editor. Just type the number that corresponds to your preferred one (e.g., `1` for nano, `2` for vi).
    
    For example, if you select `vi`, your terminal might look like this:
    
    ![[Pasted image 20250524051327.png]]
    

---

## 📅 Cron Syntax Breakdown

Each cron job follows this structure:

```
* * * * * /path/to/command
| | | | |
| | | | └──── Day of the week (0 - 7) [Sunday = 0 or 7]
| | | └────── Month (1 - 12)
| | └──────── Day of the month (1 - 31)
| └────────── Hour (0 - 23)
└──────────── Minute (0 - 59)
```

### Example:

```
15 5 * * 1 /usr/bin/backup.sh
```

Runs every **Monday** at **5:15 AM**.

---

## 🗂️ Adding Multiple Cron Jobs

You can include **multiple cron jobs** in the same file by adding one job per line:

```
0 3 * * * certbot renew --quiet && systemctl reload nginx
30 2 * * * /usr/local/bin/db-backup.sh
0 */6 * * * /usr/local/bin/server-health-check.sh
```

**Tips:**

- Each line is a separate task.
    
- Use full paths to executables (`/usr/bin/your-command`) to avoid path issues.
    
- You can include comments in the file using `#`:
    
    ```
    # Renew SSL daily at 3 AM
    0 3 * * * certbot renew --quiet && systemctl reload nginx
    ```
    

---

## 💡 Beginner Tip

If you're new to cron syntax, just ask ChatGPT:

> _"Can you write a cron expression that runs a script every Monday at 5 PM?"_
