## General troubleshooting

Stdout
```
pm2 log APP_NAME_HERE --lines 100
```

Stderror
```
pm2 log APP_NAME_HERE --err --lines 100
```

Exit codes and error out could show up at pm2 logs
```
grep -iE "APP_NAME_HERE|exit|restart|errored|SIG|code" /root/.pm2/pm2.log | tail -n 100
```

---

## Identify what apps if any are crashing etc

You may want to use these commands to check if apps are crashing or spiking CPU again:

```
pm2 list
```
^ One auditing method is press up then enter repeatedly, and look at whether the uptime is increasing, restarting, or staying at 0s. Do this for at least one minute. Some apps crash like 30 seconds or 45 seconds in instead of right away.

Check for high CPU spikes (for example, 20% is probably not expected for a node app):  
```
htop
```

---

## Is it a migration into a new server?

If a recent migration to a new server, these are the most likely errors/causes.

If you need a refresh on where the directory is, look into `ecosystem.config.js`

**.env and database credentials (may differ on new server)**
Check your .env files if they exist at the app, and check if it's database credentials are correct.

**Node_modules at root and nested folders if full stack PLUS Seed**

Node app? Make sure to remove node_modules and reinstall (`rm -rf node_modules && npm install --legacy-peer-deps`). Then again at any nested part of the stack like `client/`, `server/`, or `frontend/`, or `backend/` which tends to have their own npm packages

Might as well seed as well! That is - `npm run seed` or `npm run seeds` - if seeds exist in the app. It might complain a database doesn't exist, which means the seed isn't programmed to create the database - you have to create it manually using MySQL shell.

Then test if the app works. Usually you run `node server.js` or `npm start`

Common problems failing npm starrt:
- concurrently not found when running npm run start. Probably the app assumes you have it installed globally (bad devops practice)
	- Run this: `npm install -g concurrently` 
- if-env not found? Same bad devops practice of assuming you have it installed globally:
	- Run this `npm install -g if-env` 
-  Error: Cannot find module '../scripts/start'  
	- That’s actually a misleading error. Remove node_modules/ then npm install again

Pip app? Make sure to install the pip3 packages. And then test the python app runs.

---

**Example problem:**
You're seeding a mongo database and it times out or takes too long and nothing happens.

See if you're using MONGO URL. Is it going through a `DOMAIN.com:27017`? It may be going to Cloudflare or reaching other blocks along the way. Switch to `127.0.0.1:27017`. If this fixes the time out / pause, then you may want to substitute globally:
- The original string is in two places, and the substituting string is in one place:
```
grep -rlZ --exclude-dir=.git --exclude-dir=node_modules --binary-files=without-match -- 'domain.com:27017' . \
  | xargs -0 -r perl -pi -e 's/\Qdomain.com:27017\E/127.0.0.1:27017/g'
```

---

**Example Problem:**
Some potential errors may be:
"Unknown database or "database not found"

Look for a seed file. You may simply have to run the seed, eg. `npm run seed`. **Some seed files may not even create the database**, so you have to manually go into mysql shell to create the database.

---

**Leverage AI - Other node or npm or pip errors**
- See if chatgpt can figure it out. Say "I have problems running this node app. This is the error.."
- Last resort is on a local copy, ask Cursor "I have problems running this node app when it's online. This is the error on the server.."

* * *

## Migrations (Continue if this is a migration into a new server)
If not a migration: Skip to the section "General Troubleshooting". Use the floating table of contents.

Exit codes and error out could show up at pm2 logs
```
grep -iE "APP_NAME_HERE|exit|restart|errored|SIG|code" /root/.pm2/pm2.log | tail -n 100
```

Example:
```/home/wengindustries/htdocs/wengindustries.com/app/APP_NAME_HERE/server/node_modules/mongoose/lib/connection.js:847
    at Connection.openUri (/home/wengindustries/htdocs/wengindustries.com/app/APP_NAME_HERE/server/node_modules/mongoose/lib/connection.js:847:32)
    at /home/wengindustries/htdocs/wengindustries.com/app/APP_NAME_HERE/server/node_modules/mongoose/lib/index.js:351:10
    at /home/wengindustries/htdocs/wengindustries.com/app/APP_NAME_HERE/server/node_modules/mongoose/lib/helpers/promiseOrCallback.js:32:5
    at promiseOrCallback (/home/wengindustries/htdocs/wengindustries.com/app/APP_NAME_HERE/server/node_modules/mongoose/lib/helpers/promiseOrCallback.js:31:10)
    at Mongoose._promiseOrCallback (/home/wengindustries/htdocs/wengindustries.com/app/APP_NAME_HERE/server/node_modules/mongoose/lib/index.js:1149:10)
    at Mongoose.connect (/home/wengindustries/htdocs/wengindustries.com/app/APP_NAME_HERE/server/node_modules/mongoose/lib/index.js:350:20)
    at Object.<anonymous> (/home/wengindustries/htdocs/wengindustries.com/app/APP_NAME_HERE/server/config/connection.js:5:10)
            at connectionFailureError (/home/wengindustries/htdocs/wengindustries.com/app/APP_NAME_HERE/server/node_modules/mongodb/lib/core/connection/connect.js:362:14)
            at Socket.<anonymous> (/home/wengindustries/htdocs/wengindustries.com/app/APP_NAME_HERE/server/node_modules/mongodb/lib/core/connection/connect.js:330:16)
2026-05-16T07:58:51: PM2 log: App name:APP_NAME_HERE:3001 id:1 disconnected
2026-05-16T07:58:51: PM2 log: App [APP_NAME_HERE:3001:1] exited with code [1] via signal [SIGINT]
2026-05-16T07:58:51: PM2 log: App [APP_NAME_HERE:3001:1] starting in -cluster mode-
2026-05-16T07:58:51: PM2 log: App [APP_NAME_HERE:3001:1] online
```

That is a NodeJS' mongodb connection issue. Go investigate

---
## Migrations - More (Continue if this is a migration into a new server)

Other example logs from `grep -iE "APP_NAME_HERE|exit|restart|errored|SIG|code" /root/.pm2/pm2.log | tail -n 100`:

```
root@5:/home/wengindustries/htdocs/wengindustries.com/eco# grep -iE "book-search:3001|exit|restart|errored|SIG|code" /root/.pm2/pm2.log | tail -n 100

2026-05-16T08:32:38: PM2 log: App [APP_1:3] exited with code [1] via signal [SIGINT]

2026-05-16T08:32:38: PM2 log: App [APP_2:4] exited with code [1] via signal [SIGINT]

code: 'ER_ACCESS_DENIED_ERROR',

code: 'ER_ACCESS_DENIED_ERROR',

code: 'ER_ACCESS_DENIED_ERROR',

code: 'ER_ACCESS_DENIED_ERROR',

2026-05-16T08:32:39: PM2 log: App [APP_1:3] exited with code [1] via signal [SIGINT]

2026-05-16T08:32:39: PM2 log: App [APP_2:4] exited with code [1] via signal [SIGINT]

code: 'ER_ACCESS_DENIED_ERROR',

code: 'ER_ACCESS_DENIED_ERROR',

code: 'ER_ACCESS_DENIED_ERROR',

code: 'ER_ACCESS_DENIED_ERROR',

2026-05-16T08:32:40: PM2 log: App [APP_1:3] exited with code [1] via signal [SIGINT]

2026-05-16T08:32:40: PM2 log: App [APP_2:4] exited with code [1] via signal [SIGINT]

code: 'ER_ACCESS_DENIED_ERROR',

code: 'ER_ACCESS_DENIED_ERROR',

  

```

That is a NodeJs' MySQL conneciton issue. Go investigate

"ER_ACCESS_DENIED_ERROR" is **MySQL/MariaDB**'s though we certainly wish they named the error in a way that we know it's from MySQL. If Node app, it could be Sequelize or mysql2 modules.

if login credentials work. It could be your NEW SERVER's MySQL root user doesn’t support localhost so it has to be 127.0.0.1. Try connecting to 127.0.0.1 in the Sequelize/mysql2 configuration
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

Try changing `host: 'localhost',`  to `host: '127.0.0.1',` 

The problem is you may not want to change localhost for every single app then have to push updates to git!

Firstly, check `/etc/hosts/` because we want `localhost` to point to `127.0.0.1` 

Secondly this is not enough, because MySQL database users are also identified by their host. So if a root user belongs to 127.0.0.1 in the mysql.user table, but there's no root belonging to localhost, it will fail too. This is how a user table should look like:

Headers have: | Host      | User              | Select_priv | Insert_priv | Update_priv | De…

An example row can be: | 127.0.0.1 | root              | Y           | Y           | Y …

And another example row in the same | localhost | root              | Y           | Y           | Y …

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


Try localhost now at your nodejs sequelize/mysql2 configuration. Unfortunately may still fail. In that case, another common issue of migrating:

Log back into mysql shell and run:
```
SELECT User, Host, plugin -> FROM mysql.user -> WHERE User = 'root';
```

\->

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

---

If you think it's still a pm2 issue:

```
pm2 describe "APP_NAME_HERE"
```

- Then send that to ChatGPT asking if your pm2 app is setup correctly.
- It’ll check for things like if Cluster mode, it is better to run the js directly like `node server.js`  and that Cluster mode is not recommended for npm scripts like `npm start` or `npm run start`
