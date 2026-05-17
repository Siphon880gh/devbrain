Check ports are opened:
```
sudo lsof -i TCP:21 -i TCP:22  
```

If you’re using uwf as firewall:
```
sudo ufw status
```

---

Vocab: lsof?
==LiSt Open Files== command is a powerful Unix/Linux utility used to identify which processes are accessing specific files, directories, network sockets, or pipes