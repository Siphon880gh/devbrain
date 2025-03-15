
You don’t have a password for your Postgres so you left it empty. Now your error is:

```
postgres_test_container | Error: Database is uninitialized and superuser password is not specified.  
postgres_test_container | You must specify POSTGRES_PASSWORD to a non-empty value for the  
postgres_test_container | superuser. For example, "-e POSTGRES_PASSWORD=password" on "docker run".  
postgres_test_container |  
postgres_test_container | You may also use "POSTGRES_HOST_AUTH_METHOD=trust" to allow all  
postgres_test_container | connections without a password. This is *not* recommended.  
postgres_test_container |  
postgres_test_container | See PostgreSQL documentation about "trust":  
postgres_test_container | [https://www.postgresql.org/docs/current/auth-trust.html](https://www.postgresql.org/docs/current/auth-trust.html)
```

This could happen on a dockerized postgres

**SOLUTION**
#### **1. Create the `pg_hba.conf` file**

Run the following command to create a `pg_hba.conf` file in your project directory:
```
echo "local   all             all                                     trust  
host    all             all             127.0.0.1/32            trust  
host    all             all             ::1/128                 trust  
host    all             all             0.0.0.0/0               trust" > pg_hba.conf
```

#### **2. Modify `docker-compose.yml`**

Modify your `docker-compose.yml` to copy this configuration file inside the container and specify the correct PostgreSQL configuration:
```
version: '3.8'  
services:  
  postgres:  
    image: postgres:latest  
    container_name: postgres_test_container  
    environment:  
      - POSTGRES_USER=your_user  
      - POSTGRES_DB=your_database  
      - POSTGRES_PASSWORD=your_password  
    volumes:  
      - postgres_data:/var/lib/postgresql/data  
      - ./pg_hba.conf:/var/lib/postgresql/pg_hba.conf  
    command: ["postgres", "-c", "hba_file=/var/lib/postgresql/pg_hba.conf"]  
  
volumes:  
  postgres_data:
```

---

**Alternative Solution (Using `POSTGRES_HOST_AUTH_METHOD=trust`)**

If you don't want to modify `pg_hba.conf`, you can achieve the same effect by setting this environment variable in `docker-compose.yml`:
```
environment:  
  - POSTGRES_HOST_AUTH_METHOD=trust
```

This tells PostgreSQL to allow all connections without requiring a password. **However, this is insecure and should only be used for local development.**