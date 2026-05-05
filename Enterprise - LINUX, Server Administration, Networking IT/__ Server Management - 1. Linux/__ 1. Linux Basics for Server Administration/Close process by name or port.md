
Kill all gunicorn running at port 5001:
```
ps aux | grep gunicorn | grep 5001| awk '{print $2}' | xargs kill
```

Check any is on:
```
ps aux | grep gunicorn | grep 5001
```