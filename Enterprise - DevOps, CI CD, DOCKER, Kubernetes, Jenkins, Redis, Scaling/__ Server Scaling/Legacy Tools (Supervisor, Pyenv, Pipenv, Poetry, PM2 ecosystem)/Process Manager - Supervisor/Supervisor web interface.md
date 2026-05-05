
At your main config file for Supervisor:
```
[inet_http_server]
; port=127.0.0.1:9001
port=0.0.0.0:9001
username=your_username     ; Optional: add for basic authentication
password=your_password     ; Optional: add for basic authentication
```

Then you may need to enable port 9001. Refer to guide [[UFW - Enable specific ports]]

When you visit https://domain.com:9001, you'll get a web browser prompt for username and password

![](ogTI4P4.png)