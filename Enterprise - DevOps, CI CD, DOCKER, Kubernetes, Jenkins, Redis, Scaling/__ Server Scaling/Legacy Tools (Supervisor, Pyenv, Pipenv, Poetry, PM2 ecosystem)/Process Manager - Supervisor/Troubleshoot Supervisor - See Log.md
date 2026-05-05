Run:
```
tail /var/log/supervisor/supervisord.log
```

You may want to empty the log so you dont have to check timestamp each time you run the above command to see if anything printed to log:
```
echo "" > /var/log/supervisor/supervisord.log
```


Snapshot wise (clears after seeing log):
```
tail /var/log/supervisor/supervisord.log; echo "" > /var/log/supervisor/supervisord.log;
```