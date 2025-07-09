Depending on your use case, you may need to open the port 27017 to the internet by configuring the MongoDB service and by enabling the port through ufw. Connecting to MongoDb Compass app on your local machine requires the port to be opened to the internet. Your Express or PHP app connecting to MongoDB does NOT require port 3306 to be opened to the internet because it's running in the backend on the same remote machine. 

If you decide to open to the internet:

1. Enabling external connections (and Mongo Compass) at the service level
By default `etc/mongod.conf` settings allow files on the same host as the mongo server to connect (127.0.0.1, aka localhost). Let's open Mongo to the internet/world.

Edit your `/etc/mongod.conf`:

```
   net:
	 bindIp: 0.0.0.0
```

Restart mongo service so the settings apply:
```
sudo systemctl restart mongod
```

2. Enabling external connections (and Mongo Compass) at the OS level
If you have firewall (either uwf or iptables), you have to allow in internet 0.0.0.0 into port 27017:

```
sudo ufw allow 27017/tcp
```

---

Make sure to also enable authorization, so hackers can't just remote in without a Mongo username/password. Yes that's the default - Mongo has no authorization as the default.