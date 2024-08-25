
**TIP: OPEN TABLE OF CONTENTS**


*MOST OFTEN YOU Need:
*MOST OFTEN YOU Need:
*MOST OFTEN YOU Need:*
Quick Reference: Maintenance after been setup

---


## Quick Reference: Supervisor Paths

Recall that Supervisor helps manage your apps so that they get restarted if the app crashes or the server crashes. Supervisor does NOT perform horizontal scaling.

You have a central supervisor setting which includes making sure the sock will work with chmod and what path to look for your apps that you want supervisor to manage
### Central Supervisor setting file

Located at either: /etc/supervisord.conf or ~/supervisord.conf
GoDaddy Cent OS 6.1: /etc/supervisord.conf

Contents could be like:
```
[include]
files=/etc/supervisor.d/*.conf

[supervisord]
nodaemon=false
logfile=/var/log/supervisor/supervisor.log
loglevel=debug

[unix_http_server]
file=/var/run/supervisor/supervisor.sock
chmod=0777
chown=root:root ; socket file owner and group (adjust as needed)

[supervisorctl]
serverurl=unix:///var/run/supervisor/supervisor.sock

[inet_http_server]
port=127.0.0.1:9001


[rpcinterface:supervisor]
supervisor.rpcinterface_factory=supervisor.rpcinterface:make_main_rpcinterface
```

Seeing above you have a folder reg exp pattern to find supervisor app settings. 

Which means you start supervisor like this (but not yet because we have to cover the supervisor app settings):
```
supervisord -c /etc/supervisord.conf -l /var/log/supervisor/supervisord.log
```


### Supervisor app setting files

Located at either: ~/supervisor.d/  --OR– /etc/supervisor.d/  
- For example: ~/supervisor.d/app1.conf  --OR– **/etc/supervisor.d/app1.conf** 
- And if you have another app: ~/supervisor.d/app2.conf  --OR– **/etc/supervisor.d/app2.conf** 
- GoDaddy CentOS 6.1: /etc/supervisor.d/ , specifically /etc/supervisor.d/flask.conf
- Make sure this  folder path is set into the central supervisor conf file

```
[program:app4]
command=/home/godaddy_user/public_html/company/app/container/x86_64.sh
directory=/home/godaddy_user/public_html/company/
autostart=true
autorestart=true
redirect_stderr=true
stdout_logfile=/var/log/supervisor/app4.log
stderr_logfile=/var/log/supervisor/app4.log
```


### You run it like this:


Activate the right environment before dealing with supervisor and you run this in the applicable folder (company/)
```
pyenv activate app4  
```

And make sure all supervisor are closed (if it errors it's already shutdown, that's fine too):
```
supervisorctl shutdown  
```

Then you run like this:
Godaddy:
```
supervisord -c /etc/supervisord.conf -l /var/log/supervisor/supervisord.log 
```

Hostinger:
```
supervisord -c /etc/supervisor/supervisord.conf -l /var/log/supervisor/supervisord.log
```

After init,  you manage on GoDaddy CentOS 6.1 like this:
```
sudo service supervisord status
```
And in place: start/stop/status

---


## Quick Reference: Maintenance with Supervisor level

sudo service supervisord status
sudo service supervisord stop
sudo service supervisord restart

Starting has explicit about log files so:
```
supervisord -c /etc/supervisord.conf -l /var/log/supervisor/supervisord.log 
```

It might not say anything on success because all that std output goes to another file
![](https://i.imgur.com/0sPPFKn.png)


---


## Quick Reference: Maintenance after been setup

This is quick reference back. If setting up first time on server, skip this section. This section is meant for returning to after been setup and for only server maintenance purposes.

**FIRST STEP:**
Cd into the folder where you had setup pyenv for the app (basically the app folder).

Activate the right environment before dealing with supervisor
```
pyenv activate app4
```

  

Shutdown previous supervisor
```
sudo systemctl stop supervisor;
supervisorctl shutdown;
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

Run any build scripts if needed:
`npm run build`

Then restart Supervisor:
```
sudo supervisord -c /etc/supervisord.conf -l /var/log/supervisor/supervisord.log 
```

---

Still fail?

**One line to kill all PID's by port number:**
```
sudo lsof -ti :5001 | xargs -r sudo kill -9
```


If above command doesnt work: Get the PID number of the port:
```
sudo lsof -i :5001
```

If... Then kill off:
```
sudo kill _PID_
```


---


Still fail? Maybe you needed to run build scripts on your app to change the application code etc so it's compatible at the current server.

