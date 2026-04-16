Check whether PostgreSQL is already installed:

```bash
psql --version
```

If it is not installed on Debian or Ubuntu:

```bash
sudo apt update
sudo apt install postgresql postgresql-contrib
```

Enable PostgreSQL to start on boot:

```bash
sudo systemctl enable postgresql
```

Check whether the service is running:

```bash
sudo systemctl status postgresql
```

**PostgreSQL service and access basics**

To open the PostgreSQL shell as the default superuser:

```bash
sudo -u postgres psql
```
^ **`-u postgres`** tells `sudo` to switch to the **`postgres` system user** (instead of root)


Should you worry about the postgres super user? No worries:
- The **`postgres` database user does NOT use a password locally**
- It uses **peer authentication** (trusts the OS user)

To restart PostgreSQL:

```bash
sudo systemctl restart postgresql
```

To quickly inspect PostgreSQL logs if something is failing:

```bash
sudo tail -n 100 /var/log/postgresql/postgresql-*.log
```

**Create authentication right away**

Just like other databases, PostgreSQL should not be left wide open. Create your application user and database early so you are not building against the default superuser workflow longer than necessary.

Create the user with a password:
- Note you must have quotes for the USER so that it's case sensitive, otherwise the username would be stored all lowercase. When logging in later with that username, it won't let you know if it's mistyped or misspelled.
```sql
CREATE USER "{USER}" WITH PASSWORD "{PASSWORD}";
```

Check that the username is what you expected (because of the lowercase/uppercase nuance):
```
\du
```
^ Means display users

Create the database:

```sql
CREATE DATABASE myapp_db;
```

Grant database privileges:

```sql
GRANT ALL PRIVILEGES ON DATABASE myapp_db TO "{USER}";
GRANT ALL ON SCHEMA public TO "{USER}";
```

**Verify login from the command line**

Exit the psql shell (`exit` or `\q`), then test logging in as that application user.
- Note if you mistyped the username, it won't let you know that because it'll just be a password authentication failed error

```bash
psql -h 127.0.0.1 -U "{USER}" -d myapp_db
```

Use `-h 127.0.0.1` on purpose. That forces a TCP connection instead of a Unix socket, which helps avoid authentication confusion when testing.

**If having problems authenticating:**
- Check if the username was created with case sensitivity (if surrounded by quotes) or automatically all lower case (no quotes).
- Check authentication method in settings. Refer to ____

**Once connected, run a few quick checks:**

```sql
SELECT NOW();
SELECT current_user;
SELECT current_database();
```

You can also test with a one-liner from the shell:

```bash
psql -h 127.0.0.1 -U myapp_user -d myapp_db -c "SELECT NOW();"
```


**Quick test table**

To test inserts and reads, create a simple table:

```sql
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(255)
);
```

---

**pgAdmin for GUI Management**

For users preferring a graphical interface, **pgAdmin** is a popular option across Linux, macOS, and Windows. It provides an intuitive interface for creating databases, tables, running queries, and managing settings.

Refer to [[PostgreSQL pgAdmin (GUI)]]