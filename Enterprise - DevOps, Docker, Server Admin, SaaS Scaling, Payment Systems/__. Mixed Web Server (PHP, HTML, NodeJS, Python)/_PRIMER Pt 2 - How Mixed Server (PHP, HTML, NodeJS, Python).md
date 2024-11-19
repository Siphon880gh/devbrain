Aka: Get Started

When you reverse proxy a friendly url to a true ported url like domain.tld:300X or domain.tld:500x for nodejs express and python flask servers, there are a lot of setups involved.

This tutorial assumes you're using nginx for the php and html web server. If you're on apache, find the equivalent instructions, as I don't want this tutorial to get too scattered.

This tutorial also assumes you have root access on VPS or dedicated server and you already installed the nodejs or the python interpreter on your server.

---

Now there are problems with pathing you have to solve to make sure your website app still works

- React becomes a problem because it likes to deal with assets and linking to the root domain.tld/ instead of where the code is at domain.tld/app/app1.
- Your frontend api calls using fetch or jquery $ if calling itself will need to prefix the app base path
- Your frontend URL manipulation like pathname, assign, href, etc will need to be prefixed with the app base path. Refer to [[_REFERENCE - Frontend sourcing, hrefing, and js locationing after migrating to a server with base url]]
- The backend code for express or flask (Nodejs or Python) expects root path because when you wrote and tested code in local development it automatically uses root path like localhost:3000/ (equivalent to domain.tld:80/ or domain.tld:443/ which in the browser is [http://domain.tld](http://domain.tld "http://domain.tld") or [https://domain.tld)](https://domain.tld) "https://domain.tld)"). Here you need your vhost to match the /app/app1 but internally rewrite it as /, so your api endpoint matching still works 
  _REWORDED: Because your nodejs or python app was likely developed from a local environment first, where it loads automatically to localhost:300X or localhost:500X, for example, then your API endpoints may not match for domain.tld/app/app1, so your vhost needs to internally rewrite the url to strip away the base url back to /, then your api endpoints at your backend server can match again._

When it’s on your server at specific port that’s reversed proxy, what’s missing is Heroku etc or AWS etc auto scaling ability. The scaling can be at the process level where multiple clones of the process aka worker processes split the work listening to the same port. Scaling can be at the threading level where it takes advantage of multi threading of the cpu or gpu. At the server level, it can redistribute the traffic among more servers if traffic increases. At locality level, it can spin up servers closer to the user. 
- For Nodejs Express, use Pm2’s process and multithreading scaling. It's recommended you use ecosystem.config.js system of pm2 that allows you to manage multiple Pm2 NodeJS Express apps.
- For Python Flask, use Gunicorn’s process and multithreading scaling

Another problem is if the app crashes or the server crashes or the server restarts. You need the startup persistence of the app if it’s a server event. And it needs to be supervised and restarted if theres an event crashing event.
- For Nodejs, pm2 also does that
- For python flask, use Supervisor which likely will run a [.sh](https://.sh "https://.sh") command to run the gunicorn
- HTML and php is simple. Apache or nginx will autostart

It’s noteworthy to mention that your nodejs express and python flask apps must use unique ports otherwise you try to run one app and it says the port is already taken. In addition:
- For Nodejs express, it’s recommended your env file should have a port number your server.js will start listening to
- For express or flask: Your vhost will match for /app/app1 then internally rewrite the help as /, so your locally developed endpoints still work AND it proxy passes to port number like 127.0.0.1:3001
- Therefore your server instance, whether it’s Nodejs express or python flask, must have the same port number (usually .env file) as the 127.0.0.1:PORT that vhost is reverse proxying into


To make it easy to manage unique port numbers:
- eco/ has the vhost that you `include`  from the website’s vhost
- eco/ has ecosystem.config.js to manage pm2
- eco/ has Makefile so you can run “scripts” that manage pm2 apps
- Symbolic link to supervisor app configs and supervisor central config at `eco/supervisor/`  (using `ln -s ORIGINAL SHORTCUT` )
```
└── eco  
    ├── ecosystem.config.js  
    ├── Makefile  
    ├── supervisor  
    │   ├── conf.d -> /etc/supervisor/conf.d  
    │   └── supervisord.conf -> /etc/supervisor/supervisord.conf  
    └── vhost-reverse-proxies.conf
```