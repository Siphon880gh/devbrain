
Pyenv: Activating a consistent python version and able to switch python versions in the same project

Pyenv-virtualenv - Create virtual environments tied to specific Python versions managed by Pyenv. With a virtual environment, it keeps consistent pip and packages within a specific Python version. by generating a self-contained directory that includes the python interpreter and a "site-packages" directory. It leverages a separate tool it'd install automatically - virtualenv - hence the name pyenv-virtualenv. The virtual environment is considered weak compared to pipenv which makes your packages portable via a Pipfile and `pipinstall install`

Pipenv - Activating consistent packages and tracking them in a portable Pipfile file. Can combine with the above two: By activating a pyenv-virtualenv environment before starting a Pipenv environment, the Pipenv will continue to make packages portable with a Pipfile but will tie into the pyenv-virtualenv's virtual environment instead of nesting another virtual environment. This is a hybrid approach of Pyenv-virtualenv and Pipenv's Pipfile.


Refer to [[Supervisor Primer - Concepts]] at relevant sections. Supervisor is usually combined with pyenv, pyenv-virtualenv, and pipenv

