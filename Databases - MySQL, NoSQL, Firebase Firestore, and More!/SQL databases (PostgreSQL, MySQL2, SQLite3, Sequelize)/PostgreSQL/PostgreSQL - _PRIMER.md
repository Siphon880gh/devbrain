Here’s a clean, organized format for your PostgreSQL Beginner Guide:

---

# PostgreSQL Beginner Guide

### 1. What is PostgreSQL?
PostgreSQL is an open-source, relational database system known for its robustness and rich features. It’s commonly used for applications requiring complex querying, transaction management, or compatibility with SQL standards.

### 2. Installation
To install PostgreSQL, look up platform-specific instructions. For example:

- **macOS** (using Homebrew):
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

### 3. Starting the PostgreSQL Shell (`psql`)
After installation, start the PostgreSQL interactive terminal, which opens the default `postgres` database using the default `postgres` user:
```bash
psql postgres
```


### 4. Basic Commands

#### 4.1 Going into the `psql` Shell
- **Connect to a specific database**:  
  ```bash
  psql your_database_name
  ```

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

Make sure when you download, you dont click a fake download button from a misleading ad:
https://www.pgadmin.org/

When you choose Mac, you're presented with:
```

CURRENT_MAINTAINER
pgadmin4-8.12-arm64.dmg
pgadmin4-8.12-x86_64.dmg
```

ARM64 chips are the Mac M1 and M2
X86_64 are the 74 bit of Intel and AMD