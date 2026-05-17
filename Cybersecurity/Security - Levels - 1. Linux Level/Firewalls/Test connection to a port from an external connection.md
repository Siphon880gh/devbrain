This emulates connecting to your serve’s public ip at a specific port
```
telnet 97.74.232.20 27017
```

It will say “Connected to..” or it will say “Connected refused” 

Port 40 and 433 can be tested with curl:
```
curl http://97.74.232.20
```

or

```
curl https://97.74.232.20
```