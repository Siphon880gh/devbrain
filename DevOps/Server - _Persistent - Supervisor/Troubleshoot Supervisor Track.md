
Look into the supervisor log

Onion technique to troubleshoot bugs:
1. Run [server.py](https://server.py "https://server.py") (not wsgi.py) directly
2. Then run via sh file from command line like: sh filepath (needed to run pyenv etc). The sh file will activate pyenv environment so it has the consistent python version and pip packages, then will run gunicorn with ssl paths on wsgi (wsgi wraps server.py)
	- Example error could be the filepath not found for your SSL certificates (if your webhost automatically deletes and creates new SSL certs, for example, and it’s been that time)
3. Then run via supervisor which runs that sh file