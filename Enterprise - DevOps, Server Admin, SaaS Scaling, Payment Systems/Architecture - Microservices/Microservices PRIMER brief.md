

Consider breaking your app into parts called microservices. That allows you to allocate one part more to cpu and another part more to concurrency, eg respectively: video generator and api. For the microservices to communicate with each other, you give them ports

You can use tools like gunicorn (if python code) to achieve this

There are microservices that directly communicate with the webpage and there are those that can only work internally in your app

When the microservices is an api for your web app, your gunicorn could bind to internet 0.0.0.0 at say port 5001. Don’t forget to allow the port in your firewall whether it’s iptables (cloud panel uses), ufw, etc.

For things like a video generator that you don’t want people online to exploit, you can bind to 127.0.0.1 to let’s say for port 5002

Your api would make a request (import requests) to port 5002 over http://127.0.0.1:5002/endpoint and it would be over http. So your gunicorn for that microservice does not have ssl settings, nor does your python flask app (for running python flask script directly). Your python flask script app has the endpoint and imports in the video generator function to receive inputs and respond with outputs. Your request json may be changed into arguments easily: say your json is already parsed as dictionary value. You can pass that value into your function call with double asterisk to convert it into arguments: **dict

---

You have a folder microservices of api, video generator, etc. Pathing could be a problem, especially when those microservices create files.

You’ll want to get the absolute path to the script, then change path up (../) and down as necessary. NodeJS and Python have their own ways to do this

python:
```
script_dir = os.path.dirname(os.path.abspath(__file__))  
app_dir = os.path.join(script_dir, "..")  
```

with python, you may be importing modules from the app root, so you can do:
```
import sys  
sys.path.append(app_dir)
```

nodejs:
```
const path = require('path');  
  
// Get the directory of the current script  
const scriptDir = __dirname;  
  
// Get the parent directory of the current script's directory  
const appDir = path.join(scriptDir, '..');
```

---

You'll want to research for a redis web panel
eg. phpRedisAdmin