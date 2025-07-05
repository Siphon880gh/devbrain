
Run:
```
sudo netstat -tuln | grep 127.0.0.1
```

Output could be like:
```
tcp        0      0 127.0.0.1:45977         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:17000         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:8788          0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:8787          0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:13000         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:18008         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:18009         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:18004         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:18005         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:18006         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:18007         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:18000         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:18001         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:18002         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:18003         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:14000         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:6379          0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:11211         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:15000         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:11000         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:65529         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:16000         0.0.0.0:*               LISTEN     
tcp        0      0 127.0.0.1:12000         0.0.0.0:*               LISTEN     
udp        0      0 127.0.0.1:323           0.0.0.0:*                          
udp        0      0 127.0.0.1:1721          0.0.0.0:*                          
```

Test you can connect to that port from the SSH session. So you're at the server and you're pinging the internal network's port 3100:
```
ping 127.0.0.1 3100
```