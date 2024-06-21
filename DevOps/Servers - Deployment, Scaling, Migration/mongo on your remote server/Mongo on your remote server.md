

Status: Untested. Mongo was setup effortlessly on my remote server

Here I will do a quick review how to connect to your Mongo (if installed on your server), then will review how to grant your mongo user access to specific or all collections, then finally enabling your mongo to work with other IP addresses (if applicable)

<< Code connects to Mongo
How in mongo shell create authentication users for connecting to mongo database server
\>>
To create authentication users for connecting to a MongoDB database server through the mongo shell, you'll need to follow these steps. These instructions assume you have the necessary permissions to create users and assign roles:

1. **Connect to the MongoDB Shell:**
   Open your terminal and connect to your MongoDB instance using the mongo shell. If it's running locally and doesn't require authentication yet, you can simply use:

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

   ```javascript
   db.createUser({
     user: "yourUsername",
     pwd: "yourPassword",
     roles: [
       { role: "readWrite", db: "yourDatabase" },
       { role: "dbAdmin", db: "yourDatabase" }
       // Add additional roles as necessary
     ]
   })
   ```

   - `yourUsername` and `yourPassword` are the credentials for the new user.
   - `roles` are the permissions you're assigning to this user. `readWrite` and `dbAdmin` on `yourDatabase` are just examples. Customize the roles according to the level of access you want to provide.

4. **Enable Authentication on the MongoDB Server:**
   If you haven't already enabled authentication on the server, you'll need to do so. This often involves editing the MongoDB configuration file (`mongod.conf`) and adding or ensuring these lines are present:

   ```yaml
   security:
     authorization: enabled
   ```

   After modifying the configuration, restart the MongoDB server for the changes to take effect.

5. **Connect to MongoDB with the New User:**
   Once authentication is enabled, you'll need to connect to the database using the credentials you've created. Here's how you might connect from the shell:

   ```shell
   mongo -u yourUsername -p yourPassword --authenticationDatabase admin
   ```

   Replace `yourUsername` and `yourPassword` with the credentials of the user you created.

**Important Notes:**

- Always ensure that you're operating in a secure environment, especially when handling usernames and passwords.
- The exact roles and permissions you should assign depend on the user's needs. Avoid giving more privileges than necessary.
- The steps to enable authentication might vary slightly depending on your MongoDB version and environment.
- Always backup your database before making significant changes like enabling authentication.

Tip: For security, you may want to use .env file with dot env extension, so you dont hard code your credentials



\<< Enable mongo creds for collections
Awesome. Now how to enable the role to all and future databases

\>>
To enable a role for a user across all current and future databases in MongoDB, you can assign cluster-wide roles or use wildcard privileges. Here's how you can do it:

1. **Connect to the MongoDB Shell:**
   Open your terminal and connect to your MongoDB instance using the mongo shell.

   ```shell
   mongo -u adminUser -p adminPassword --authenticationDatabase admin
   ```
   Replace `adminUser` and `adminPassword` with the credentials of a user that has privileges to create and modify users and roles.

2. **Select the Admin Database:**
   Authentication users and roles are typically managed in the admin database.

   ```javascript
   use admin
   ```

3. **Create or Update a User with Cluster-Wide Roles:**
   To assign roles that apply to all current and future databases, use the `db.createUser()` or `db.updateUser()` function with the appropriate roles. Here's how you might assign the `readWriteAnyDatabase` role, which allows reading and writing to any database (excluding `local` and `config`):

   ```javascript
   db.createUser({
     user: "yourUsername",
     pwd: "yourPassword",
     roles: [
       { role: "readWriteAnyDatabase", db: "admin" },
       "readAnyDatabase" // This is a shortcut for { role: "readAnyDatabase", db: "admin" }
       // Add additional roles or cluster-wide roles as necessary
     ]
   })
   ```

   Or, if the user already exists and you want to add roles:

   ```javascript
   db.updateUser("yourUsername", {
     $addToSet: { roles: { role: "readWriteAnyDatabase", db: "admin" } }
   })
   ```

4. **Consider Future Databases:**
   - The `readWriteAnyDatabase` role applies to all current and future non-system databases. This means as new databases are created, the user will automatically have read and write access.
   - For other types of access or more granular control, consider creating custom roles with wildcard privileges or managing roles carefully as new databases are added.

5. **Restart MongoDB with Authentication Enabled (if not already done):**
   Ensure that the MongoDB server is running with authentication enabled. This usually involves setting the `security.authorization` option to `enabled` in the MongoDB configuration file and restarting the service.

6. **Connect to MongoDB with the New User:**
   Once the user is created or updated with the appropriate roles, connect to the database using the new credentials to test the access:

   ```shell
   mongo -u yourUsername -p yourPassword --authenticationDatabase admin
   ```

**Important Security Notes:**

- The `readWriteAnyDatabase` role and similar cluster-wide roles provide extensive access. Use them cautiously and only assign them to trusted users.
- Regularly review user access and privileges, especially in production environments, to ensure they follow the principle of least privilege.
- Keep your MongoDB version updated to benefit from the latest security features and improvements.
- Always backup your database before making significant changes like modifying user roles and privileges.





\<<Enabling IP addresses for Mongo
Awesome. Separate question. Now how do I whitelist specific IP or allow all IP using mongo shell? Two separate scenarios.


\>>
In MongoDB, IP whitelisting is generally handled at the network or server level rather than directly through the MongoDB shell. However, you can configure MongoDB to only accept connections from certain IP addresses or all IP addresses by modifying its configuration file (`mongod.conf`) or by specifying command-line options when starting the MongoDB server. Here are the steps for both scenarios:

### 1. Whitelist Specific IP Addresses:
To allow connections only from specific IP addresses, you need to bind MongoDB to those IP addresses.

1. **Edit the MongoDB Configuration File (`mongod.conf`):**
   Locate and edit the `mongod.conf` file, which is typically found in `/etc/mongod.conf` on Linux systems.

   ```yaml
   # mongod.conf
   net:
     bindIp: 127.0.0.1,<Your-Whitelisted-IP-Address>
   ```

   Replace `<Your-Whitelisted-IP-Address>` with the actual IP address you want to whitelist. You can list multiple IP addresses separated by commas.

2. **Restart MongoDB:**
   After updating the configuration, restart the MongoDB service to apply the changes.

   ```bash
   sudo service mongod restart
   ```

### 2. Allow All IP Addresses (0.0.0.0/0):
To allow connections from any IP address, you can bind MongoDB to `0.0.0.0`, which represents all IPv4 addresses.

1. **Edit the MongoDB Configuration File (`mongod.conf`):**

   ```yaml
   # mongod.conf
   net:
     bindIp: 0.0.0.0
   ```

2. **Restart MongoDB:**

   ```bash
   sudo service mongod restart
   ```

### Important Considerations:
- **Security:** Allowing connections from all IP addresses (0.0.0.0/0) can be very risky, especially if your database is exposed to the internet. It's recommended to use this setting only in controlled environments and to always implement additional security measures like firewalls and VPNs.
- **Firewall Rules:** In addition to configuring MongoDB, ensure your server's firewall rules allow traffic from the desired IP addresses. This might involve configuring `iptables` on Linux, Windows Firewall settings, or network security groups in a cloud environment.
- **Cloud Providers:** If you're using a cloud-hosted MongoDB instance (like MongoDB Atlas), IP whitelisting can typically be configured through the provider's web interface, not through the mongo shell.
- **Testing:** After making changes, always test to ensure that the desired connections are allowed and that unauthorized IPs are indeed blocked.

Always back up your database and configuration files before making significant changes, and review MongoDB's security checklist to ensure you're following best practices.