
## All

### Supervisor
GoDaddy CentOS 6.1 is an old OS. As a VPS, it cannot support Docker, but it can support Supervisor which will help you manage restarts of your app when the server or app crashes

### Supervisor with .sh file
The Supervisor can run a .sh file that runs all the necessary commands to set the correct virtual environment and then run the app. 


### .sh file runs gunicorn
The app is a flask app but we want to  scale up to multiple concurrent users under the same CPU and https 5001 port. 

In comes Gunicorn which is the Python WSGI HTTP Server for UNIX that allows HTTPS (SSL) connections and having multiple worker processes

Therefore the .sh file runs gunicorn which runs wsgi.py which runs server.py. The gunicorn command runs with worker process options (set to a multiplication of your cpu cores) as well as SSL cert paths. Hot tip: If you have personal notes you refer to whenever you renew your SSL, it should also mention updating the sh file that supervisor manages, particularly the gunicorn command with the SSL cert file paths

### .sh file actually runs pyenv first
Actually before the .sh file runs gunicorn, it needs to set the correct virtual environment. This is especially important since the old Cent OS 6.1 can only support and old version of python and it can only support certain dependencies. By having pyenv activate the environment, it assures it's the python version we need. Tied to pyenv is also the specific dependencies that were setup by pipenv. We do not need to activate the virtual environment of pipenv because pyenv virtual environment has their pip packages kept consistent by pipenv and the settings are kept inside pyenv.

---

## Supervisor

Supervisor is as service that's managed using the service commands. But when you first run it, you run the supervisor process directly, passing it the preferred log file path

When Supervisor runs, it checks for all app conf files. In an app conf file is where I wrote a command to run the shel file (sh PATH/TO/.sh)

Supervisor will restart the .sh file if the server crashes / reboots, the .sh file crashes (bad commands), or an app the .sh file manages crashes. You can see log file though, that if it crashes too often in a short time then it will stop trying.


---

## Pyenv and Pipenv init

When first setup, pyenv was created with specific python version in mind at the app folder. The pipenv was created, and installed packages, which are kept in Pipfile and Pipfile.lock

Then whenever I am about to start Supervisor, I make sure to activate the pyenv environment first, then I run the supervisor process with the log file option second. Any supervisor management in the future will be delegated to the service commands. 

May need to ps aux and pipe into shutting down the gunicorn and the supervisor in the future.