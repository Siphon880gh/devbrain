
Look into the supervisor log

Onion technique to troubleshoot bugs:
1. Run [server.py](https://server.py "https://server.py") (not wsgi.py) directly
   
2. Run gunicorn directly:
Make sure in the same folder with the wsgi.py and server.py. Here we run without worker processes
```
gunicorn -b 0.0.0.0:5001 --certfile=....crt --keyfile=....key wsgi:ap
```

If running with worker processes you add -w 6 right after gunicorn and before -b

- Timeout?
  If gunicorn crashes because of "TIME OUT" realize that gunicorn monitors API calls when they started and when they ended, so if you have API calls that generate videos taking more than 30 seconds, you need to manually override the "TIMEOUT" with the option `--timeout 600` (That's 600 seconds for 10 minutes)


3. Then run via sh file from command line like: sh filepath (needed to run pyenv etc). The sh file will activate pyenv environment so it has the consistent python version and pip packages, then will run gunicorn with ssl paths on wsgi (wsgi wraps server.py)
	- Example error could be the filepath not found for your SSL certificates (if your webhost automatically deletes and creates new SSL certs, for example, and it’s been that time)
	
4. Then run via supervisor which runs that sh file