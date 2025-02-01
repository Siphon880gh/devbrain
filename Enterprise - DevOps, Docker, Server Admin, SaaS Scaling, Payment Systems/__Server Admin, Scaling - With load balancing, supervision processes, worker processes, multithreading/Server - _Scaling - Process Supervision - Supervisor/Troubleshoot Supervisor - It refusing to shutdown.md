
Shutdown previous supervisor
```
supervisorctl shutdown
```
  

Sometimes fail to shutdown the gunicorn so double check:
```
ps aux | awk 5001
```


If you see gunicorn mentioned in one of the processes, then you need to shut them down. Having gunicorn still would look like:
```
root       782  1.9  0.8 547072 37344 ?        Sl   02:11   0:00 /root/.pyenv/versions/3.6.15/envs/app4/bin/python3.6 /root/.pyenv/versions/app4/bin/gunicorn --timeout 600 -w 6 -b 0.0.0.0:5001 --certfile=...crt --keyfile=...key wsgi:app

root       783  1.9  0.8 547072 37344 ?        Sl   02:11   0:00 /root/.pyenv/versions/3.6.15/envs/app4/bin/python3.6 /root/.pyenv/versions/app4/bin/gunicorn --timeout 600 -w 6 -b 0.0.0.0:5001 --certfile=...crt --keyfile=...key wsgi:app

root       784  2.0  0.8 547072 37340 ?        Sl   02:11   0:00 /root/.pyenv/versions/3.6.15/envs/app4/bin/python3.6 /root/.pyenv/versions/app4/bin/gunicorn --timeout 600 -w 6 -b 0.0.0.0:5001 --certfile=...crt --keyfile=...key wsgi:app

root       785  2.1  0.8 547072 37352 ?        Sl   02:11   0:00 /root/.pyenv/versions/3.6.15/envs/app4/bin/python3.6 /root/.pyenv/versions/app4/bin/gunicorn --timeout 600 -w 6 -b 0.0.0.0:5001 --certfile=...crt --keyfile=...key wsgi:app

root       787  2.1  0.8 547072 37360 ?        Sl   02:11   0:00 /root/.pyenv/versions/3.6.15/envs/app4/bin/python3.6 /root/.pyenv/versions/app4/bin/gunicorn --timeout 600 -w 6 -b 0.0.0.0:5001 --certfile=...crt --keyfile=...key wsgi:app

root       788  2.0  0.8 547072 37360 ?        Sl   02:11   0:00 /root/.pyenv/versions/3.6.15/envs/app4/bin/python3.6 /root/.pyenv/versions/app4/bin/gunicorn --timeout 600 -w 6 -b 0.0.0.0:5001 --certfile=...crt --keyfile=...key wsgi:app
```

**You can kill all gunicorn with this:**
```
ps aux | grep 5001 | grep -v grep | awk '{print $2}' | xargs kill
```


If you see this then it means there's no gunicorn to kill, and that's fine too. We just want to make sure no gunicorn is running:
```
usage: kill [ -s signal | -p ] [ -a ] pid ...

       kill -l [ signal ]
```


---

Still fail to shutdown?
Supervisor was binded 127.0.0.1:9001 at the central settings for Supervisor. Recall port 9001 is the web page interface for supervisor that you can visit in the browser to look at supervisor with a GUI

Get the PID number of the port:
```
sudo lsof -i :9001
```

Then kill off:
```
sudo kill _PID_
```

