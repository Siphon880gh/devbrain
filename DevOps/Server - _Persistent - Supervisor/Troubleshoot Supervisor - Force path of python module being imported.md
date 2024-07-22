
Category-wise: Placed here because often with Supervisor and migrating you may have problems with python packages not importing in your python script.


Run
```
pyenv exec python -m site
```

Then check each folder. You get an output like this:
```
sys.path = [

    '/home/bse7iy70lkjz/public_html/storyway/app-vlai',

    '/root/.pyenv/versions/3.6.15/lib/python36.zip',

    '/root/.pyenv/versions/3.6.15/lib/python3.6',

    '/root/.pyenv/versions/3.6.15/lib/python3.6/lib-dynload',

    '/root/.pyenv/versions/app4/lib/python3.6/site-packages',

]

USER_BASE: '/root/.local' (exists)

USER_SITE: '/root/.local/lib/python3.6/site-packages' (exists)

ENABLE_USER_SITE: False
```


You may want to run `ls` on those directories to find which one has the python package that claims to be missing or cannot be imported

Then prepend it into your python script
```
import sys

sys.path.insert(0, '/Users/wengffung/.local/share/virtualenvs/storyway-A39rOKjm/lib/python3.8/site-packages')

sys.path.insert(0, 'root/.pyenv/versions/app4/lib/python3.6/site-packages')
```


For cleaner code between different server migrations, you can have a build script that you run on the server. Depending on the server, the python package directory being prepended should be changed.

---

Note when asked chatgpt will recommend `sys.path.append`. Sys.path.insert at 0 is better because the path will be ran first before all other paths when looking for python package.