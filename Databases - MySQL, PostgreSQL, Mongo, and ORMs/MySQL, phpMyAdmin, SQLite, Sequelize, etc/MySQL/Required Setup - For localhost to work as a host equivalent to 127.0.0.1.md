
Goal: Making sure `localhost`  works when it’s used as a value instead of `127.0.0.1`  in nodejs apps that connect to MySQL (often sequelize or mysql2) or other technologies

  
For example, an app’s equivalence of /app/config/connection.js:
```
const Sequelize = require('sequelize');
require('dotenv').config();

// create connection to our db
// JAWSDB_URL only for Heroku. May leave conditional intact even if not using Heroku

const sequelize = process.env.JAWSDB_URL ?
new Sequelize(process.env.JAWSDB_URL) :
new Sequelize(process.env.DB_NAME, process.env.DB_USER, process.env.DB_PW, {
	host: 'localhost',
	dialect: 'mysql',
	port: process.env.DB_PORT || 3306
});
```

You dont want to have to change it to `host: '127.0.0.1'`

For all your other apps that have set host to localhost. It worked fine on the older server. You want it to work fine on the new server as well


Check `/etc/hosts/`  and make sure there is a line for localhost to point to 127.0.0.1


Secondly this is not enough, because MySQL database users are also identified by their host. So if a root user belongs to 127.0.0.1 in the mysql.user table, but there's no root belonging to localhost, it will fail too. This is how a user table should look like:
- Headers have: | Host      | User              | Select\_priv | Insert\_priv | Update\_priv | De…
- An example row can be: | 127.0.0.1 | root              | Y           | Y           | Y …
- And another example row in the same | localhost | root              | Y           | Y           | Y …

You have to GRANT host to your user
- Adjust user (here is root) and password.
- Do not copy into the shell and plan to edit the query inside the shell - it’ll pre-run some of the lines. Edit in a text editor before copying to shell.
- This example is root user so privileges are on all databases and usernames. If you are using a scoped database user for your app that connects to localhost for mysql, change the `ON *.*`  to `ON YOUR_DATABASE.*` in two places here
- Node may resolve `localhost` to IPv6 `::1` first especially as time goes on, so we will take care of that too
```
CREATE USER IF NOT EXISTS 'root'@'127.0.0.1'
IDENTIFIED BY 'YOUR_PASSWORD';

GRANT ALL PRIVILEGES ON *.*
TO 'root'@'127.0.0.1'
WITH GRANT OPTION;

CREATE USER IF NOT EXISTS 'root'@'localhost'
IDENTIFIED BY 'YOUR_PASSWORD';

GRANT ALL PRIVILEGES ON *.*
TO 'root'@'localhost'
WITH GRANT OPTION;

CREATE USER IF NOT EXISTS 'root'@'::1'
IDENTIFIED BY 'YOUR_PASSWORD';

GRANT ALL PRIVILEGES ON *.*
TO 'root'@'::1'
WITH GRANT OPTION;

FLUSH PRIVILEGES;
```

It may still fail - `localhost`  at your nodejs sequelize/mysql2 configuration instead of `127.0.0.1` . Unfortunately may still fail. In that case, another common issue of migrating:

Log back into mysql shell and run:

```
SELECT User, Host, plugin -> FROM mysql.user -> WHERE User = 'root';
```

->
```
+------+-----------+-----------------------+
| User | Host      | plugin                |
+------+-----------+-----------------------+
| root | 127.0.0.1 | mysql_native_password |
| root | ::1       | caching_sha2_password |
| root | localhost | caching_sha2_password |
+------+-----------+-----------------------+
```

You created with the same password from the user side because you see the password plainly since you typed it, however because the plugins differ - your root accounts still differ. Your root at 127.0.0.1 created earlier on in the process such as Cloudpanel installation differed from when we covered localhost and ::1. Let’s force the password to be the same all across by redoing every root’s password NOW:

```
ALTER USER 'root'@'localhost'
IDENTIFIED WITH mysql_native_password BY 'YOUR_PASSWORD';

ALTER USER 'root'@'::1'
IDENTIFIED WITH mysql_native_password BY 'YOUR_PASSWORD';

ALTER USER 'root'@'127.0.0.1'
IDENTIFIED WITH mysql_native_password BY 'YOUR_PASSWORD';

FLUSH PRIVILEGES;
```