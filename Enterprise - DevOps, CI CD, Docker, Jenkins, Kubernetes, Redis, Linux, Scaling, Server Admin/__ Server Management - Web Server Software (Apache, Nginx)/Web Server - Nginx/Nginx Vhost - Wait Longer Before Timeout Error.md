<
User generates a video on my website after uploading photos. A fetch request is made to an api point where the video starts generating. When the video finishes generating which could take minutes, the api endpoint delivers a response to the frontend. I want it to wait longer before timeout error. 

Inside a server block:
```
    location /api/ {
        proxy_read_timeout 300s;   # Adjust as needed
        proxy_connect_timeout 300s; # Adjust as needed
        proxy_send_timeout 300s;   # Adjust as needed
    }
```



If you're proxy passing to a backend to hide non-web ports and increase security, it could ultimately be:
```
location /api {
	proxy_pass https://127.0.0.1:5001;
	proxy_read_timeout 300s;   # Adjust as needed
	proxy_connect_timeout 300s; # Adjust as needed
	proxy_send_timeout 300s;   # Adjust as needed
	proxy_set_header Host $host;
	proxy_set_header X-Real-IP $remote_addr;
	proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
	proxy_set_header X-Forwarded-Proto $scheme;
}
```

---

Is this waiting on Gunicorn (Flask and Python) or PHP?

Gunicorn (Flask and Python):
```
gunicorn --timeout 300 myapp:app...
```

PHP:
```
ini_set('max_execution_time', 300);  // Adjust as needed
ini_set('default_socket_timeout', 300);  // Adjust as needed
```