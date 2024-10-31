
To create a user and password and grant is permissions to a specific database or all databases, this example creates an user named `root` with a password `root` in PostgreSQL:

1. **Access the PostgreSQL command line** as a superuser (usually `postgres`) by running:

   ```bash
   sudo -u postgres psql
   ```

2. **Create the user** with a password:

   ```sql
   CREATE USER root WITH PASSWORD 'root';
   ```

3. **Grant privileges** (optional, based on requirements):

   - To make the user a superuser:

     ```sql
     ALTER USER root WITH SUPERUSER;
     ```

   - Alternatively, you can grant specific privileges (like database creation):

     ```sql
     ALTER USER root CREATEDB;
     ```

4. **Exit the PostgreSQL prompt**:

   ```sql
   \q
   ```

Your `root` user with password `root` is now created and configured in PostgreSQL.