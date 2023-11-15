
Say you ran this in terminal then you will think this works when PHP runs exec? Nope. Php is a different environment with their own installation paths

---


Show the lookup path of Python packages when it’s PHP invoking a shell for python, OR if it’s a Python script invoked by shell

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

In this example, the "Location" field indicates that the `requests` library is installed in `/usr/local/lib/python3.9/site-packages`.
