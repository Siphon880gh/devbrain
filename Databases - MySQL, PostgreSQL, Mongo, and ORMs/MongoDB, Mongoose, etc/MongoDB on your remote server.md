
Quick review how to setup your Mongo on your remote host so it can be managed by Mongo Compass or so the database info can be accessed on a website or API on a different host (aka not on the same host as the Mongo)


This tutorial's code is for:
- Mongo server 3.4.24
	- Found out by opening mongo shell `mongo` though other os is `mongosh`
- Python 3.6.15
	- Found out by running `python --version`
- PyMongo 3.4.0
	- Found out with python file contents: `import pymongo` and `print(pymongo.__version__)`
- CentOS 6.1
	- My VPS package

1. **Connect to the MongoDB Shell:**
   Open your terminal and connect to your MongoDB instance using the mongo shell. If it's running locally and doesn't require authentication yet, you can simply use. Some os use `mongosh` as the command

   ```shell
   mongo
   ```

2. **Select the Admin Database:**
   Authentication users are typically created in the admin database. Switch to it with this command:

   ```javascript
   use admin
   ```

3. **Create a New User:**
   Use the `db.createUser()` function to create a new user. Replace `yourUsername`, `yourPassword`, and the roles as appropriate for your needs.

 Avoid using the username `admin`, so use `admin1` if you must

```javascript
db.createUser({
	user: "admin1",
	pwd: "admin1Password",
	roles: [{role: "root", db: "admin"}]
})
```

   Or, if the user already exists and you want to add roles:

```javascript
db.updateUser("admin1", {
	$addToSet: { roles: { role: "root", db: "admin" } }
})
```

The root role does allow the user to create / delete admin users with Mongo. If you want to limit it to just database read/writes, you could use: ` { role: "readWriteAnyDatabase", db: "admin" } `

Why database to admin? That admin is a collection that exists in all Mongo servers and it keeps track of users. By scoped to database admin, you implicitly are scoped to all databases present and in the future because admin is a superscope


The credentials will appear under admin.system.users (`use admin; db.system.users.find())` or running to get all users (`use admin; db.getUsers()`)

4. **Enable Authentication on the MongoDB Server:**
   If you haven't already enabled authentication on the server, you'll need to do so. This often involves editing the MongoDB configuration file (`mongod.conf`) and adding or ensuring these lines are present:

   ```yaml
   security:
     authorization: enabled
   ```


Need help finding mongod.conf file?
- **Linux**: `/etc/mongod.conf`
- **Windows**: In the installation directory, typically something like `C:\Program Files\MongoDB\Server\{version}\bin\mongod.cfg` (note that on Windows, the file might have a `.cfg` extension).
- **macOS**: `/usr/local/etc/mongod.conf` if installed with Homebrew, or a path within the installation directory if installed manually.

5. Restart: After modifying the configuration, restart the MongoDB server for the changes to take effect.
   
   To restart, refer to [[Restart Mongo Server]]

7. **Connect to Mongo Shell with the New User:**
   Once authentication is enabled, make sure you can connect to the database using the mongo shell (on some systems, the command is mongo, some other systems it's mongosh)

```shell
mongo -u admin1 -p admin1Password --authenticationDatabase admin
```

   Replace `yourUsername` and `yourPassword` with the credentials of the user you created.

7. **Connect to Mongo Server in Python with the New User**

python `test.py`:
```
from pymongo import MongoClient, ReturnDocument  
  
from dotenv import load_dotenv  
import os  
  
dotenv_path = os.path.join(os.path.dirname(__file__), '.', '.env')  
load_dotenv(override=True, dotenv_path=dotenv_path)  
  
mongo_user = os.getenv('MONGO_USER')  
mongo_password = os.getenv('MONGO_PASSWORD')  
  
print("I. Retrieved from ./.env:")  
print(mongo_user);  
print(mongo_password);  
  
uri = "mongodb://adminGoDaddy:adminGoDaddy1@localhost:27017/?authSource=admin"  
client = MongoClient(uri)  
  
print("")  
print("II. Mongo databases (proving connection success):")  
print(client.database_names())
```

Your .env file could be:
```
MONGO_USER=admin1
MONGO_PASSWORD=admin1Password
```


8. Enabling external connections if applicable
By default `etc/mongod.conf` settings allow files on the same host as the mongo server to connect (127.0.0.1, aka localhost). This is fine if:
- Your website or API is on the same host
- You modify the database using mongo shell

This is not fine if remote connections to your Mongo server:
- Your website or API is on a different host
- You want to manage your database using Mongo Compass on your computer

Edit your `/etc/mongod.conf`:

   ```yaml
   # mongod.conf
   net:
     bindIp: 0.0.0.0
```

The 0.0.0.0 allows server.py on your own host to work AND outside connections to mongo database including Mongo Compass to work. This is because 0.0.0.0 includes 127.0.0.1, however if you want to restrict to only server files accessing Mongo, you run with `bindIp: 127.0.0.1`, in which case this tutorial's purpose is abandoned.

9. **Restart MongoDB:* (service or systemctl depending on your OS)

   ```bash
   sudo service mongod restart
   ```

10. Check if ufw firewall is enabled with `sudo ufw status`. If it's enabled, you should open the Mongo port by running `sudo ufw allow 27017`

### Important Considerations:
- **Security:** Allowing connections from all IP addresses (0.0.0.0/0) can be very risky, especially if your database is exposed to the internet. It's recommended to use this setting only in controlled environments and to always implement additional security measures like firewalls and VPNs.
- **Firewall Rules:** In addition to configuring MongoDB, ensure your server's firewall rules allow traffic from the desired IP addresses. This might involve configuring `iptables` on Linux, Windows Firewall settings, or network security groups in a cloud environment.
- **Cloud Providers:** If you're using a cloud-hosted MongoDB instance (like MongoDB Atlas), IP whitelisting can typically be configured through the provider's web interface, not through the mongo shell.
- **Testing:** After making changes, always test to ensure that the desired connections are allowed and that unauthorized IPs are indeed blocked.
- You could choose to allow in only IP addresses, multiples like this:
```
   net:
     bindIp: IP1, IP2, IP3
```


9. If enabled remote connections, try connecting via Mongo Compass app:

Connection string (Adjust your username and password)
```
mongodb://admin:admin1Password@domain.com:27017/?authSource=admin
```


If that fails with this:
![](TqcR8mk.png)

It's because your server uses an old Mongo. The oldest compass that was still compatible was version 1.29.5:
https://stackoverflow.com/questions/71167180/cannot-connect-to-my-mongodb-using-compass-tool-after-upgrading-from-1-25-to-1-3



---

## Appendix: Delete / drop an admin user:

You may need this as things mess up creating user accounts etc:

mongo 
use admin 
db.dropUser("exampleUser")

Show all users:
db.getUsers()