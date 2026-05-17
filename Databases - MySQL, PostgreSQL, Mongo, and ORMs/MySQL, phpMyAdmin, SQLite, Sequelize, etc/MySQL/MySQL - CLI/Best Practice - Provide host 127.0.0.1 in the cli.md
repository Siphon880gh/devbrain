
TLDR: Just use 127.0.0.1 instead of localhost in your mysql shell login command. Even if localhost works, it might not work on another system if you scale up or share scripts with developer team members.

---

On some servers, this command works:

```bash
mysql -h 127.0.0.1 -u root -P 3306 -A -p
```

But these fail:

```bash
mysql -h localhost -u root -P 3306 -A -p
mysql -u root -P 3306 -A -p
```

You may see an error like this:

```txt
ERROR 1045 (28000): Access denied for user 'root'@'localhost' (using password: YES)
```

That error is the main clue.

It means MySQL is trying to authenticate you as:

```txt
root@localhost
```

not:

```txt
root@127.0.0.1
```

In MySQL, those are **not automatically the same account**.

MySQL accounts are defined by both the username and the host. MySQL stores accounts in the `mysql.user` table, and an account is defined by the username plus the client host the user can connect from. MySQL also treats `localhost`, `127.0.0.1`, and `::1` as different host values. ([MySQL Developer Zone](https://dev.mysql.com/doc/refman/8.4/en/user-names.html "MySQL :: MySQL 8.4 Reference Manual :: 8.2.1 Account User Names and Passwords"))

So these can all be separate accounts:

```txt
root@localhost
root@127.0.0.1
root@::1
```

They can have different passwords, permissions, or authentication plugins.

---

## The Practical Rule

If this works:

```bash
mysql -h 127.0.0.1 -u root -P 3306 -A -p
```

but this fails:

```bash
mysql -h localhost -u root -P 3306 -A -p
```

then the problem is usually that this MySQL account is missing or misconfigured:

```txt
root@localhost
```

It does **not** automatically mean the problem is the Unix socket.

The socket explanation can be true in some MySQL client situations, especially on Unix-like systems, but do not assume that from the error alone. The error `root@localhost` mainly tells you which MySQL account MySQL tried to use.

---

## Why `localhost` and `127.0.0.1` Behave Differently

This command:

```bash
mysql -h 127.0.0.1 -u root -P 3306 -A -p
```

connects to MySQL through the IPv4 loopback address:

```txt
127.0.0.1:3306
```

That usually authenticates as:

```txt
root@127.0.0.1
```

This command:

```bash
mysql -h localhost -u root -P 3306 -A -p
```

authenticates as:

```txt
root@localhost
```

And this command:

```bash
mysql -u root -P 3306 -A -p
```

also usually defaults to:

```txt
localhost
```

The MySQL docs state that the default host name is `localhost`. On some Unix machines, `localhost` could connect to a Unix socket file instead of TCP.

So there are two layers of potential problems: Protocol and MySQL account

---

## Check Which Root Accounts Exist

Log into MySQL using the command that works:

```bash
mysql -h 127.0.0.1 -u root -P 3306 -A -p
```

Then run:

```sql
SELECT User, Host, plugin
FROM mysql.user
WHERE User = 'root';
```

You may see something like:

```txt
+------+-----------+-----------------------+
| User | Host      | plugin                |
+------+-----------+-----------------------+
| root | 127.0.0.1 | mysql_native_password |
| root | ::1       | caching_sha2_password |
+------+-----------+-----------------------+
```

Notice what is missing:

```txt
root@localhost
```

If `root@localhost` does not exist, then this will fail:

```bash
mysql -h localhost -u root -P 3306 -A -p
```

because MySQL has no matching `root@localhost` account.

---

## Fix: Add or Repair `root@localhost`

If `root@localhost` does not exist, create it. Here's a script to create any root-host variation that doesn't exist:
- Note ::1 is important because on some systems, localhost will default to IPv6's ::1

```sql
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

If `root@localhost` already exists but the password or auth plugins dont match, for example:

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

If your Node/MySQL driver has trouble with the default MySQL 8 auth plugin, you can switch the account to `mysql_native_password`:

```sql
ALTER USER 'root'@'localhost'
IDENTIFIED WITH mysql_native_password BY 'YOUR_STRONG_PASSWORD';

GRANT ALL PRIVILEGES ON *.*
TO 'root'@'localhost'
WITH GRANT OPTION;

FLUSH PRIVILEGES;
```

Then check again:

```sql
SELECT User, Host, plugin
FROM mysql.user
WHERE User = 'root';
```

You want to see:

```txt
root | localhost
root | ::1
root | 127.0.0.1
```

Optionally, also support IPv6 loopback:

```sql
CREATE USER IF NOT EXISTS 'root'@'::1'
IDENTIFIED BY 'YOUR_STRONG_PASSWORD';

GRANT ALL PRIVILEGES ON *.*
TO 'root'@'::1'
WITH GRANT OPTION;

FLUSH PRIVILEGES;
```

---

## Test the Fix

Now try:

```bash
mysql -h localhost -u root -P 3306 -A -p
```

After logging in, run:

```sql
SELECT USER(), CURRENT_USER();
```

Example result:

```txt
USER()           CURRENT_USER()
root@localhost   root@localhost
```

`USER()` shows what you attempted to log in as.

`CURRENT_USER()` shows the MySQL account that was actually used for permissions.

---

## Optional: Force TCP When Testing

Some systems treat localhost as a unix socket. 

So test both versions:
```
mysql -h localhost -u root -P 3306 -A -p
```

And:
```bash
mysql --protocol=TCP -h localhost -u root -P 3306 -A -p
```

If both works, then you're good. You don't want to use localhost as a socket file generally. Scripts that your developers share might not include `--protocol=TCP`

The`/etc/hosts` only affects name lookup. MySQL on some systems treat `localhost`as an Unix socket before normal hostname resolution matters. You'd know it's using a socket if you get errors like this:
```
ERROR 2002 (HY000): Can't connect to local MySQL server through socket '/var/run/mysqld/mysqld.sock'
```
However, unfortunately if it does connect successfully then fail authentication at the users table level, you'd get this error which doesn't tell you it's a unix socket connection:
```
ERROR 1045 (28000): Access denied for user 'root'@'localhost' (using password: YES)
```

This `--protocol=TCP` forces TCP instead of unit socket. Connecting to 127.0.0.1 is another way forward if your system's mysql sticks to Unix socket for localhost and that gets in the way.

On the bright side, the Unix socket and `127.0.0.1:3306` are just **two different ways to connect to MySQL**. The database data will still be the same. What will differ is the login identity being either `root@localhost` or `root@127.0.0.1`. The `mysql.user` table have separate rows for these login identities!

---

## Why This Breaks After Migrating Servers

This often happens after a server migration.

Your old server may have had:

```txt
root@localhost
root@127.0.0.1
```

both configured correctly.

Your new server may only have:

```txt
root@127.0.0.1
```

or it may have:

```txt
root@localhost
```

with a different password or authentication plugin.

So your app or CLI command may work with:

```txt
127.0.0.1
```

but fail with:

```txt
localhost
```

because MySQL is checking a different account row.

---

## Sequelize / Node Example

If Sequelize works with this:

```js
host: '127.0.0.1'
```

but fails with this:

```js
host: 'localhost'
```

then MySQL is likely accepting:

```txt
root@127.0.0.1
```

but rejecting:

```txt
root@localhost
```

You have two options:
- OPTION 1 - Follow this entire guide to setup `localhost` to work as expected
- OPTION 2 - Just use 127.0.0.1. But you may have to reconfigure many apps already using localhost:

OPTION 2: Using 127.0.0.1
- You hardcore 127.0.0.1 and/or make it more dynamic to an .env file that uses 127.0.0.1
```js
const sequelize = process.env.JAWSDB_URL
  ? new Sequelize(process.env.JAWSDB_URL)
  : new Sequelize(
      process.env.DB_NAME,
      process.env.DB_USER,
      process.env.DB_PW,
      {
        host: process.env.DB_HOST || '127.0.0.1',
        dialect: 'mysql',
        port: Number(process.env.DB_PORT || 3306)
      }
    );
```

Then in `.env`:

```env
DB_HOST=127.0.0.1
DB_PORT=3306
```

That avoids depending on how `localhost` is configured on each server.
