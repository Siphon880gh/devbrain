## Supervisor with gunicorn, pyenv, pipenv

About (Brief dup): 
Install whatever packages you want this app to have isolated from your system and portable to other systems when you migrate the folder to a server, for example (with pipenv). The python interpreter used is also portable (with pyenv)

---


This guide will combine supervisor and gunicorn with https. This allows for concurrent requests to flask. But does not scale up servers (not an autoscaler) because you need Kubernetes or AWS ECS for that.

  
---

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



## 1. Setup Supervisor  

Skip #1-3 if have done. Skip #4 if have setup supervisor for your app.

1. Install supervisor globally for your os
What worked for CentOS 6.1 was supervisor-3.0a8.tar.gz

2. Create paths:
```
~/supervisor.d/ --OR-- /etc/supervisor.d/  
```


3. Setup ~/supervisord.conf --OR-- **/etc/supervisord.conf**
    if local:  

```
[include]  
files = /Users/wengffung/supervisor.d/*.conf  
  
[supervisord]  
nodaemon=false  
logfile=/var/log/supervisor/supervisord.log  
loglevel=debug  
  
[unix_http_server]  
file=/tmp/supervisor.sock  
chmod=0777  
  
[supervisorctl]  
serveurl=unix:///tmp/supervisor.sock  
  
[inet_http_server]  
port = 127.0.0.1:9001  
  
[rpcinterface:supervisor]  
supervisor.rpcinterface_factory = supervisor.rpcinterface:make_main_rpcinterface
```


^Do not use shortcut path ~ because is not recognized. You have to type the complete user path , so notice in the above snippet it's /Users/weffung/. It'll. change base on your computer.
      
**if remote:**
    
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
supervisor.rpcinterface_factory=supervisor.rpcinterface:make_main_rpcinterfac  
```


4. Setup your apps at ~/supervisor.d/  --OR– /etc/supervisor.d/  
    For example: ~/supervisor.d/app1.conf  --OR– **/etc/supervisor.d/app1.conf**  

Local:
```
[program:app1]  
command=/Users/wengffung/dev/web/weng/tools/flask-virt-supervisor/supervisor.x86_64.sh  
directory=/Users/wengffung/dev/web/weng/tools/flask-virt-supervisor  
autostart=true  
autorestart=true  
redirect_stderr=true  
stdout_logfile=/var/log/supervisor/app1.log  
stderr_logfile=/var/log/supervisor/app1.log  
```
    

 ^ Notice that the name of your app is “app1” in the first line. That’ll be the name you use to start the app with supervisor.

 ^ Notice the command is the python interpreter available by virtual environment (that folder has multiple versions of python) followed by your python script.  

 ^ Notice that the main config file refers to the folder where your app config files are, with *  

 ^ Yes, you run the shell script file path as the entire command, with no arguments or process name necessary  

Remote:
```

```
  
---

## 2. Install pyenv

Which is the virtual environment of the python interpreter of your choosing (for example python 2.7.18 along with its pip)
  
curl -L https://github.com/pyenv/pyenv-installer/raw/master/bin/pyenv-installer | bash  


---


Test if the path is found:

which pyenv

  
Moved here: 
Check for sure. If not found, find globally for that folder. For example, it could be:
```
ls ~/.pyenv/bin/pyenv  
```

  
Add that path via .zhsrc, .bash_profile, or whatever is appropriate:

That’s at ~/.bash_profile or /root/.bash_profile. You can `ls -la`  there to see if it exists. Create the file if doesn’t exist  

System wide bash profile is the file at /etc/profile
```
export PATH="$PATH:~/.pyenv/bin/"  
```


## 2b. OPTIONAL - If you want option to use pyenv’s virtual environment in the future (but not compatible with pipenv)

Install pyenv-virtualenv which is tool that pyenv uses for virtual environments. It would not complain until you start activating. Install with:

- If Mac:

```
brew install pyenv-virtualenv

```
  

- If CentOs6.1

```
sudo yum install -y git gcc zlib-devel bzip2 bzip2-devel readline-devel sqlite sqlite-devel openssl-devel  
  
git clone https://github.com/pyenv/pyenv-virtualenv.git $(pyenv root)/plugins/pyenv-virtualenv  
```

  
Make sure .bash_profile or .zshrc has the initiation code for virtualenv:

That’s at ~/.bash_profile or /root/.bash_profile. You can `ls -la`  there to see if it exists. Create the file if doesn’t exist

System wide bash profile is the file at /etc/profile  
```
if command -v pyenv 1>/dev/null 2>&1; then  
    eval "$(pyenv init -)"  
fi  
  
if command -v pyenv virtualenv-init 1>/dev/null 2>&1; then  
    eval "$(pyenv virtualenv-init -)"  
fi  
```
  

Then either restart or source the terminal config is appropriate:

Depends which system you're at:  
```
source ~/.bash_profile  
source /etc/profile
```


---

## 3. Switch to python version with pyenv
  

1. First initialize the shell (in case bash_profile didn’t apply):

```
export PATH="$(pyenv root)/shims:$PATH"  
eval "$(pyenv init -)"  
```

Explanation: This adds the `pyenv` shims directory to the front of your `PATH`. The shims directory contains lightweight executables that intercept your Python commands (like `python` or `pip`) and redirect them to the correct Python version based on your `pyenv` settings. With the init option command, among other things, it ensures that `pyenv` shims work correctly and that other `pyenv` functionality (like auto-activation of virtual environments) is set up. These need to be set before you use any Python commands to ensure your shell uses the Python versions managed by `pyenv`.

  
## 4. Switch to python version with pyenv

1. Now we switch python version. Here I picked 3.6.15; you can pick the python version that’s appropriate. Make sure in the appropriate folder when you do:

```
cd /Users/wengffung/dev/web/storyway/  
pyenv local 3.8.18  
export PYENV_VERSION=3.8.18  
```

  

If it says version is not installed, then install to pyevn with: `pyenv install 3.6.15` 

If you need a reminder which python versions you installed on pyenv, show all versions with: `pyenv shims` 

The exporting PYENV_VERSION might seem like an overkill, but PIP looks into it and might have a mismatch

  

You can confirm python is using pyenv’s:

```
which python  
cat .python-version  
```

  
If .python-version showing the wrong version, remove it, and try again


Note:  

- **Packages Installed with Pyenv's Python Version**: If you installed packages using pip after setting the Python version with `pyenv`, those packages are installed specifically for that Python version. So, when you set `pyenv local 3.x.x`, you'll have access to any packages you installed while that version was active.
    
- You are not creating a pyenv virtual environment because pipenv virtual environment would say you already have a virtual environment and will not override it, then pipenv can’t do its job of managing packages that your script has access to. Instead, you’re using pyenv’s other feature of switching python version (by placing files locally on your project at /.python-version)

## 5. Install pipenv at the current folder for the pyenv python version


First make sure you’ll be using pyenv’s pip and it’ll be installed as pyenv’s pip’s pipenv rather than anaconda’s. Otherwise you’ll likely have package incompatibility or distributions not being found complaining about. 


1. Requirement: Exited all virtual environments:

If you see (base) before your computer name in terminal, run: `conda deactivate` 

Make sure you haven’t started a pyenv virtual environment (if you follow other instructions on top of my instructions)

  
You can confirm pip is not using anaconda’s paths with:

```
which pip 
```

  

2. Requirement: Make sure have the latest pip and various build chains first:
```
pip install --upgrade pip setuptools wheel  
```

  

3. Install pipenv. Depending on your packages successfully installing or not later, you have these options to install pipenv  
```
pip install pipenv
```

^ If running `pipenv install`  on an existing Pipfile produces error: "TypeError: 'NoneType' object is not callable”, then you need to downgrade pipenv. You would have to remote pre existing pipenv virtual environments with `pipenv --rm` 

```
pip install pipenv==2021.5.29
```

```
pip install pipenv==2022.1.8  
```

```
pip install pipenv==2022.3.23
```


You can confirm pipenv is not using anaconda’s path, but very likely it won’t:

```
pip show pipenv  
```


## 6. Pipenv: Create pipenv package virtual environment with pyenv’s local python 

```
pipenv --python $(pyenv which python)  
```

  

It’ll say .env environmental variables are loaded. Don’t worry, it doesn’t affect any .env file you may have at the current folder.

  

## 7. Pipenv: Permanently setup packages for pipenv

  

1. Is there already a Pipfile? Then make sure the python version in Pipfile file matches the python version of your pyenv. Otherwise it could "✘ Failed creating virtual environment"

  

2. **Setup `pipenv` within the Virtual Environment**:

  

   Once the virtual environment is activated, you can use `pipenv` to manage project-specific dependencies:

  

Make sure you’re in the project. And now you will initiate a pipenv project for your app. Initialize a Pipenv environment (creates a Pipfile):  
# initiate a pipenv project with the current app folder

pipenv install

  

Then confirm successful:

```
ls Pipfile*
```

^Checking for Pipfile and Pipfile.lock now exists

  

2.  Install packages and dependencies using Pipenv and those will be portable from system to system  
    

  

Make sure:

- No requirements.txt in the same folder. Keep in mind if you have a requirements.txt, it could get in the way if you want to install specific versions. You will be relying on Pipfile

  

Run to both install the package and update Pipfile (so when you migrate, `pipenv install`  is enough):  

```
pipenv install package_name  
```


2 - troubleshooting:

> InstallCommand error?  
> 
>   File "/root/.pyenv/versions/3.6.15/envs/app4/lib/python3.6/site-packages/pipenv/project.py", line 682, in create_pipfile
> 
>     from .vendor.pip_shims.shims import InstallCommand
> 
> ImportError: cannot import name 'InstallCommand'
> 
> **Reason**
> 
> Latest `pipenv` is not backward compatible and this error doesn't show any hint about this.
> 
> **Solution**
> 
> Install an older version of pipenv  
>   
> 
> [https://www.caspertsui.blog/pipenv/](https://www.caspertsui.blog/pipenv/)  
>   

  

Advanced Use: Can edit the Pipfile for specific versions, then run `pipenv install` 
```
[[source]]  
url = "https://pypi.org/simple"  
verify_ssl = false  
name = "pypi"  
  
[packages]  
flask = "==2.0.3"  
flask-cors = "==4.0.0"  
numpy = "==1.19.5"  
requests = "==2.27.1"  
python-dotenv = "==0.20.0"  
moviepy = "==1.0.3"  
pydub = "==0.25.1"  
pillow = "==8.4.0"  
matplotlib = "==3.3.4"  
pydantic = "==1.9.2"  
ipython = "==7.16.3"  
websockets = "==9.1"  
opencv-python = "==3.4.7.28"  
  
[dev-packages]  
  
[requires]  
python_version = "3.6"  
```
  

Advanced Use: Can install cli specific ersions:
```
pipenv install Flask==2.0.3
```
... ...
  

## 8. Activate pipenv virtual environment

  

Check: Did you \## **3. Switch to python version with pyenv ?**  

Activate pypenv virtual environment  

  

Either

a. Activate the virtual environment of dependencies, then run your script
```
pipenv shell --verbose  
python your_script.py
```

b. Or run a script within the Pipenv virtual environment:

```
pipenv run python your_script.py  
```
  

  

---

  

Troubleshooting

  

If says there’s already a virtual environment, run pipenv --rm, consider reinstalling off the current Pipfile that’s generated (from `p

  
```
pipenv --rm  
pipenv install  
python your_script.py
```

--- 

Test if dependencies are loaded from the right virtual environment in a dev tool script:  



Get the path to the currently active Python interpreter to see if it's from the pyenv virtual environment's path  
your_script.py:  
```
import sys  
print(sys.executable) # Print's python interpreter path. Expect to be virtual environment's   
```  

Get the module import paths and it should have the pipenv virtual environment's path including the current app's path  
Print the paths where Python is importing modules from:
```
for path in sys.path:  
    print(path)  
```
  

An output that makes sense is it pointing to the version of python you initiated with pyenv, so the path has .pyenv and likely the version number in it (eg The folder `/Users/wengffung/.pyenv/versions/3.8.12/lib/python3.8` ). Another path has pipenv virtual environment though it’s not obvious because the path doesn’t have the word pipenv (eg. `/Users/wengffung/.local/share/virtualenvs/storyway-A39rOKjm/bin/python` refers to a path created by `pipenv`).

  
---


## 9. Prep sh file (so supervisord can manage restarting it on server crashes) 

Supervisord can easily run a python file if it’s set that way in supervisor.d/*.conf at key command, and then it would restart the app if the server or app crashes; however, Supervisor also needs to point the python interpreter via pyenv, then run the pipenv virtual environment for the modules, so it can use your preferred python interpreter (along with its pip) and your preferred python packages. The problem is you can only setup one command in your app config. So, you create a .sh that starts the two virtual environments as well as start the python server / script

  

1. Know that Supervisor runs shell script that activates virtual environments and runs script


if remotely SSH, eg:
```
/home/bse7iy70lkjz/public_html/tools/flask-pipenv-supervisor/supervisor/x86_64.sh  
```
  

if locally, eg:
```
/Users/wengffung/dev/web/weng/tools/flask-virt-supervisor/supervisor.x86_64_dev.sh  
```
  

LOCAL sh:
```
#!/bin/bash  
# Above must be first line of script. Tells shell which interpreter to use. /bin/bash is most common shell.  
```

# Supervisor - Pyenv - Pipenv for: x86_64  
Not to be confused with x86. x86 is on even older computers' CPUs using the 32-bit x86 architecture.  

x86_64 is the architecture found in most desktops and servers.  

x86_64 is commonly used in Intel and AMD processors  
  
## PROFILE START  --  
Normally, when you are in a shell session, you can use `source /etc/profile`, but when you run a shell script,   it runs in its own environment and doesn't automatically have access to the configurations and settings of your main shell session. It cannot load in /etc/profile. Below are the relevant parts of /etc/profile that makes pyenv,   pipenv, and other commands available.  
  
source /etc/profile  
  
# For pyenv  
```
conda deactivate  
export PATH="$(pyenv root)/shims:$PATH"  
eval "$(pyenv init -)"  
```

# User specific environment and startup programs  
```
PATH=$PATH:$HOME/bin  
PATH=$PATH:/root/.pyenv/bin  
PATH=$PATH:/root/.pyenv/plugins/pyenv-virtualenv/bin  
PATH=$PATH:/usr/bin/convert  
PATH=$PATH:/Users/wengffung/.local/share/virtualenvs/storyway-A39rOKjm/lib/python3.8/site-packages  
export PATH  
```

# ImageMagick which MoviePy uses  
```
export MAGICK_HOME="$(dirname $(which convert))"  
```

PROFILE END --  
  
Set the Python version locally at this directory with pyenv. Should match pipenv Pipfile's version  
```
cd /Users/wengffung/dev/web/storyway/  
pyenv local 3.8.18  
export PYENV_VERSION=3.8.18  
pipenv --python $(pyenv which python)  
```

Activate pipenv environment (python packages)  
```
cd /Users/wengffung/dev/web/storyway/  
pipenv shell  
```

Run script in container  
```
cd /Users/wengffung/dev/web/storyway/video-listing-ai  
# npm run build-dev # Assumed you ran this already because otherwise supervisor will keep rebuilding this  
pipenv run python /Users/wengffung/dev/web/storyway/video-listing-ai/server.py  
```
  

REMOTE sh:
```
#!/bin/bash  
# Above must be first line of script. Tells shell which interpreter to use. /bin/bash is most common shell.  
  
# Supervisor - Pyenv - Pipenv for: x86_64  
# Not to be confused with x86. x86 is on even older computers' CPUs using the 32-bit x86 architecture.  
# x86_64 is the architecture found in most desktops and servers.  
# x86_64 is commonly used in Intel and AMD processors  
  
## PROFILE START  --  
# Normally, when you are in a shell session, you can use `source /etc/profile`, but when you run a shell script,  
# it runs in its own environment and doesn't automatically have access to the configurations and settings of your   
# main shell session. It cannot load in /etc/profile. Below are the relevant parts of /etc/profile that makes pyenv,   
# pipenv, and other commands available.  
  
# source /etc/profile  
  
# For pyenv  
  
if command -v pyenv 1>/dev/null 2>&1; then  
    eval "$(pyenv init -)"  
fi  
  
if command -v pyenv virtualenv-init 1>/dev/null 2>&1; then  
    eval "$(pyenv virtualenv-init -)"  
fi  
  
# User specific environment and startup programs  
  
PATH=$PATH:$HOME/bin  
PATH=$PATH:/root/.pyenv/bin  
PATH=$PATH:/root/.pyenv/plugins/pyenv-virtualenv/bin  
PATH=$PATH:/usr/bin/convert  
export PATH  
  
# ImageMagick which MoviePy uses  
export MAGICK_HOME="$(dirname $(which convert))"  
```

PROFILE END --  
  
Normally, when you are in a shell session, you can use `pyenv activate appName` to activate a specific virtual environment.  
However, when you run a shell script, it runs in its own environment and doesn't automatically have access to the   configurations and settings of your main shell session.  
  
To make sure your shell script can activate the virtual environment correctly, you directly source the virtual environment activation scripts ("activate" is a shell script provided by pyenv). The activate file contains thenecessary configuration to set up the virtual environment  

```
pyenv activate app4  
source ~/.pyenv/versions/app4/bin/activate  
```

# Activate pipenv environment (python packages) associated with the file path as referenced by /etc/supervisor.d/*.conf 
```
cd /home/bse7iy70lkjz/public_html/storyway/  
pipenv shell  
```

# Test script in pipenv environment  
```
cd /home/bse7iy70lkjz/public_html/storyway/video-listing-ai  
#python /home/bse7iy70lkjz/public_html/storyway/video-listing-ai/server.py  
npm start  
```

Test if successful. Close off the script (CMD+C). We will use Supervisor to run a .sh shell file that runs the script via gunicorn to a gateway python script

# Make sure Supervisor has permission to run shell script

You need to `chmod 777 path/to/file/sh` 

You run that in terminal as root user, because when you start supervisord to permanently monitor, it’d be started from root user as well. Make sure it is owned and grouped by root as well.

---


Troubleshooting:

If the packages are not found by your python when ran by the .sh file, make sure `pipenv shell`  worked because that virtual environment where you had installed with `pipenv install \__package_name__)` would inform your python where to load. In addition, we had the command `pipenv run python ...`  to forcefully run from pipenv’s perspective.

  
If that won’t work, your last resort is at your python script file, to point to where to import the modules:  
```
import sys  
sys.path.append('/Users/wengffung/.local/share/virtualenvs/storyway-A39rOKjm/lib/python3.8/site-packages')  
  
from flask import Flask, request, jsonify  
from flask_cors import cross_origin  
from pymongo import MongoClient  
from service.elevenlabs import generateSpeech  
from bson import ObjectId  
from flask_cors import CORS  
from runtime.env import runServer  
```
  

Make sure you point to the folder for your modules to be importable inside python scripts. Get your pipenv’s path:  
```
pipenv --venv  
```
  

For example, if it’s `/Users/wengffung/.local/share/virtualenvs/storyway-A39rOKjm` , the path of python modules are at, which you can discover in Finder or with ls commands:
```
/Users/wengffung/.local/share/virtualenvs/storyway-A39rOKjm/lib/python3.8/site-packages  
```

## 10. Start supervisord:

1. Make sure` ~/supervisor.d/<app>.conf  --OR– /etc/supervisor.d/<app>.conf` points to the sh file. Refer back to Setup Supervisor section.

  
! Just in case, make sure to go into the pyenv virtual environment, then pipenv virtual environment, then start activating supervisord as follows
  

2. **if remotely SSH, eg**:
```
sudo supervisord -c /etc/supervisord.conf -l /var/log/supervisor/supervisord.log  
```

**if locally, eg:**  
```
sudo supervisord -c /Users/wengffung/supervisord.conf -l /var/log/supervisor/supervisord.log  
```

3. Ran successfully in the background? One, you can type in terminal (which means it’s in background). Two, check the process is running with:
```
ps aux | grep supervisor  
```

Then make sure the processes that supervisor loads didn’t crash either:
```
sudo supervisorctl status  
```

### Troubleshooting: Seems to be running status wise, but when testing the app like localhost:5001, it fails


Kill off `ps aux | grep supervisor`  → `sudo kill \___pid\___ ` (You get pid from second column of ps aux...)  
  
Run in the foreground. Add `-n`  for no daemon to see all output

```
sudo supervisord -c /etc/supervisord.conf -l /var/log/supervisor/supervisord.log -n
```
  

Check log file:
```
tail /var/log/supervisor/supervisord.log
```
  
3. Make it autostart when server restarts:
```
sudo chkconfig supervisord on  
```

^chkconfig command is a system utility used on Unix-like operating systems, primarily on Linux distributions, to manage the initialization scripts and services that start automatically during system boot. The name "chkconfig" stands for "Check Configuration." It allows administrators to configure and control which services should start automatically at different runlevels (system states) and which should not.

  
### Troubleshooting: If supervisord cannot be set (error: error reading information on service supervisord)

Then it’s because this is a version of supervisord that doesnt come with a system service script by default You have to manually do it then:


To create a custom init script for Supervisor 3.0a8 on CentOS 6, you can use the following steps:  


1. Create a Supervisor init script:

Create a new init script file, such as `/etc/init.d/supervisord`, and open it in a text editor:


```bash
sudo vi /etc/init.d/supervisord
```


Add the following content to the file:

```
#!/bin/sh  
#  
# supervisord   Startup script for the Supervisor process control system  
#  
# chkconfig: - 64 36  
# description: Supervisor is a client/server system that allows \  
#   its users to monitor and control a number of processes on \  
#   UNIX-like operating systems.  
# processname: supervisord  
  
# Source function library.  
. /etc/rc.d/init.d/functions  
  
# Source networking configuration.  
. /etc/sysconfig/network  
  
# Check that networking is up.  
[ "${NETWORKING}" = "no" ] && exit 0  
  
# Set the path to the supervisord executable  
SUPERVISORD=/usr/bin/supervisord  
  
# Set the path to the supervisorctl executable  
SUPERVISORCTL=/usr/bin/supervisorctl  
  
# Set the path to the Supervisor configuration file (change this to your config file)  
SUPERVISOR_CONF=/etc/supervisord.conf  
  
# Set the username and group that Supervisor will run as  
SUPERVISOR_USER=root  
SUPERVISOR_GROUP=root  
  
# Check for existence of needed binaries  
test -x $SUPERVISORD || exit 1  
test -x $SUPERVISORCTL || exit 1  
  
RETVAL=0  
  
start() {  
    echo -n $"Starting Supervisor: "  
    $SUPERVISORD -c $SUPERVISOR_CONF -u $SUPERVISOR_USER  
    RETVAL=$?  
    [ $RETVAL -eq 0 ] && touch /var/lock/subsys/supervisord  
    echo  
}  
  
stop() {  
    echo -n $"Stopping Supervisor: "  
    $SUPERVISORCTL shutdown  
    RETVAL=$?  
    [ $RETVAL -eq 0 ] && rm -f /var/lock/subsys/supervisord  
    echo  
}  
  
restart() {  
    stop  
    start  
}  
  
case "$1" in  
    start)  
        start  
        ;;  
    stop)  
        stop  
        ;;  
    restart|reload)  
        restart  
        ;;  
    condrestart|try-restart)  
        [ -e /var/lock/subsys/supervisord ] && restart || :  
        ;;  
    force-reload)  
        restart  
        ;;  
    status)  
        status supervisord  
        RETVAL=$?  
        ;;  
    *)  
        echo $"Usage: $0 {start|stop|restart|condrestart|try-restart|force-reload|status}"  
        RETVAL=2  
esac  
  
exit $RETVAL  
```

  
Save the file and exit the text editor.

2. Make the init script executable:

Run the following command to make the init script executable:

```bash
sudo chmod +x /etc/init.d/supervisord
```

```
sudo chmod 777 /etc/init.d/supervisord
```
  

3. Add `supervisord` to system startup:

Use the `chkconfig` command to add `supervisord` to the system startup:

```bash
sudo chkconfig --add supervisord
sudo chkconfig supervisord on
```

4. Start `supervisord`:

Now, you can start `supervisord` using the service command:

```bash
sudo service supervisord start
```

Your Supervisor 3.0a8 should now start automatically when the CentOS 6 system boots and restart if the server crashes. Please make sure to adjust the paths in the init script to match the actual locations of your Supervisor binaries and configuration file.

## 11. Confirm Supervisor successful

```
ps aux | head -n 1; ps aux | grep supervisor;  ps aux | grep gunicorn  
```

Should show 1 supervisor with many gunicorns (as many as you set the process workers)

Or if you dont run gunicorn:
```
ps aux | head -n 1; ps aux | grep supervisor;  ps aux | grep script.py  
```

Should show 1 and 1.

Visit your website to check your python script is working

## 12. Concurrent users - Gunicorn?

You may need more than one of your python scripts running especially if a lot of users, your script is synchronous and blocking, etc. At the last line of your .sh file, you can run gunicorn instead of running a python script directly. Gunicorn would have to be installed  with pipenv. Remember that gunicorn runs an intermedate python file, conventionally wsgi.py, that then runs your python script. For more information on gunicorn, refer to the [[Gunicorn Primer]]

---

## Troubleshooting


### Fish for stderror

1. Close off your supervisor
```
ps aux | grep supervisor  
sudo kill _pid_ 
```

### Troubleshoot with Logs

Have `loglevel=debug` at supervisord.conf  

See logs

```
tail /var/log/supervisor/supervisord.log  
```

### Troubleshoot with Instances

Refer to Managing instances below

**A package not found (eg Flask)**

**It might not be running the packages you installed with pipenv. Make sure you activated your pipenv environment:**

```
pipenv shell  
```

---

### Troubleshooting - Multiple supervisors?

```
ps aux | grep supervisord  
sudo kill __supervisord_pid__
```
^ pid is second column, eg. 18282

Or run this so it stays in foreground reporting any output:

The -n is for no daemon/background agent

```
sudo supervisord -c /etc/supervisord.conf -l /var/log/supervisor/supervisord.log -n  
```
  

See status from ctl:
```
supervisorctl -c /etc/supervisord.conf status  
```
  

### Troubleshoot with Supervisor Versions


Get version of supervisor so you can google for solution:
```
yum list installed | grep supervisor  
```

An output like that would be supervisor 2.1.9:
```
supervisor.noarch                                2.1-9.el6             @epel 
```


Or try a different version of supervisor. Version 2.1.9 kept not creating the sock file despite proper file paths and proper permissions (777 on root, and `ps aux | grep supervisor`  showed that root was running supervisord). No other error.

Ultimately, supervisor 3.0a8 is a better because it at least created the sock file. It also ultimately worked.

  
---

### Migrated?

Copying your app or project folder to the migrated server will not migrate the virtual environments. You have to rebuild the virtual environment (so document your steps somewhere or save the commands in a script file).  

---

More troubleshooting (unsorted):

Your python version that pipenv uses to install python packages are in the Pipfile, but for whatever reason you need to run pipenv explicitly with a python version, the command can be `pipenv --python 3.8 rest_of_your_command` Eg. :

```
pipenv --python 3.8 install flask  
```

---

  
More troubleshooting (unsorted):

Show all paths to pythons, cli tools, and packages

```
pyenv shims  
```
  

---


More troubleshooting (unsorted):

```
chmod 777 /Users/wengffung/dev/web/storyway/video-listing-ai/container/x86_64.sh
```
  

---


More troubleshooting (unsorted):

`/etc/supervisor.d`  for app configs
`/etc/supervisor.conf`  for supervisor config

  
supervisord is your service

sueprvisorctl is controlling the apps after supervisord is running, and is also for shutting down the service. It’s ctl for “control”.

  

---

  
More troubleshooting (unsorted):


**if remotely SSH, eg:**

```
/Users/wengffung/dev/web/storyway/video-listing-ai/container/x86_64.sh  
```

**if locally, eg:**
```
/Users/wengffung/dev/web/storyway/video-listing-ai/container/x86_64_dev.sh  
```

---


More troubleshooting (unsorted):

**if remote:**  
```
[include]  
files=/etc/supervisor.d/*.conf

**if local**

[include]  
files = /Users/wengffung/supervisor.d/*.conf  
```

---

  
More troubleshooting (unsorted):

Pipenv problems activating shell

Make sure you're in the directory containing your `Pipfile` and `Pipfile.lock`. `pipenv` uses these to identify and manage the project's virtual environment.  

If the `VIRTUAL_ENV` environment variable is set, it might cause `pipenv` to recognize an already activated environment. Clear it by running:


---


More troubleshooting (unsorted):


How find path of pyenv current virtual environment
`pyenv which --venv` 

How find path of pipenv current virtual environment
`pipenv --venv`


---

More troubleshooting (unsorted):
`pipenv graph | grep gunicorn`