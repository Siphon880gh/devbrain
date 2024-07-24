
At your main config file for Supervisor:
```
[inet_http_server]
; port=127.0.0.1:9001
port=0.0.0.0:9001
username=wff                        ; Optional: add for basic authentication
password=wff_intermediate_fails     ; Optional: add for basic authentication
```

Then you may need to enable port 9001. Refer to guide [[Enabling ports at nginx]]