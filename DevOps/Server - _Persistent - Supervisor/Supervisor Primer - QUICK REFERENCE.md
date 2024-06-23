## Quick Reference: Supervisor Paths

Recall that Supervisor helps manage your apps so that they get restarted if the app crashes or the server crashes. Supervisor does NOT perform vertical scaling.

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
supervisord -c /etc/supervisord.conf -l /var/log/supervisor/supervisord.log 


### Supervisor app setting files

Located at either: ~/supervisor.d/  --OR– /etc/supervisor.d/  
- For example: ~/supervisor.d/app1.conf  --OR– **/etc/supervisor.d/app1.conf** 
- And if you have another app: ~/supervisor.d/app2.conf  --OR– **/etc/supervisor.d/app2.conf** 
- GoDaddy CentOS 6.1: /etc/supervisor.d/ , specifically /etc/supervisor.d/flask.conf
- Make sure this  folder path is set into the central supervisor conf file

```
[program:app4]
command=/home/bse7iy70lkjz/public_html/storyway/app-vlai/container/x86_64.sh
directory=/home/bse7iy70lkjz/public_html/storyway/
autostart=true
autorestart=true
redirect_stderr=true
stdout_logfile=/var/log/supervisor/app4.log
stderr_logfile=/var/log/supervisor/app4.log
```


### Then you run like this:


Activate the right environment before dealing with supervisor and you run this in the applicable folder (storyway/)
```
pyenv activate app4  
```

And make sure all supervisor are closed (if it errors it's already shutdown, that's fine too):
```
supervisorctl shutdown  
```

Then you run like this:
```
supervisord -c /etc/supervisord.conf -l /var/log/supervisor/supervisord.log 
```

After init,  you manage on GoDaddy CentOS 6.1 like this:
```
sudo service supervisord status
```
And in place: start/stop/status

---


## Quick Reference: Maintenance after setup - Supervisor level

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

  

Activate the right environment before dealing with supervisor
```
pyenv activate app4  
```

  

Shutdown previous supervisor
```
supervisorctl shutdown  
```
  

Sometimes fail to shutdown the gunicorn so double check:
```
ps aux | awk 5001  
```
  

You can kill all gunicorn with this:
```
ps aux | grep 5001 | grep -v grep | awk '{print $2}' | xargs kill
```

  
Then restart Supervisor:
```
sudo supervisord -c /etc/supervisord.conf -l /var/log/supervisor/supervisord.log 
```


Checking mongo shell for database entries?

Its mongo shell is actually `mongo`  → `show databases`  → etc etc


---

## Pyenv


If you need a reminder which python versions you installed on pyenv, show all versions with: `pyenv shims` 
