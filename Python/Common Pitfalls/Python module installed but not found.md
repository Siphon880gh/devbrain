
If you're receiving a message that the requirement for the requests library is already satisfied when you installed with pip or pip3, but when running the Python script you still encounter a ModuleNotFoundError trying to import that module, there are a few possible reasons for this:

Check your Python environment: Make sure that you're using the Python interpreter and pip installer from the same environment. You can check which Python environment pip is using with which pip or which pip3 on Unix-like systems, or where pip or where pip3 on Windows. Do the same for Python with which python or which python3 on Unix-like systems, or where python or where python3 on Windows.

Running a Python script in a terminal vs running it in a php file's exec
Yep different environments and Python install paths

Check if the library is in the correct site-packages: You can list the installed packages with pip list or pip3 list and see if requests appears there. You can also find the location of the installed modules with pip show requests or pip3 show requests.
