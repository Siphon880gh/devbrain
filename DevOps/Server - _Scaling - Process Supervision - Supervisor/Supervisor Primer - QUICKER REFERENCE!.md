
1. Start Supervisor
```
sudo systemctl stop supervisor
``` 

2. Now you can kill all gunicorns (Supervisor might fail to do that if Supervisor manages a shell sh file that launches gunicorn instances):
```
ps aux | grep gunicorn | grep 5001 | awk '{print $2}' | xargs kill
```

Spam that command (up, enter; up, enter) until it says no process found anymore

You can check if any gunicorn instances left with: `ps aux | grep gunicorn | grep 5001`

3. Start Supervisor
```
sudo systemctl start supervisor
```

4. Confirm Supervisor ran fine:
http://domain.com:9001/

If any errors, you can view error logs at this Supervisor web panel