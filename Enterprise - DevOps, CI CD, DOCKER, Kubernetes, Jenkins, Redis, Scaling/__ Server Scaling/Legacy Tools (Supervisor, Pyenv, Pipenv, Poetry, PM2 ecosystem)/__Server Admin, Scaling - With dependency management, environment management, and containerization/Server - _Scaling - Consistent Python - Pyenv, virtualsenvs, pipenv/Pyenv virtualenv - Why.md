
**Why use `pyenv-virtualenv` (not just for managing Python versions):**  
While `pyenv` lets you choose a specific Python version for a project using `pyenv local <version>`, it doesn't isolate dependencies to folder paths. If you install a package with `pip`, that package is installed into the **site-packages for that Python version**, **shared across any folder using that version**. By installing the `pyenv-virtualenv` plugin, you can create virtual environments that keep dependencies isolated per project directory—so different projects using the same Python version won’t interfere with each other.

How it does that is that with your pyenv activated in a python version, then you activate or start a new virtenv, let's say `app-test`, any packages you installed with `pip` goes to this .pyenv-like path as well as it is an virtual-env-like path (named after your pyenv virtualenv app name):

```
/root/.pyenv/versions/3.12.4/envs/app-test/lib/python3.12/site-packages`
```

And you can demonstrate this by running `pip show PACKAGE_NAME` that's installed from the same pyenv virtenv and you run it while in that pyenv virtenv.