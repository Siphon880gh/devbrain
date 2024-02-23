Python's official website is at: https://www.python.org

## Basic Setup

Mac has an older version of python so make sure you update:
```
brew install python
```

You can write python code in .py files, then you can run them with this command:
```
python app.py
```

If using Visual Code, you can install python extensions to format your code and have a convenient run button at the top right.

## Basic Syntax:
Notice function starts with the keyword `def` and it ends based on indentation patterns. 
Notice how to call the function. 
There is no semi-colon to end a line of code. 
Notice multiple variables can be defined inline.
```
def fib(n):
    a, b = 2, 1
    print(a)
fib(1000)
```

You can import built-in or packaged modules:
```
import sys, os, time, json
import threading
import webbrowser
from http.server import HTTPServer, BaseHTTPRequestHandler
from urllib.parse import parse_qs, quote_plus
import requests
import ssl
```

To get a packaged module, python's package manager is pip. Python3's package manager is pip3:
```
pip install __
pip3 install __
```

There are other package managers that are better:
Conda is not only a package manager that helps you find and install packages, but if you need a package that requires a different version of Python, you do not need to switch to a different environment manager, because conda is also an environment manager. With just a few commands, you can set up a totally separate environment to run that different version of Python, while continuing to run your usual version of Python in your normal environment.

About Conda:
https://docs.conda.io/en/latest/

Download/install Conda:
https://docs.conda.io/projects/conda/en/latest/user-guide/install/macos.html

Not to be confused with Anaconda which is a software/package suite that includes many things you need for data science such as python, Jupyter, etc.