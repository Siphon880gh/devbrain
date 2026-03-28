Nginx/Apache might write to **compressed** log files.

Use zcat command:
```
sudo zcat /home/<USER>/logs/nginx/access.log-2026-01-01.gz
```

---

Example advanced use:
```
sudo zcat /home/<USER>/logs/nginx/access.log-*.gz 2>/dev/null | tail -n 20
```

All compressed logs' most recent tailing 20 lines appear in the terminal