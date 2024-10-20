
You’re working on a repo while following a youtube video tutorial and that video may be way out of date. Running pip install  will install the latest packages which is not what you want because the video instructions will be wrong or even incorrect syntax.

Keep in mind the youtube video’s date

## Repo

**Then it’s gonna get difficult:**  
- Get the date of the Youtube tutorial you want to work
- You’ll make sure to install a local python version separate from your global python, and that version will be on or before the date, assuring compatibility. A python version could be mentioned in myproject.toml (poetry) or .python-version (pyenv), or Pipfile (pipenv but specifying the python version is optional). Make sure to switch to that python version. These package lists have versions, but you can reverse lookup the package’s version for their date on Pypi. Just get the ballpark what date the packages all converge to.
- Note there are python packages that are just wrappers for cli installed on the system (like with brew, or apt-get). So you may need a separate VM or install such older versions on the system (brew, apt-get, etc) so those desired older python packages don’t conflict with your system’s newer cli tools.

**Decide appropriate branch or a main/master commit, by date**
Get a branch or master/main commit that approx is on or before the Youtube tutorial. That’s the branch or commit you will clone to your computer.

If the current repo is drastically different (eg. a ui app when the video tutorial covered a cli app, then it likely had a branch. If the developer used branches for major versions like ui vs cli versions, then it’s a good route to look into branches. if the developer used branches only for features or hardly use it, then it might not be the best route to take)

Eg. Main/master commit. See all commits and get the specific commit ID based on date
(if date not specific eg. says last week, then web browser inspect it which has date)
![](https://i.imgur.com/2Enfew2.png)

If looking into branches, you need to visit the branches/all
![](https://i.imgur.com/bTkdSnI.png)

Make sure you’re under “All” tab and not “Overview”. If Updated column shows “months ago” or “years ago”. Inspect for the date
![](https://i.imgur.com/cOBQ1Yd.png)

**Get into local development**  
To clone a specific branch:
```
git clone --branch <branch-name> <repository-url>
```

Or, to get the desired commit from master/main, you have to clone the default branch, then reset to the desired comment:
```
git clone <repository-url>  
cd <app>  
git reset --hard <commit-id>
```

## Python Packages

Now it’s about installing the python packages. See if there’s a requirements.txt, or docker, or poetry (.toml file). Follow appropriate section:

### Docker

Build and run the docker container:  
This command will build the Docker image using the Dockerfile in your PrivateGPT project
```
docker build -t privategpt .
```

Run the container (container is created from the Docker image) in interactive mode, and that way you can run terminal commands:
```
docker run -it privategpt bash  
```

Btw if you need to mount directories as volumes so you can upload files to it, etc
```
docker run -it -v /path/to/host/dir:/path/to/container/dir privategpt bash  
```

Whether or not the container has the intended Python/Pip version depends on how the Docker image (from which the container is created) was built, but with a Docker file in the repo the answer is likely yes. It will likely have a requirements.txt. Install with `pip install` 
### Requirements.txt (No Docker)

Have requirements.txt. Run `pip install` . The packages should be compatible with each other because you’re running their installations. But there is the possibility that packages fail to install because they’re actually wrappers of cli tools on your system or rely on cli tools on your system, while your system’s cli tools are much newer than the desired old python packages. In that case you need Docker or a VM.
### Pipfile

If you see a Pipfile, that means the developer expects you to use pyenv and pipenv together. By having pipenv, the packages installed does not pollute pyenv’s python installation’s packages folder. Pipenv makes sure packages are project-specific. With pipenv, you can install off the Pipfile. Briefly:
```
pyenv install <python-version>  
pyenv local <python-version>  
pip install pipenv  
pipenv install # Installs from Pipfile  
```

### Poetry

Have a .toml file which means you can use poetry.

Based on the date of the youtube video tutorial - look for python version with a release date that’s on or older: [https://www.python.org/doc/versions/](https://www.python.org/doc/versions/)

Use pyenv to install that python version, and then use that version

Let’s say the appropriate python version is 3.10.0:
```
pyenv install 3.10.0  
pyenv local 3.10.0  
python --version
```

If it doesn’t switch, initiate pyenv:
```
pyenv init --path  
```

Once you have switched over, you should install:
```
pip install poetry
```

Test poetry works by running:
```
poetry
```

Then you can install from the toml file:
```
poetry install
```

In order to run the packages that were installed inside poetry, you have to run
```
poetry shell
```

 That kicks you into poetry’s virtual environment with its own packages, python, and pip. Well, that’s the hope anyways:

You may want to check that the poetry shell is using its own python, which you want to be the case, because you want to use its associated pip’s packages that poetry just installed. Sometimes the computer will still fallback on other versions of python rather than let poetry take over. Run this to help check:

```
whereis python  
```

First path, if more than one, should be a poetry created path like 
```
/Users/wengffung/Library/Caches/**pypoetry**/virtualenvs/privategpt-LcxwhDfB-py3.10/bin/python 
```

**If another python is taking over**, then your poetry packages won’t be picked up when being imported by the python scripts. You’d have to modify your system paths

And, add and make sure it’s the final PYTHONPATH if any exists at your .bash_profile, .zsrc, etc. **Please adjust pythonX.Y/** to the version number you saw from `syst.path`:
```
# Poetry  
if command -v poetry &> /dev/null  
then  
        export PYTHONPATH=$(poetry env info --path)/lib/python3.10/site-packages:$PYTHONPATH  
fi
```

If you were fixing the python path for poetry shell, exit out of the poetry shell (sourcing bash_profile etc wont work), restart your terminal, then return back to the poetry shell.

---

## **The rest...**

Once the python packages install successfully, you can start using the repo’s script or following the youtube video.