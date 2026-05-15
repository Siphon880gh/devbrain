Mysql auth command - Providing host 127.0.0.1 works on all systems but providing localhost or not providing host fails on some systems

So to make things easier, always shell into mysql using this formula:
```
mysql -h 127.0.0.1 -u root -P 3306 -A -p
```

These commands fail with `Access denied` on some systems:
```
mysql -h localhost -u root -P 3306 -A -p
mysql -u root -P 3306 -A -p
```


When you run it without `-h`:
```
mysql -u root -P 3306 -A -p
```

You may see this error:
```
ERROR 1045 (28000): Access denied for user 'root'@'localhost' (using password: YES)
```

That error is an important clue.

It shows that MySQL is trying to log you in as:
```
root@localhost
```

not:

```
root@127.0.0.1
```

So yes, when you do not provide `-h`, the MySQL client defaults to `localhost`.

The important part is that **`localhost` and `127.0.0.1` are not always treated the same by MySQL**.

---

## `127.0.0.1` Uses TCP

This command:
```
mysql -h 127.0.0.1 -u root -P 3306 -A -p
```

connects to MySQL using **TCP**.

TCP is the normal network connection method. It is what computers use to connect to services through an IP address and port.

In this case:
```
-h 127.0.0.1
```

means:
```
Connect to this same machine using the loopback IP address.
```

And:
```
-P 3306
```

means:
```
Connect to port 3306.
```

Port `3306` is the default MySQL server port.

So this command means:
```
Connect to MySQL on this same machine through the network interface at 127.0.0.1:3306.
```

That usually authenticates as something like:
```
root@127.0.0.1
```

---

## `localhost` Usually Uses a Unix Socket

This command:
```
mysql -h localhost -u root -P 3306 -A -p
```

looks like it should connect to port `3306`, but with MySQL on Linux, `localhost` is special.

When MySQL sees:
```
-h localhost
```

it usually does **not** use TCP.

Instead, it usually connects through a **Unix socket file**.

A socket is a local communication file that lets programs on the same server talk to each other without going through the normal network/IP/port path.

The socket file is often located somewhere like:
```
/run/mysqld/mysqld.sock
```

or:

```
/var/run/mysqld/mysqld.sock
```

That means:

Use this local socket file to talk directly to MySQL.

**There is no IP address and no port.**

So instead of connecting through:

```
127.0.0.1:3306
```

MySQL may connect through:

```
/run/mysqld/mysqld.sock
```

That is why this option:

```
-P 3306
```

does not help when MySQL is using a Unix socket.

Port `3306` only matters for TCP connections. A Unix socket does not use TCP ports. It uses a local file path instead.

So even though you typed:

```
-P 3306
```

the connection may still be going through the socket, and the port is ignored or irrelevant.

The socket equivalent of choosing a port is choosing the socket file:

```
mysql -u root -p -S /run/mysqld/mysqld.sock
```

or:

```
mysql -u root -p --socket=/run/mysqld/mysqld.sock
```

---

## Why Does MySQL Use a Socket for `localhost`?

The socket is mainly for **local server-to-server communication**.

If your PHP app, WordPress site, Laravel app, or command-line MySQL client is running on the same server as MySQL, it does not necessarily need to connect through the network stack.

Instead of doing this:
```
App → TCP/IP → 127.0.0.1 → Port 3306 → MySQL
```

it can do this:
```
App → Unix socket file → MySQL
```

This is common on Linux because Unix sockets are usually:
```
faster
local-only
not exposed over the network
simple for same-machine services
```

So MySQL treats `localhost` as a special shortcut for:

Use the local socket file if available.

That is why `localhost` may behave differently from `127.0.0.1`.

Even though both refer to the same machine in normal networking language, MySQL uses them differently.

---

## Why One Password Works and the Other Fails

MySQL treats these as different login identities:
```
root@127.0.0.1
root@localhost
```

They can have different passwords, permissions, or authentication methods.

So your password may work for:
```
root@127.0.0.1
```

but fail for:
```
root@localhost
```

That is why this works:

```
mysql -h 127.0.0.1 -u root -P 3306 -A -p
```

but this fails:

```
mysql -h localhost -u root -P 3306 -A -p
```

And this also fails:

```
mysql -u root -P 3306 -A -p
```

because without `-h`, MySQL defaults to `localhost`.

The error confirms it:

```
ERROR 1045 (28000): Access denied for user 'root'@'localhost' (using password: YES)
```

That means MySQL is not rejecting:

```
root@127.0.0.1
```

It is rejecting:

```
root@localhost
```

---

## How to Force TCP

To force MySQL to use TCP, run:

```
mysql --protocol=TCP -h localhost -u root -P 3306 -A -p
```

Or more directly:

```
mysql --protocol=TCP -h 127.0.0.1 -u root -P 3306 -A -p
```

This tells MySQL:
```
Do not use the socket. Use a TCP network connection.
```

The most reliable version is:
```
mysql -h 127.0.0.1 -u root -P 3306 -A -p
```

because `127.0.0.1` naturally makes MySQL connect over TCP.

---

## How to Check Which Account You Logged In As

After logging in with the working command, run:
```
SELECT USER(), CURRENT_USER();
```

`USER()` shows what you attempted to log in as.
`CURRENT_USER()` shows the actual MySQL account that was used for permissions.

Then check the root accounts:
```
SELECT User, Host, plugin
FROM mysql.user
WHERE User = 'root';
```

You may see something like:

```
root    localhost
root    127.0.0.1
```

Those are separate MySQL accounts.

---

## Simple Summary

This works:
```
mysql -h 127.0.0.1 -u root -P 3306 -A -p
```

because it connects over TCP to:

```
127.0.0.1:3306
```

These fail:

```
mysql -h localhost -u root -P 3306 -A -p
mysql -u root -P 3306 -A -p
```

because they likely connect through the local MySQL socket and authenticate as:

```
root@localhost
```

The error confirms that:

```
ERROR 1045 (28000): Access denied for user 'root'@'localhost' (using password: YES)
```

The main point:
```
3306 is a TCP port.
Unix sockets do not use TCP ports.
Unix sockets use local socket file paths instead.
```

So:
```
-P 3306
```

only matters when the connection protocol is TCP.

For socket connections, the comparable option is:
```
-S /path/to/mysql.sock
```

or:
```
--socket=/path/to/mysql.sock
```

So yes, `mysql -u root -P 3306 -A -p` defaults to `localhost`, and in MySQL on Linux, `localhost` usually means socket-based login, not the same as connecting to `127.0.0.1` over TCP.