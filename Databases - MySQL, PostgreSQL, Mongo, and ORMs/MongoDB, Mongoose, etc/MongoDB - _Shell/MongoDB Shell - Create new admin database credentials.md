
1. **Connect to the MongoDB Shell:**
   Open your terminal and connect to your MongoDB instance using the mongo shell. If it's running locally and doesn't require authentication yet, you can simply use. Some os use `mongosh` as the command

   ```shell
   mongo
   ```

	If that fails, use:
	```
	mongosh
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

Verify login in the SSH session. Test you can invoke mongo with credentials (mongo or mongosh depending on version):
```
mongosh -u 'USERNAME' -p 'PASSWORD' --authenticationDatabase 'admin'
```

Verify login the other way too with..  a URL because that will be roughly the URL you will use in your backend for NodeJS, etc to authenticate (your code would have the domain address instead of the numeric localhost IP)... if using characters like #, they must be in their url encoded form like `%23` for `#`:
```
mongosh 'mongodb://USERNAME:PASSWORD@127.0.0.1:27017/?authSource=admin'
```
