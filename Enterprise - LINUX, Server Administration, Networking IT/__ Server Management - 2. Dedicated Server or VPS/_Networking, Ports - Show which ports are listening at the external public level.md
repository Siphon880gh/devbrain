
Indirectly, you can grep for 0.0.0.0 from netstat, which could include all available interfaces, both internal (127.0.0.1) and external (internet), but usually configured to mean external
```
sudo netstat -tuln | grep 0.0.0.0
```

However you also have to consider firewalls that may block the connection:
```
ufw status
```

```
iptables --list
```

