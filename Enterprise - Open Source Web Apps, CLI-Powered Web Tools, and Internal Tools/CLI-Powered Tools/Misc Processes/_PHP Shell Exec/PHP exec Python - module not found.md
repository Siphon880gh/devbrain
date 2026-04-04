
Is your python script isn't running because of a python module not being found even though you had ran 'pip3 install \_\_' in the shell?

After you installed the python3 module, say you ran this in terminal `python3 script.py` successfully. Then you will think this works when PHP runs exec: `exec("python3 script.py"))`? Not guaranteed. The python script that runs in the shell will have different module lookup path than the python script that runs from the PHP exec() shell.

We will first prove this by showing the lookup path of Python packages when python was invoked from the shell versus when it was invoked by PHP's exec

But first make sure you know the cause of your python script not running. 
- Is your python script not running because of a python module not being found (which this lesson addresses) or is it because python3's path isn't found by PHP (Hence the python3 part doesn't work from `exec("python3 script.py")`.
  
If it's the latter case (python3 or the command not in the PHP's PATH), refer to the lesson:
[[PHP exec - Command not found]]

---


There's a command used to display information about a particular package, including its location. When you run `pip3 show requests`, it will provide you with a list of metadata about the `requests` library.

Here's how you can use it:

```bash
pip3 show requests
```

This command will output something like this:

```
Name: requests
Version: 2.25.1
Summary: Python HTTP for Humans.
Home-page: https://requests.readthedocs.io
Author: Kenneth Reitz
Author-email: me@kennethreitz.org
License: Apache 2.0
Location: /usr/local/lib/python3.9/site-packages
Requires: certifi, chardet, idna, urllib3
Required-by:
```

^Referring to the "Location" field, we see that the library is installed at `/usr/local/lib/python3.9/site-packages`.

If it works when running `python3 script.py` that has `import requests` in the code, then you know python has `/usr/local/lib/python3.9/` as an executable lookup path. Alternately, you could have a python script show the paths it looks up when importing

```
import sys

# Print all the paths Python looks into for modules
for path in sys.path:
    print(path)

```

This is simply the path to import python

----

You may need to add a path while inside the python code to make it match the path shown when you ran `pip3 show ___`:
```
import sys

# Directory you want to add
new_directory = "/path/to/your/directory"

# Add the directory to sys.path
sys.path.append(new_directory)

# Now you can import modules from the new directory

``` 


