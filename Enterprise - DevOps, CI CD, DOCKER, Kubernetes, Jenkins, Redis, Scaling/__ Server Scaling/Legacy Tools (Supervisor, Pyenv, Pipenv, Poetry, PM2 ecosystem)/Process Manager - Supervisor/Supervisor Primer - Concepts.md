## Supervisor with gunicorn, pyenv, pipenv - Must read before


Install whatever packages you want this app to have isolated from your system and portable to other systems when you migrate the folder to a server, for example (with pipenv). The python interpreter used is also portable (with pyenv)

Using this approach, you get the benefits of managing Python versions globally with `pyenv` and the benefits of isolated virtual environments with `pipenv` for each of your projects. This ensures that your projects have consistent Python versions and dependencies, making it easier to manage and collaborate on different Python projects.

The other tool venv/virtualenv can do all that, but gets wiped out if anaconda is on the system.

You’ll activate pyenv environment first, then apply pipenv


And Supervisor helps restart the app and manage other apps. Unfortunately it doesn’t let you split work processors (in parallel scripts if they are synchronous). So you need to supervise gunicorn apps instead. 

So for example, lets say your app is really a Flask app. You have gunicorn that loads your Flask app that’s in the pyenv and pipenv envrionment and gunicorn exposes the port. gs. The exposed port will split the worker processes


Using Both

pyenv and pipenv are two different tools used for managing Python environments, but they serve different purposes and have distinct features:
Purpose:
pyenv: pyenv is primarily used for managing multiple Python installations on your system. It allows you to switch between different Python versions easily, set a global default Python version, and create virtual environments with specific Python versions.
pipenv: pipenv is used for managing project-specific dependencies and virtual environments. It aims to simplify and centralize the management of dependencies, ensuring that your project uses the correct packages and versions.
Functionality:
pyenv:
Manages Python versions.
Helps you switch between Python versions globally or per project.
Doesn't directly manage project dependencies but can be used in conjunction with virtual environments (e.g., virtualenv) for that purpose.
pipenv:
Manages project-specific virtual environments.
Manages project dependencies using a Pipfile and Pipfile.lock to lock package versions.
Simplifies the creation of virtual environments, installation of dependencies, and management of environment variables.
Use Cases:
pyenv: Used when you need to manage multiple Python versions on your system, such as for different projects or to work with legacy Python versions.
pipenv: Used when you want a consistent and isolated environment for a specific Python project. It's especially useful for development workflows where you need to ensure that all team members are using the same dependencies and versions.
Typical Workflow:
pyenv:
Install and manage multiple Python versions using pyenv.
Create virtual environments with specific Python versions (e.g., pyenv virtualenv 3.8.12 myenv).
Activate a virtual environment when working on a project (pyenv activate myenv).
Use pip or pipenv within the activated virtual environment to manage project dependencies.
pipenv:
Create a new project folder.
Use pipenv to initialize a virtual environment and generate a Pipfile (pipenv install can also be used to install dependencies).
Activate the virtual environment (pipenv shell) or run commands within it (pipenv run).
Use pipenv commands to manage dependencies and the environment.
In summary, pyenv focuses on managing Python versions on your system, while pipenv is designed for managing project-specific dependencies and virtual environments. They can be used together, with pyenv managing Python versions and pipenv managing project-specific environments and dependencies, providing a comprehensive Python development environment.



Conundrum with Anaconda

Managing Anaconda, pyenv, and pipenv:
To manage these tools effectively together, you can:
- Use pyenv to switch between different system-wide Python versions independently of Anaconda.
- Use conda environments for projects where you want to leverage Anaconda's package ecosystem.
- Use pipenv for projects that you want to manage separately from both Anaconda and system-wide Python installations

Before installing pyenv with pip or installing other packages with pyenv, first make sure you’ll be using pyenv’s pip and it’ll be installed as pyenv’s pip’s pipenv rather than anaconda’s. Otherwise you’ll likely have package incompatibility or distributions not being found complaining about: `File "/Users/wengffung/anaconda3/bin/pipenv` etc

You ensure this by:
Activate pyenv’s python to take precedence for the current shell (by placing pyenv before all other python paths)
export PATH="$(pyenv root)/shims:$PATH"
eval "$(pyenv init -)"

You can confirm both pip and pyenv are not using anaconda’s paths with:
which pip
pip show pipenv



Before using Pyenv or Pipenv, see if there’s a (base) at your terminal:
(base) User@Computer someFolder %


That means you have an anaconda environment! You want to deactivate that with:

`conda deactivate` 


So that your terminal is correctly:
User@Computer someFolder  %

---

## Different Pipfiles

  

You might need different Pipfile for different pipenv IF your development server and the remote server are too many generations different that you’re forced to use much older python versions between the two. In that case I recommend two versions of Pipfile and Pipfile.lock and having package.json npm script commands to copy the right version for pyenv install purposes. For instance:

  

  "scripts": {  
    "help": "cat package.json",  
    "pipenv-dev": "cp Template-Dev-Pipfile Pipfile; cp Template-Dev-Pipfile.lock Pipfile.lock",  
    "pipenv-prod": "cp Template-GoDaddy-Pipfile Pipfile; cp Template-GoDaddy-Pipfile.lock Pipfile.lock"  
  },