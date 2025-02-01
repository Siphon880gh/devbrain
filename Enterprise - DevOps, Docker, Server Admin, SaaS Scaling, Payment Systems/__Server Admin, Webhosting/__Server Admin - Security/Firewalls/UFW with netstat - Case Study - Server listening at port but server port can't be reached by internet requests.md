Titled: Server listening at port but server port can't be reached by internet requests

Lets say wanting to manage the remote Mongo database from your own local computer, you open MongoDB Compass and the authentication details and connection string were setup correctly. But it keeps timing out. However, your website/app works because you can login and signup on your website/app which uses the MongoDB. SSHing into the remote server and checking the port reveals your server is listening for incoming internet requests at that port.

Ok so you SSH into the server via your terminal and ran netstat to see if your server is listening at port 27017 (MongoDB) for requests and to send information to:
```
sudo netstat -tuln | grep :27017
```

Result is this which is good:
```
tcp        0      0 0.0.0.0:27017           0.0.0.0:*               LISTEN
```

And your /etc/mongod.conf has allowed binding to the internet:
```
# network interfaces
net:
  port: 27017
  bindIp: 0.0.0.0
```

Then the problem may be your UFW:
```
sudo ufw status
```

If you don't see 27017 on there, then enable the port for firewall:
```
sudo ufw allow 27017/tcp
```

Implications: Just because netstat says your server is listening to the port 27107, it's possible at the network level that your firewall is blocking all requests from reaching port 27107!