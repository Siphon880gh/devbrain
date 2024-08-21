
You're proxy passing to a backend to hide non-web ports and increase security. They dont need to know what language you're using (python, or node, etc)

Eg. Frontend api connections are to /api/ENDPOINT
Backend is running a flask server at domain.com:5001 and can receive endpoints /api/ENDPOINT

To the curious user, they will never see port 5001 in the javascript or Network tab.

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
