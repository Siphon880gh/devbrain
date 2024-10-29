## Supervisor with gunicorn, pyenv, pipenv

About (Brief dup): 
Install whatever packages you want this app to have isolated from your system and portable to other systems when you migrate the folder to a server, for example (with pipenv). The python interpreter used is also portable (with pyenv)

---

This guide will combine supervisor and gunicorn with https. This allows for concurrent requests to flask. But does not scale up servers (not an autoscaler) because that needs Kubernetes or AWS ECS for that.

---


## 1. Install and Setup Supervisor  

Skip  steps 1-5 if have done. Skip step 6 if have setup supervisor for your app.

1. Install supervisor globally for your os
What worked for CentOS 6.1 was supervisor-3.0a8.tar.gz
What worked for Debian 12 was 
```
apt update
apt-get install supervisor
```

2. Figure out what file your Supervisor central settings are in: 
	1. Figure out what folder exists by checking `ls ~/supervis*` and `ls /etc/supervis*`. Then it's a folder, so you cd into it. Then you get `pwd` which can return `~/supervisor` or `/etc/supervisor/`. 
	2. The file you're editing is `supervisord.conf` so the filepath to your Supervisor central settings is `~/supervisor/supervisord.conf` or `/etc/supervisor/supervisord.conf`
		- For example, central settings could be at: `/etc/supervisor/supervisord.conf`
		- FYI, .conf stands for configuration file

3. Figure out what folder your Supervisor apps can have settings at: 
	1. Run `ls /etc/supervisor/conf.d` then `ls ~/supervisor/conf.d` to figure out which one exists. 
		- FYI, the conf.d where d is stands for directory
		- You can cd into it to confirm it's a folder.
		- For example, apps could have settings at the folder: `/etc/supervisord/conf.d/` and one of yoru apps could have their settings at the file `/etc/sueprvisord/conf.d/app1.conf`
	   
4. Copy down these paths (Supervisor central settings filepath and Supervisor apps' settings folder path) to your webhost's details document. You may add them to the pre-echo before ssh/sshpass if you login SSH via an alias.

5. Edit your Supervisor central settings file

CAVEAT: Do not use shortcut path `~` in the settings, because is not recognized; Instead, use absolute path.

Use one of the templates below to reconcile the central settings file. Keep the filepaths that are by default on your central settings file intact and that's also an opportunity to check if it's the same filepath/folderpaths(s) you discovered. 

Add the recommended settings that are in the template but not in the file's defaults. And modify the default settings to match the template's (except the filepaths/folderpaths because that's OS specific rather than use case specific - our use case being to host a SaaS web app). Make sure you add them to the correct sections (sections are include, supervisord, etc). 

Make sure to backup the original file (eg. `cp /etc/supervisor/supervisord.conf /etc/supervisor/supervisord.conf.bak)

**if remote ColocationAmerica:**
```
; supervisor config file

[include]
files = /etc/supervisor/conf.d/*.conf

[supervisord]
nodaemon=false
loglevel=debug
logfile=/var/log/supervisor/supervisord.log ; (main log file;default $CWD/supervisord.log)
pidfile=/var/run/supervisord.pid ; (supervisord pidfile;default supervisord.pid)
childlogdir=/var/log/supervisor            ; ('AUTO' child log dir, default $TEMP)
user=root  ; specify the user to run supervisord as (set to root if you intend to run as root)

[supervisorctl]
serverurl=unix:///var/run/supervisor/supervisor.sock ; use a unix:// URL for a unix socket

[unix_http_server]
file=/var/run/supervisor/supervisor.sock   ; (the path to the socket file)
chmod=0775                       ; sockef file mode (default 0700)
chown=root:root ; socket file owner and group (adjust as needed)

[inet_http_server]
port=127.0.0.1:9001

; the below section must remain in the config file for RPC
; (supervisorctl/web interface) to work, additional interfaces may be
; added by defining them in separate rpcinterface: sections
[rpcinterface:supervisor]
supervisor.rpcinterface_factory = supervisor.rpcinterface:make_main_rpcinterface
```

**if remote Hostinger:**
```
; supervisor config file

[include]
files = /etc/supervisor/conf.d/*.conf

[supervisord]
nodaemon=false
loglevel=debug
logfile=/var/log/supervisor/supervisord.log ; (main log file;default $CWD/supervisord.log)
pidfile=/var/run/supervisord.pid ; (supervisord pidfile;default supervisord.pid)
childlogdir=/var/log/supervisor            ; ('AUTO' child log dir, default $TEMP)
user=root  ; specify the user to run supervisord as (set to root if you intend to run as root)

[supervisorctl]
serverurl=unix:///var/run/supervisor/supervisor.sock ; use a unix:// URL for a unix socket

[unix_http_server]
file=/var/run/supervisor/supervisor.sock   ; (the path to the socket file)
chmod=0775                       ; sockef file mode (default 0700)
chown=root:root ; socket file owner and group (adjust as needed)

[inet_http_server]
port=127.0.0.1:9001

; the below section must remain in the config file for RPC
; (supervisorctl/web interface) to work, additional interfaces may be
; added by defining them in separate rpcinterface: sections
[rpcinterface:supervisor]
supervisor.rpcinterface_factory = supervisor.rpcinterface:make_main_rpcinterface

```

**if remote GoDaddy:**
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

If local: 

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


Open port 9001 with iptables, ufw, firewalld, depending on what you're using for firewall. Refer to [[IPTables - Enable specific ports]], or [[UFW - Enable specific ports]], or [[firewalld - Enable specific ports]]

6. Cd into the folder where your Supervisor apps can have settings at.

Create an app like so:
app1.conf:
```
[program:app1]  
command=/tmp/test.sh  
directory=/tmp/  
autostart=true  
autorestart=true
stopsignal=TERM
redirect_stderr=false  
stdout_logfile=/var/log/supervisor/app1-stdout.log
stderr_logfile=/var/log/supervisor/app1-error.log
user=root
```

When you create a set of new app settings for Supervisor to manage an app (via command key value), make sure you have the app's logging filepaths (standard out and standard error)
- Copy down these paths (Supervisor central settings filepath and Supervisor apps' settings folder path) to wherever you keep track of important account information for your web host / VPS / dedicated services

 ^ Notice that the name of your app is “app1” in the first line. For supervisor logging and management purposes, you refer to app1

 ^ Notice that the main config file refers to the folder where your app config files are, with *  

 ^ Command refers to a .sh script that probably doesn't exist yet. We will create it for testing later. Yes, a shell script file path can run as a command without any process name leading it.
 
 ^ We want redirect_stderr=false to keep standard out and error logs separately. This is up to you. If you prefer all standard out and error logs to go into one file, set redirect_stderr=true in order to redirect errors to the standard out log.
 
 ^ Make sure no duplicate section headers

7. Make sure the paths exist (use different paths if your central settings file points to different paths):

First is to check if these folders exist then if not, you create them. Refer to the main settings file to make sure these are the paths you're creating, otherwise, make sure the main settings file's paths exist. For context, /var/log or similar is for logging; /var/run or similar is for creating a PID when supervisor runs
```
sudo mkdir -p /var/run/supervisor
sudo mkdir -p /var/log/supervisor
sudo chown -R root:root /var/run/supervisor
sudo chmod 0775 /var/run/supervisor
```

```
sudo mkdir -p /tmp
sudo chmod 0775 /var/run/supervisor
```

Copy down these paths (PID run path, logging path, and test temp path for testing supervisor works) to wherever you keep track of important account information for your web host / VPS / dedicated services

8. Lets test if Supervisor have the ability to restart processes and keep them running
- Make sure your app settings have `/tmp/test.sh` and `/tmp/`, as command and directory, respectively.
- Create that test.sh file with this combined one-liner that echos to that filepath and allows permissions: 

```
sudo echo '#!/bin/bash' >> /tmp/test.sh; echo 'echo "hi";' >> /tmp/test.sh; chown -R root:root /tmp/test.sh; sudo chmod 0775 /tmp/test.sh
```


8. Run supervisor in the foreground:

Please notice we add `-n` at the end which stands for nodaemon (no background spirit)
If you have to adjust the filepaths, the first filepath is the main settings file and the second path is the supervisor logging file (not the app logging file)
```
supervisord -c /etc/supervisor/supervisord.conf -l /var/log/supervisor/supervisord.log -n
```

And if it refused to run, then you can shutdown using: `sudo supervisorctl shutdown`

And it should pass like this:
```
2024-07-22 11:39:37,327 DEBG fd 8 closed, stopped monitoring <POutputDispatcher at 139961815377680 for <Subprocess at 139961815377632 with name app1 in state STARTING> (stdout)>
2024-07-22 11:39:37,327 DEBG fd 10 closed, stopped monitoring <POutputDispatcher at 139961814279856 for <Subprocess at 139961815377632 with name app1 in state STARTING> (stderr)>
2024-07-22 11:39:37,327 INFO exited: app1 (exit status 0; not expected)
2024-07-22 11:39:37,328 DEBG received SIGCHLD indicating a child quit
2024-07-22 11:39:38,331 INFO spawned: 'app1' with pid 4147
2024-07-22 11:39:38,336 DEBG 'app1' stdout output:
hi


2024-07-22 11:39:38,336 DEBG fd 8 closed, stopped monitoring <POutputDispatcher at 139961815378208 for <Subprocess at 139961815377632 with name app1 in state STARTING> (stdout)>
2024-07-22 11:39:38,337 DEBG fd 10 closed, stopped monitoring <POutputDispatcher at 139961814279808 for <Subprocess at 139961815377632 with name app1 in state STARTING> (stderr)>
2024-07-22 11:39:38,337 INFO exited: app1 (exit status 0; not expected)
2024-07-22 11:39:38,337 DEBG received SIGCHLD indicating a child quit
2024-07-22 11:39:40,341 INFO spawned: 'app1' with pid 4148
2024-07-22 11:39:40,345 DEBG 'app1' stdout output:
hi


2024-07-22 11:39:43,355 DEBG fd 8 closed, stopped monitoring <POutputDispatcher at 139961815378208 for <Subprocess at 139961815377632 with name app1 in state STARTING> (stdout)>
2024-07-22 11:39:43,355 DEBG fd 10 closed, stopped monitoring <POutputDispatcher at 139961814279952 for <Subprocess at 139961815377632 with name app1 in state STARTING> (stderr)>
2024-07-22 11:39:43,355 INFO exited: app1 (exit status 0; not expected)
2024-07-22 11:39:43,356 DEBG received SIGCHLD indicating a child quit
2024-07-22 11:39:43,356 INFO gave up: app1 entered FATAL state, too many start retries too quickly
```


^ It's been truncated for this guide. It would repeat "hi" many times before it crashes because of "too many start retries too quickly". Normally you use Supervisor for processes that run continuously like a node server or a flask server / gunicorn server. So this is exactly what we want to see to pass Supervisor.

9. Cleanup of testing Supervisor

Remove test.sh file with:
```
rm /tmp/test.sh
```


10. Setup the 9001 Supervisor Web Portal

Useful to see all your Supervisor apps

Edit `/etc/supervisor/supervisord.conf` or appropriate file's inet http server section:
Make sure to come up with username and password
```
[inet_http_server]
; port=127.0.0.1:9001
port=0.0.0.0:9001
username=USERNAME      ; Optional: add for basic authentication
password=PASSWORD     ; Optional: add for basic authentication
```



Open port 9001 with iptables, ufw, firewalld, depending on what you're using for firewall. Refer to [[IPTables - Enable specific ports]], or [[UFW - Enable specific ports]], or [[firewalld - Enable specific ports]]


Restart supervisor in the foreground to see if we can access the web portal:
```
supervisord -c /etc/supervisor/supervisord.conf -l /var/log/supervisor/supervisord.log -n
```


Then visit domain.tld:9001, and attempt to login

If successful, save the Supervisor Web Portal credentials and URL to your webhost details document.

![](https://i.imgur.com/phza97X.png)


11. Be familiar with supervisord management

Restart supervisord in the BACKGROUND

Notice we removed -n which means to refer to the Supervisord primary config where nodaemon=false. This means supervisor can run in the background without interrupting your shell session and without exiting the shell session causing supervisor to terminate.
```
supervisord -c /etc/supervisor/supervisord.conf -l /var/log/supervisor/supervisord.log
```

If fails to restart, you can make sure it's shutdown with: `sudo supervisorctl shutdown`

For your OS equivalent, figure out how to check status, restart, and stop services. Eg:
```
sudo systemctl status supervisor
```

---

## 2. Install pyenv

Goal: We will install the virtual environment of the python interpreter (for example python 2.7.18). This will allow us to activate a specific python version per specific app that Supervisor manages.

1. Google how to install pyenv for your OS. Eg. Google: Ubuntu 22 install pyenv
  
For CentOS 6.1, it's:
```
curl -L https://github.com/pyenv/pyenv-installer/raw/master/bin/pyenv-installer | bash  
```

For Ubuntu 22.04 or Debian 12, it's:
```
sudo apt-get update && sudo apt-get install make build-essential libssl-dev \
zlib1g-dev libbz2-dev libreadline-dev libsqlite3-dev wget curl llvm \
libncursesw5-dev xz-utils tk-dev libxml2-dev libxmlsec1-dev libffi-dev liblzma-dev
```

```
curl https://pyenv.run | bash
```

Then restart the shell (or log out and log back in on SSH).

2. We will make sure the pyenv command works permanently.

When you ran the install script for pyenv, the last lines will tell you whether or not you have to add to your login shell's settings in order to initate pyenv so it can run virtual environments at a later time in the session

You might see something like this:
```
# Load pyenv automatically by appending
# the following to
# ~/.bash_profile if it exists, otherwise ~/.profile (for login shells)
# and ~/.bashrc (for interactive shells) :

export PYENV_ROOT="$HOME/.pyenv"

[[ -d $PYENV_ROOT/bin ]] && export PATH="$PYENV_ROOT/bin:$PATH"

eval "$(pyenv init -)"
```

Where to append this to? Refer to [[Fundamental - login shell, interactive shell, profile, bash_profile, bashrc, zshrc, zprofile]]. First figure out what shell you have by running `echo $SHELL` so that you know which shell configuration file to edit to. Then add the settings to the profile file (which is associated with login shells which you are using with SSH).

No need to add to the rc file which is for Interactive Non-Logged in Sessions. You wouldn't want to start supervisor, pyenv, etc without user authentication.

3. Test if the path is found:

If you just added the above into a bash or zshell configuration file, you need to reload the terminal with the new settings:
```
source ~/.bash_profile
```

Now actually test that pyenv command will work:
```
which pyenv
ls ~/.pyenv/bin/pyenv
```

If not found, refer to the script that the installer recommends you to add. For example, it saying "\$HOME/pyenv", then you run `echo $HOME` and figure out the path that got concatenated into \$PYENV_ROOT, which you can prepend in the shell configuration file like `export PATH="/root/.pyenv/bin/pyenv"`

---

## 3. Switch to python version with pyenv: Pyenv python version

Checkpoint: We now install pyenv and select a version for the folder/app

1. **Cd into the folder of your app. If you have no python app. We will create a test app. Create the folder first**
   
2. Decide which version of python you want which is based on your python syntax, compatible libraries, and your OS compatibility.

Then install the python to be available to pyenv

GoDaddy CentOS 6.1: Limited to 3.6.15 because the OS is old and no longer supported
```
pyenv install 3.6.15
```

Ubuntu 22 or Debian 12:
```
pyenv install 3.12.4
```

^ If it seems to be stuck on "Installing Python-...", just be patient. It's a long wait.

3. Then make the python version available to your project

```
pyenv local 3.12.4
```

What running `local` does is have the specified Python version (e.g., `3.8.10`) written to the `.python-version` file in the current directory AND `pyenv` determines which Python version.

You want to perform two checks to make sure this is successful:
- Check `.python-version`. Run `ls -la` to confirm there's now a `.python-version` file. That file has the version of python that your folder will switch to when running `local`. Running `pyenv version` or `cat .python_version` will show the python version from that file
- Check that `python --version` in the same folder especially now that you've ran `pyenv local...` will give you the correct python version. 
- If it does not it's because you have other paths earlier in the \$PATH that overridden pyenv's python:
	- Did you create symbolic links / shortcuts before? Like `sudo ln -sf /usr/local/bin/python2 /usr/bin/python`, OR `sudo ln -sf /usr/bin/python2 /usr/bin/python`. Confirm it's a symbolic link: In this case, you edit `vi /usr/bin/python` and see from the first line it points to an original file. Once confirmed, remove it, then run `source ~/.bash_profile` or the appropriate configuration file.
	- Did you assign an alias to python command in a shell configuration file (.bash_profile, etc)? Remove it, then run `source ~/.bash_profile` or the appropriate configuration file.
	- If the version still doesn't match pyenv's when you run `python --version`, restart the shell (or log out and log back in on SSH).

## 4. Enhance pyenv with virtualenvs so we can keep python dependencies isolated to the folder

Checkpoint: Now `pyenv local VERSION` selected a particular python version for the folder, we will install pyenv's virtualenv plugins which enhances pyenv so that pyenv can keep dependencies isolated to this folder (rather than isolating the dependencies to the python version setup across other pyenv apps)


1. See if `pyenv virtualenvs` is included in `pyenv` or you have to install it separately. In newer versions of pyenv, it's included already. Check by running: `pyenv virtualenvs` and if there is no error or any message, then it came included.
	- If virtualenvs didn't come included with pyenv, 
		- eg. Google: CentOS 6.1 install pyenv virtualenvs
		- eg. Google: Mac .. install pyenv virtualenvs
		- If CentOS 6.1:
		```
		sudo yum install -y git gcc zlib-devel bzip2 bzip2-devel readline-devel sqlite sqlite-devel openssl-devel  
		  
		git clone https://github.com/pyenv/pyenv-virtualenv.git $(pyenv root)/plugins/pyenv-virtualenv  
		```
		- If Mac's pyenv didn't come included: `brew install pyenv-virtualenv`

2. Create the pyenv virtualenv with this (Adjusting the python version to the locally specified version and the app name to one that's easy to remember):
```
pyenv virtualenv 3.12.4 app-test
```


3. Now make sure to activate that pyenv-virtualenv in the current shell session (Adjusting the app name if you had changed it from the previous step):
```
pyenv activate app-test
```

4. To confirm, your terminal's user prompt line should lead with the pyenv-virtualenv's name. Eg:
```
(app-test) root@srv:/home/domain/htdocs/domain.com/test #
```


5. FYI, for managing pyenv-virtualenvs in the future:
	- Show all ve's with `pyenv virtualenvs`
	- Show all python versions with `pyenv versions 
	- Delete a ve with `pyenv uninstall app1`

## 5. Enhance pyenv-virtualenvs with pipenv

Checkpoint: Now that you have the enhanced pyenv with pyenv-virtualenvs, we will enhance further with pipenv. The package pipenv could work independently from pyenv or pyenv-virtualenvs, but we will force pipenv to work with pyenv-virtualenvs to leverage all their benefits. Pipenv allows you to isolate dependencies to a folder using a Pipfile which is more reliable than running commands around requirements.txt.

1. Requirement 1: Proper Pip
You will install pipenv using the pip that's associated with the pyenv's python you specified. As long as your shell session is still in the pyenv-virtualenv,  you're using the pip associated with pyenv-virtualenv, or when you run `which pip` and the path mentions pyenv like `/root/.pyenv/shims/pip`

Troubleshooting: If an anaconda pip is overriding your pyenv's pip: 
- Move the $PATH around by prepending the pyenv's pip path (`/root/.pyenv/shims/pip`) inside $PATH at your bash profile. If that shims pip doesn't exist, the pip is found in your pyenv's current python path or your current virtualenv app path, for example  `/root/.pyenv/versions/3.12.4/bin/pip` or `/root/.pyenv/versions/3.12.4/envs/app-test/bin/pip`

2. Requirement 2: Latest build chains

Make sure have the latest pip and various build chains first in our virtual environment:
```
pip install --upgrade pip setuptools wheel  
```


3. Install pipenv in our virtual environment. Depending on your packages successfully installing or not later, you have these options to install pipenv  

```
pip install pipenv
```


You can confirm that the pipenv is associated with the pyenv's pip's site-packages by running this command and checking the path:
```
pip show pipenv
```

Eg. This passes:
`Location: /root/.pyenv/versions/3.12.4/envs/app-vlai/lib/python3.12/site-packages`

1. Run this command to create a virtual environment using Pipenv and Pyenv working together:
```
pipenv --python $(pyenv which python)
```

^ How this works is `$(pyenv which python)` returns the path to the current active Python interpreter managed by Pyenv, then we set that python to Pipenv, ensuring that we have compatibility between Pipenv's packages and the Python used in this folder. The key is that pyenv is currently activated, either with `pyenv local VERSION` or `pyenv activate APP` (and that APP was created with pyenv virtualenv to be at a specific python version)


2. Install your packages:
	- If you're installing from all these systems (Supervisor, Pyenv, etc) the first time, test by installing package(A). 
	- If you're following this guide because you're migrating an app to another server that already have these systems globally but not configured for your app yet, and you have a Pipfile copied over (and you made sure it's `"*"` or appropriate versions), then install from Pipfile (B).
	   
   
	- **If A:** Test by installing package
Run:
```
pipenv install pymongo
```

Create test.py:
```
import sys
import platform

# Show Python version
print(f"Python version: {platform.python_version()}")

# Show path to the Python executable
print(f"Python executable path: {sys.executable}")

######################################################################

import pymongo
import os

# Show pymongo version
print(f"pymongo version: {pymongo.__version__}")

# Show path to pymongo module
print(f"pymongo module path: {os.path.dirname(pymongo.__file__)}")                                                          
```

Then run the test file:
```
python test.py
```

For success, both python and pymongo should hint at pyenv and your pyenv-virtualenvs in the folder path:
```
Python version: 3.12.4
Python executable path: /root/.pyenv/versions/app-test/bin/python
pymongo version: 4.8.0
pymongo module path: /root/.pyenv/versions/app-test/lib/python3.12/site-packages/pymongo
```

If fail, then you may need to add paths to your .pyenv apps' python and to your .pyenv app's python's site-packages

DO NOT remove the test.py file yet.

- **If B**: Install from Pipfile (You're migrating in):

Make sure in the same folder where `Pipfile` is at, then simply run:
```
pipenv install
```

3. OPTIONAL STEP: Once your app can run when you run the python script, get the versions of the packages saved into Pipfile so future migrations are simple.
   
   Edit Pipfile and look for these:
```
[packages]
pymongo = "*"
```

Change into the versions that pipenv installed for each module (refer to "A. Test by installing package" from the previous step which has the script that tells you the version number after importing a module)
```
[packages]
pymongo = "==4.8.0"
```

FYI, in the future you migrate the app including Pipfile then you activate pyenv-virtualenv and with pipenv, you install from the Pipfile running: `pipenv install`

Nuances: Pipenv has their own virtual environment so you can isolate the dependencies to that folder, however because you activated a virtual environment in pyenv-virtualenv, the Pipenv will use the virtualenv from pyenv. Pipenv is built to either be independent or work with pyenv-virtualenv.
  
---


## 6. Prep sh file


Checkpoint: We have python version isolated to the folder. For the packages to be isolated to the folder, we could've used pyenv-virtualenvs's pip but instead we used pipenv tethered to pyenv's virtual environment, therefore we can use the pipenv's Pipfile that migrates well. Next we need to create a .sh script file that can run multiple commands from activating the virtual environment to running the python script, so that the python script will use the expected python version and expected packages.

1. Knowing that Supervisor runs shell script that activates virtual environments and runs your python, let's create this supervisor.sh in our test folder. Make sure to use absolute path:

supervisor.sh:
```
#!/bin/bash

export PYENV_ROOT="$HOME/.pyenv"
export PATH="$PYENV_ROOT/bin:$PATH"
if command -v pyenv 1>/dev/null 2>&1; then
	eval "$(pyenv init -)"
	eval "$(pyenv virtualenv-init -)"
fi

cd /home/wengindustries/htdocs/wengindustries.com/test
python test.py
```

Add execution to supervisor.sh:
```
sudo chmod u+x supervisor.sh
```

Test running of the .sh file directly:
```
./supervisor.sh
```

If it runs the test.py showing you the python and pymongo versions and filepaths that hint at pyenv python version and the pyenv app's packages, then it's a success. Like this:

```
Python version: 3.12.4
Python executable path: /root/.pyenv/versions/app-test/bin/python
pymongo version: 4.8.0
pymongo module path: /root/.pyenv/versions/app-test/lib/python3.12/site-packages/pymongo
```

Checkpoint: You do not need to test supervisor app's config pointing to the .sh file in a productive environment because we had already tested this in the first step of installing Supervisor. This means Supervisor can restart when the server crashes and it can restart the shell script if the shell crashes, and the shell script can run the python script. 

You now have all the knowledge to successfully scale python scripts using a combination of Supervisor - Pyenv-virtualenv - Pipenv. 

**But do you need to continue by adding Gunicorn?**
You may need more than one of your python scripts running especially if a lot of users go on and you find that your script is synchronous and blocking other users causing your website to crash. This especially happens when your website does some processing (creating videos, etc).

At the last line of your .sh file, you can run gunicorn instead of running a python script directly. With Gunicorn, it can restart python scripts that crash. With gunicorn, we can run on SSL, asynchronously, with multithreading and multiple worker processes.

Gunicorn would have to be installed inside an active pyenv-virtualenv+pipenv session. Remember that gunicorn runs an intermediate python file, conventionally wsgi.py, that then runs your python script, so you will be creating a wsgi.py file. For more details on gunicorn, refer to the [[Gunicorn for Scaling - Primer including math]]. Otherwise, the rest of the tutorial will leverage Gunicorn and SSL bearing in mind multiple users traffic and high cpu use with processing and waiting on a server response to the frontend fetch's callback.

## Leveraging Gunicorn

Again: With Gunicorn, it can restart python scripts that crash. With gunicorn, we can run on SSL, asynchronously, with multithreading and multiple worker processes. Setting the number of threads and worker processes should be best done on different parts of a microservices architecture based on whether they're high CPU use or requires waiting on response or has high I/O and that is outside the scope of this tutorial. Refer to...

1. Make sure to have a new supervisor app config file or modify the test supervisor app config file to point to a .sh file in your app. 
2. Create the .sh file in a conventional way. I recommend in your app's folder: `infrastructure/supervisor_layer/HOSTNAME.sh` You can have another one named dev.sh that runs on localmachine supervisor tests
3. Make sure to have gunicorn installed via the pyenv tethered to the pyenv-virtualenv's ve
4. The shell file can be:
```
#!/bin/bash

DIR_APP_ROOT=/home/bse7iy70lkjz/public_html/APP/app-TEST/
DIR_APP_SH=/home/bse7iy70lkjz/public_html/APP/app-TEST/container


# REQ: Initiate pyenv and pyenv-virtualenv
export PYENV_ROOT="$HOME/.pyenv"
export PATH="$PYENV_ROOT/bin:$PATH"
if command -v pyenv 1>/dev/null 2>&1; then
  eval "$(pyenv init -)"
	eval "$(pyenv virtualenv-init -)"
fi

cd $DIR_APP_ROOT
pyenv activate app-test

# CASE: ImageMagick which MoviePy uses
export MAGICK_HOME="$(dirname $(which convert))"

# CASE: Worker timeouts can be caught
#   Function to handle termination signals
term_handler() {
  echo "Termination signal received, stopping Gunicorn..."
  kill -TERM "$gunicorn_pid" 2>/dev/null
}
#   Trap termination signals
trap 'term_handler' SIGTERM SIGINT

# SSL PATHS via .env.local
cd $DIR_APP_SH
export $(grep -v '^#' ../.env.local | xargs)
# echo $SSL_CERT_PATH

cd $DIR_APP_ROOT
gunicorn wsgi:app -b 0.0.0.0:5001 --worker-class=gevent --timeout=600 --workers=5 --threads=3 --worker-connections=1000 --max-requests=1000 --max-requests-jitter=100 --certfile="$SSL_CERT_PATH" --keyfile="$SSL_KEY_PATH"

# CASE: Worker timeouts can be caught... Continue
#   Capture Gunicorn PID
gunicorn_pid=$!
echo "Gunicorn PID: $gunicorn_pid"
#   Wait for Gunicorn process
wait "$gunicorn_pid"
```


Confirm shell file can run successfully. Run the shell file directly (no interpreter command needed) eg.
```
./infrastructure/supervisor_layer/HOSTNAME.sh
```

Confirm Supervisor successful at running your app:
- Grep for gunicorn
```
ps aux | head -n 1; ps aux | grep supervisor;  ps aux | grep gunicorn  
```
- Grep for script.py - if you skipped gunicorn:
```
ps aux | head -n 1; ps aux | grep supervisor;  ps aux | grep script.py  
```
- Visit your website at the port to check your python script is working


You may need to enable the port through your server's firewall. Refer to [[UFW - Enable specific ports]] if ufw was enabled. Instructions to check ufw is enabled are also there. Your firewall could also be iptables instead of ufw; in that case refer to [[IPTables - Enable specific ports]]

---

### Folder structure

Recommend Supervisor app config files be named with the port number ranges they use