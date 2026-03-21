
If your gunicorn is managing a python Flask server and you have an api endpoint that will take 30 seconds or more time to respond to a fetch request, Flask does monitor for the start and completion of an API call. If it exceeds 30 seconds, gunicorn will perform a hard crash and restart:

```
[2024-06-25 00:37:22 -0700] [15030] [CRITICAL] WORKER TIMEOUT (pid:15077)

[2024-06-25 00:37:22 -0700] [15077] [INFO] Worker exiting (pid: 15077)

[2024-06-25 00:37:22 -0700] [15295] [INFO] Booting worker with pid: 15295
```

So if you have a web app that generates a video and it takes more than 30 seconds, it will crash your app on the frontend (failed fetch response)

You want to set the timeout on running gunicorn:
```
gunicorn --timeout 600 your_application:app
```

For a more advanced command, if you're splitting gunicorn into multiple worker processes for process scaling and effective use of the CPU, AND you are working with a https (which is the case nowadays):
```
gunicorn --timeout 600 -w 6 -b 0.0.0.0:5001 --certfile=/path/to/ssl.crt --keyfile=/path/to/ssl.key wsgi:app
```

^ 600 would be 10 mins long.  You have 6 worker processes. 
1. **`-b` or `--bind`**: This option tells Gunicorn which network address and port to bind to.
2. **`0.0.0.0`**: This is a special address that binds the server to all available IPv4 addresses on the local machine. It makes the server accessible from any network interface on the host.
3. **`5001`**: This is the port number on which the server will listen for incoming connections.
4. certfile and keyfile is so it's https compatible (which is required nowadays)