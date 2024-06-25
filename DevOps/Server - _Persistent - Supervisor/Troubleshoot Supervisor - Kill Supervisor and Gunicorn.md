
Absolute killswitches

Run this:
```
ps aux | grep supervisor | grep -v grep | awk '{print $2}' | xargs sudo kill
```

Then run that:
```
ps aux | grep gunicorn | grep -v grep | awk '{print $2}' | xargs sudo kill
```