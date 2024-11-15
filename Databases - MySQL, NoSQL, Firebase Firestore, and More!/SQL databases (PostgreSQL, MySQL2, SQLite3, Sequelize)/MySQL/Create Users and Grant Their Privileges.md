
Creating an user
```
CREATE USER 'username'@'host' IDENTIFIED BY 'password';

```
^ Make sure to replace username and password

Giving all privileges
```
GRANT ALL PRIVILEGES ON *.* TO 'username'@'%' WITH GRANT OPTION;
```
^ Make sure to replace username. The % means allow from any IP address or hostname. If that doesn't serve your needs, you can secure it by replacing `%` with `localhost`

Flush the privileges to ensure the changes take effect immediately:
```
FLUSH PRIVILEGES;
```
