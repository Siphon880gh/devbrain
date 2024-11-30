When you download from git repositories, you may see myproject.toml (for poetry) as the way to have a consistent python version and packages. Or you may want to use poetry for this reason as well.

Test poetry works by running (If needed: `pip install poetry`):
```
poetry
```

Then you can install from the toml file:
```
poetry install
```

At this point, poetry has installed all the packages from the toml file! 

In order to run the python scripts with the packages that were installed inside poetry, you have to run
```
poetry shell
```

That kicks you into poetry’s virtual environment with its own packages, python, and pip. Well, that’s the hope anyways:

You may want to check that the poetry shell is using its own python, which you want to be the case, because you want to use its associated python packages that poetry just installed. Sometimes the computer will still fallback on other versions of python rather than let poetry take over. Run this to help check:
```
whereis python
```

There could be one path that shows up or multiple paths. If multiple paths, the first path, should be a poetry created path like (the folder is created with a name after the current folder you're running poetry from):
```
/Users/wengffung/Library/Caches/pypoetry/virtualenvs/privategpt-LcxwhDfB-py3.10/bin/python 
```

**If another python is taking over**, then your poetry packages won’t be picked up when being imported by the python scripts. You’d have to modify your system paths

And, add and make sure it’s the final PYTHONPATH if any exists at your .bash_profile, .zsrc, etc. **Please adjust pythonX.Y/** to the version number you saw from `syst.path` :
```
# Poetry  
if command -v poetry &> /dev/null  
then  
        export PYTHONPATH=$(poetry env info --path)/lib/python3.10/site-packages:$PYTHONPATH  
fi
```

If you were fixing the python path for poetry shell, exit out of the poetry shell (sourcing bash_profile etc wont work), restart your terminal, then return back to the poetry shell.