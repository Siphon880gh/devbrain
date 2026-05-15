On a WordPress site, **“Access denied for user … to database …”** can appear in the **web browser** on first load if WordPress tries to connect to MySQL and the database login fails.

This usually happens when the uploaded WordPress files still have the old database settings inside:

```
wp-config.php
```

Specifically these lines:

```
define('DB_NAME', 'database_name_here');define('DB_USER', 'username_here');define('DB_PASSWORD', 'password_here');define('DB_HOST', 'localhost');
```

@@ Common causes:

- The database name is wrong.
- The database username is wrong.
- The database password is wrong.
- The database user exists but does not have permission to that database.
- `DB_HOST` is wrong, for example `localhost` vs `127.0.0.1`.
- You imported the WordPress files but did not import the old MySQL database yet.
- You created the database but did not assign the user to it with privileges.

In a migration, the most common issue is that the WordPress files were copied over, but the new server’s MySQL database user has not been properly connected or granted access to the imported database.

---

## Step 1: Check `wp-config.php`

Open your WordPress `wp-config.php` file and look for these lines:

```php
define('DB_NAME', 'wp_expert_teams');
define('DB_USER', 'wff2');
define('DB_PASSWORD', 'your_password_here');
define('DB_HOST', 'localhost');
```

Check that:

- `DB_NAME` is the correct database name on the new server.
    
- `DB_USER` is the correct MySQL username.
    
- `DB_PASSWORD` is the correct password for that MySQL user.
    
- `DB_HOST` is correct. Usually this is `localhost` when MySQL is running on the same server.
    

---

## Step 2: Test the MySQL User from SSH

If your hosting panel, WHM, cPanel, or CloudPanel does not clearly show which database user has access to which database, you can test from SSH.

Run:

```bash
mysql -h 127.0.0.1 -u wff2 -p
```

Enter the password for the MySQL user.

Then inside MySQL, run:

```sql
SHOW DATABASES;
```

If you do not see:

```text
wp_expert_teams
```

then the user `wff2` probably does not have permission to access that database.

Exit MySQL:

```sql
exit;
```

---

## Step 3: Log Into MySQL as Root or Admin

If you have root SSH access, you may be able to enter MySQL by running:

```bash
mysql
```

On many servers, this works because the Linux root user can access MySQL through the local Unix socket.

If that does not work, try:

```bash
mysql -u root -p
```

Once inside MySQL, confirm that the database exists:

```sql
SHOW DATABASES;
```

Look for:

```text
wp_expert_teams
```

---

## Step 4: Check the User’s Current Permissions

To see what permissions the MySQL user currently has, run:

```sql
SHOW GRANTS FOR 'wff2'@'localhost';
```

Use the exact username and host shown in the error message.

For example, if the error says:

```text
Access denied for user 'wff2'@'localhost' to database 'wp_expert_teams'
```

then check:

```sql
SHOW GRANTS FOR 'wff2'@'localhost';
```

Do not accidentally check a different user, such as:

```sql
SHOW GRANTS FOR 'wff'@'localhost';
```

unless `wff` is the actual database user being used by WordPress.

---

## Step 5: Grant the User Access to the WordPress Database

If the database exists, but the user does not have access to it, grant permissions:

```sql
GRANT ALL PRIVILEGES ON wp_expert_teams.* TO 'wff2'@'localhost';
```

Then run:

```sql
FLUSH PRIVILEGES;
```

Now test the user again:

```bash
mysql -u wff2 -p
```

Inside MySQL:

```sql
SHOW DATABASES;
```

If `wp_expert_teams` now appears, the database user has access.

---

## phpMyAdmin Method

You may also be able to check and fix this through phpMyAdmin.

To check the user’s permissions, run:

```sql
SHOW GRANTS FOR 'wff2'@'localhost';
```

To grant access, run:

```sql
GRANT ALL PRIVILEGES ON wp_expert_teams.* TO 'wff2'@'localhost';
FLUSH PRIVILEGES;
```

However, some hosting providers block permission-management commands in phpMyAdmin. If those commands fail, use the hosting control panel or SSH root/admin access instead.

---

## Final Check

After fixing the database user permissions, reload the WordPress site in the browser.

If the values in `wp-config.php` are correct and the MySQL user has access to the database, WordPress should load normally.

The key idea is:

```text
Copied WordPress files are not enough.
```

WordPress also needs the database connection in `wp-config.php` to match the actual MySQL database, username, password, host, and permissions on the new server.