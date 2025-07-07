
**Applies to:** Hostinger VPS KVM2 • Ubuntu 24.04.2 LTS • CloudPanel

---

## 🧩 Overview

While Hostinger’s ordering process and setup wizard are mostly straightforward, **manual terminal work is still required** afterward — especially for things like FTP. The wizard can give the false impression that everything is fully configured.

---

## ⚠️ Important Warning About the Setup Wizard

**Do NOT add your SSH key during the Hostinger wizard.**  
Doing so may cause issues that make FTP setup more difficult.  
👉 **Wait to add your SSH key until after** you have confirmed FTP is working manually via terminal.

---

## ✅ Done with the Wizard?


Copy your credentials/passwords to a safe place.

Now perform these two checks:

1. **SSH Login** using root password  
    (You can add passwordless SSH key authentication later.)
    
2. **SFTP/FTP Access** using FileZilla
    

---

## 🔒 Tip Before Terminal Access

When accessing your VPS via root terminal, it's strongly recommended to go **behind a VPN**.

Why?  
Hostinger uses Cloudflare by default, which will **ban your IP for 1 hour** after repeated failed login attempts — and there's **no way to unblock this from the Hostinger interface.**

---

## 🧪 Test: SSH Login

Use either:

- `"root"` (we’ll disable this later for better security), or
    
- The **site user** created via CloudPanel
    

---

## 🧪 Test: SFTP/FTP Login

You **do not** need to create a new SFTP/FTP user in CloudPanel.  
You can use:
- `"root"`
- Or the **existing site user**

👉 If login fails (which is likely on fresh installs), you'll need to manually fix FTP/SFTP.  
**Refer to the FTP setup instructions** ([[_ Hostinger VPS KVM2 Debian 22 - 2. FTP Setup]]), complete the steps, and then return here once FileZilla works.

---

## ✅ Once SSH and SFTP/FTP Logins Are Working

Now you can safely **add your SSH public key** from your computer.

![[Pasted image 20250706131250.png]]

- This will enable **SSH passwordless login**
- Makes it easier to automate terminal access with an alias from your local machine


---

## ✅ Verify/Setup Additional Dependencies

### MySQL Verification

MySQL automatically comes with your installation. You make sure you have copied over the credentials. This account by default accesses all future website's MySQL. To test MySQL:

Verify at SSH shell: `mysql -h 127.0.0.1 -P 3306 -u DB_NAME -p`

Enter your password interactively. If you see the mysql shell, then you have verified you can connect to MySQL, at least locally in the SSH.

Depending on your use case, you may need to open the port 3306 to the internet using ufw. Connecting to a MySQL database viewing software on your local machine requires the port to be opened to the internet. Your Express or PHP app connecting to MySQL does NOT require port 3306 to be opened to the internet because it's running in the backend on the same remote machine. The command to open the port is: `sudo ufw allow 3306/tcp`

### MongoDB Installation

MongoDB does not come with your installation.

There are a lot of steps—follow the full MongoDB installations (not going to repeat it in this tutorial)
- Ubuntu 22/24: https://www.mongodb.com/docs/manual/tutorial/install-mongodb-on-ubuntu/
- Debian 12: https://www.mongodb.com/docs/manual/tutorial/install-mongodb-on-debian/

Verification instructions on making sure MongoDB is installed, is on the instructions page as well.

**Caveat** - Make sure it's Enabled for rebooting. This status of `sudo systemctl status mongodb` has not been enabled for reboot because notice the word "disabled" at the Loaded line:

```
# sudo systemctl status mongod
> ● mongod.service - MongoDB Database Server
Loaded: loaded (/usr/lib/systemd/system/mongod.service; disabled; preset: >
Active: active (running) since Mon 2025-07-07 00:01:49 UTC; 3s ago
```

- Enable for reboot startup with: `sudo systemctl enable mongod`

You need a new database credentials to login to Mongo remotely or locally from your Express/PHP app. Refer to [[MongoDB Shell - Create new admin database credentials]] including its verification and creating new credentials instructions.

Depending on your use case, you may need to open the port 27017 to the internet by configuring the MongoDB service and by enabling the port through ufw. Connecting to MongoDb Compass app on your local machine requires the port to be opened to the internet. Your Express or PHP app connecting to MongoDB does NOT require port 3306 to be opened to the internet because it's running in the backend on the same remote machine. If you decide to open the port to the internet, follow the guide at: [[MongoDB on your remote server - Open to internet]]

