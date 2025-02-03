
You're proxy passing to a backend to hide non-web ports and increase security or because you don't want to open the ports to make the api available. They dont need to know what language you're using (python, or node, etc)

Eg. Frontend api connections are to /api/ENDPOINT
Backend is running a flask server at domain.com:5001 and can receive endpoints /api/ENDPOINT

To the curious user, they will never see port 5001 in the javascript or Network tab.

Add this to the 80/443 server block:

```
  location /api {
    proxy_pass http://127.0.0.1:5001;
    proxy_read_timeout 300s;   # Adjust as needed
    proxy_connect_timeout 300s; # Adjust as needed
    proxy_send_timeout 300s;   # Adjust as needed
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto $scheme;

    # Enable CORS
    add_header 'Access-Control-Allow-Origin' '*' always;
    add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS' always;
    add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization' always;
    
    # Handle OPTIONS (preflight) requests
    if ($request_method = OPTIONS) {
      add_header 'Access-Control-Allow-Origin' '*';
      add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';
      add_header 'Access-Control-Allow-Headers' 'Origin, Content-Type, Accept, Authorization';
      add_header 'Access-Control-Max-Age' 1728000;
      return 204;
    }
  }
```

**Make sure** your url to 127.0.0.1 are to **http** or else you'll get a very general 502 Bad Gateway error when visiting

Since you are using nginx vhost to enable CORS, you're not going to want to enable CORS inside Flask or Express as well. Otherwise, you get this error message:
```
localhost/:1 Access to fetch at 'https://wengindustries.com/mixo-api/' from origin 'http://localhost:8081' has been blocked by CORS policy: The 'Access-Control-Allow-Origin' header contains multiple values '*, *', but only one is allowed. Have the server send the header with a valid value, or, if an opaque response serves your needs, set the request's mode to 'no-cors' to fetch the resource with CORS disabled.
```

---

Need to open port? No

You don't need to explicitly allow connections to port 3000 in UFW if the reverse proxy (such as Nginx or Apache) is handling requests locally. The reverse proxy will forward requests internally to, Eg. `127.0.0.1:3000`, and since this is a local connection, UFW does not block it by default.

If you're using `iptables`, the same principle applies: local connections from `127.0.0.1` to Eg. `127.0.0.1:3000` are allowed by default and do not need any additional rules. The reverse proxy (like Nginx or Apache) forwards traffic internally to port `3000` without involving the firewall for those local connections.