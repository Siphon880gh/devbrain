
Why: Apply new settings you set at /etc/mongod.conf, or to restart server to see if it fixes some bug

Restarting the MongoDB server can be done in different ways depending on your operating system. Here are the instructions for the most common operating systems:

### For Linux Systems:

1. **Using systemd (if MongoDB was installed using a package manager like apt or yum):**
```bash
sudo systemctl restart mongod
```

2. **Using the service command (older systems or manual installations):**
```bash
sudo service mongod restart
```

### For macOS:

1. **Using Homebrew (if MongoDB was installed using Homebrew):**
```bash
brew services restart mongodb-community
```

2. **Manual Restart:**
   - Stop MongoDB:
```bash
mongod --shutdown
```
   - Start MongoDB:
```bash
mongod --config /usr/local/etc/mongod.conf
```
   Make sure to adjust the path to the MongoDB configuration file (`mongod.conf`) if it's different on your system.

### For Windows:

1. **Using the Command Line (if MongoDB is running as a Windows service):**
   - Open Command Prompt as Administrator.
   - To stop the MongoDB service:
```cmd
net stop MongoDB
```
   - To start the MongoDB service:
```cmd
net start MongoDB
```
   - Alternatively, you can use a single restart command:
```cmd
net stop MongoDB && net start MongoDB
```

2. **Using the Services Manager:**
   - Open the Services manager (you can find it by searching for "Services" in the Start menu).
   - Find `MongoDB` in the list of services.
   - Right-click on `MongoDB` and select `Restart`.

### Important Notes:

- **Backup Data:** Always ensure that your data is backed up before restarting the MongoDB server, especially if you are making configuration changes.
- **Check Logs:** After restarting, check the MongoDB logs to ensure the server started correctly and is running as expected. The logs are typically found in the `/var/log/mongodb` directory on Linux, the `/usr/local/var/log/mongodb` directory on macOS, and in the installation directory on Windows.

By following these instructions, you can successfully restart your MongoDB server and apply any configuration changes you have made.

