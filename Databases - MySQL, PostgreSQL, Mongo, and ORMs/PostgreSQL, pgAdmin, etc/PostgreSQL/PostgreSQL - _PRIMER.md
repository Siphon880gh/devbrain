Here’s a clean, organized format for your PostgreSQL Beginner Guide:

---

# PostgreSQL Beginner Guide

### 1. What is PostgreSQL?
PostgreSQL is an open-source, relational database system known for its robustness and rich features. It’s commonly used for applications requiring complex querying, transaction management, or compatibility with SQL standards.

### 2. Installation
To install PostgreSQL, look up platform-specific instructions. For example:

#### MacOS
- **macOS using Homebrew:**
  ```bash
  brew install postgresql
  ```
  - **Start PostgreSQL service**:  
    ```bash
    brew services start postgresql
    ```
  - **Stop PostgreSQL service**:  
    ```bash
    brew services stop postgresql
    ```
  - **Restart PostgreSQL service**:  
    ```bash
    brew services restart postgresql
    ```

#### Debian 12
- **Debian 12 using apt:**
```
sudo apt install postgresql postgresql-contrib
```

### 3. Test If Can Access the PostgreSQL Shell (`psql`)
After installation, start the PostgreSQL interactive terminal, which opens the default `postgres` database using the default `postgres` user:
```bash
psql postgres
```

Troubleshooting Point (Might on Debian 12):
- psql: error: connection to server on socket "/var/run/postgresql/.s.PGSQL.5432" failed: FATAL:  role "root" does not exist
- That means to: `psql -U postgres postgres

Troubleshooting Subsequent Point (If caused by trying to fix previous error)
- In peer authentication, it allows the PostgreSQL `postgres` user to connect if it’s the same as the system `postgres` user
- Then try the command: `sudo -u postgres psql`

The previous two troubleshooting points is because on some Linux postgres packages, the default authentication is peer rather than trust or md4. To make `psql postgres` work, which is what you want if you use other Docker containers that rely on postgres (you're making postgres more compatible)...

Edit the postgresql authentication config file (Get the exact version folder by running `ls /etc/postgresql/`):
```
vi /etc/postgresql/<version>/main/pg_hba.conf
```

Change the peer authentication method or add an entry either to:
- Allow connections from your IP for user root on the database root. For example:
```
host    root    root    208.76.249.75/32    md5
```
- Or allow all databases and users from any host:
```
host    all     all     0.0.0.0/0          md5
```
^ Note using 0.0.0.0/0 is less secure as it opens access to all IPs. Consider limiting it to specific IPs if possible.

- If you edited pg_hba.conf, you have to restart postgres service to apply the changes:
```
sudo service postgresql restart
```

- Then see if the simpler and more compatible command `psql postgres` lets you into the postgres shell.

### 3b. Test if remote access allowed (Optional)

If you plan to manage your remote postgreSQL database on your local computer through pgAdmin (GUI) OR you plan to make the database available to another server (eg. the other server is API heavy while your current server is database heavy):

You have to make sure listening is available:
- Open your PostgreSQL configuration file (`postgresql.conf`, usually located in `/etc/postgresql/<version>/main/` or `/var/lib/pgsql/data/`).

- Find the line for `listen_addresses` and ensure it’s set to accept external connections:
```
listen_addresses = '*'
```

- Make sure to restart postgreSQL to apply the changes:
```
sudo service postgresql restart
```

### 4. Basic Commands

#### 4.1 Going into the `psql` Shell
- **Connect to a specific database**:  
  ```bash
  psql your_database_name
  ```

- Connect to shell with username and password interactively or non-interactively: 
	- Refer to section "5. Security"

#### 4.2 General Database Commands in `psql` Shell
Commands in the PostgreSQL shell start with a backslash (`\`):
- **List all databases**: `\l`
- **Display all tables in the current database**: `\dt`  
  (Returns an error if there are no tables in the database)
- **Connect to another database**:  
  ```bash
  \c <DATABASE-NAME>
  ```

#### 4.3 Running Queries in `psql` Shell
- **Create a new database**:  
  ```sql
  CREATE DATABASE your_database_name;
  ```


### 5. Security

You can interactively sign in (W means passWord):
```
psql postgres -U root -W
```

You can non-interactively sign in:
```
PGPASSWORD="root" psql -U root -d postgres
```

Using the `PGPASSWORD` environment variable may expose the password to other users on the same system (it might be visible in process lists). For more secure alternatives, use a `.pgpass` file (Outside the scope of this tutorial)

If you can go into the psql shell with or without password, it's because you have to tell Postgres to enforce password-only access - Refer to the next section on `pg_hba.conf` configuration.

### 6. Configuration Files Overview
PostgreSQL has two primary configuration files:

- **`postgresql.conf`**: Controls settings for performance, logging, and networking.
- **`pg_hba.conf`**: Manages client authentication, specifying which users can connect and how.

#### 6.1 `postgresql.conf`
- **Purpose**: General PostgreSQL configuration, including:
  - **Networking**:
    - `listen_addresses`: Set to `*` to allow connections from any IP or `localhost` for local only.
    - `port`: Default is `5432`.
  - **Performance Settings**: Includes parameters like `shared_buffers` and `work_mem`.
  - **Logging Settings**: Includes `log_statement` and `log_directory`.
  - **Usual Filepath**: `/etc/postgresql/<version>/main/postgresql.conf` (Debian/Ubuntu) or `/var/lib/pgsql/<version>/data/postgresql.conf` (CentOS/RHEL/Fedora).

#### 6.2 `pg_hba.conf`
- **Purpose**: Controls client authentication rules, determining who can connect and how.
- **Common Authentication Methods**:
  - `trust`: No password required.
  - `md5`: Password-based authentication.
  - `peer`: OS-based username matching.
  - `scram-sha-256`: Secure password-based authentication.
- **Usual Filepath**: `/etc/postgresql/<version>/main/pg_hba.conf` (Debian/Ubuntu) or `/var/lib/pgsql/<version>/data/pg_hba.conf` (CentOS/RHEL/Fedora).

To allow remote access, add a rule in `pg_hba.conf`:
```plaintext
# TYPE  DATABASE        USER            ADDRESS                 METHOD
host    all             all             0.0.0.0/0               md5
```

#### Applying Config Changes
After editing these files, reload or restart PostgreSQL:
- **Reload** (for minor changes without disconnecting clients):
  ```bash
  sudo systemctl reload postgresql
  ```
- **Restart** (for more significant changes):
  ```bash
  sudo systemctl restart postgresql
  ```

### 7. Using `psql` to Connect and Query
To connect with a specific user and database:
```bash
psql -U your_username -d your_database_name -W
```
> `-W` prompts for a password.

#### Running Queries
Inside the `psql` shell:
- **Create a Database**:
  ```sql
  CREATE DATABASE metabaseappdb;
  ```

### 7. Basic PostgreSQL Query Syntax

- **Creating Tables**:  
  ```sql
  CREATE TABLE your_table_name (
      column_name1 DATA_TYPE CONSTRAINT,
      column_name2 DATA_TYPE CONSTRAINT,
      ...
  );
  ```

- **Inserting Data**:  
```sql
INSERT INTO your_table_name (column1, column2, ...) VALUES (value1, value2, ...);
```

### 8. pgAdmin for GUI Management
For users preferring a graphical interface, **pgAdmin** is a popular option across Linux, macOS, and Windows. It provides an intuitive interface for creating databases, tables, running queries, and managing settings.

Refer to [[PostgreSQL pgAdmin (GUI)]]