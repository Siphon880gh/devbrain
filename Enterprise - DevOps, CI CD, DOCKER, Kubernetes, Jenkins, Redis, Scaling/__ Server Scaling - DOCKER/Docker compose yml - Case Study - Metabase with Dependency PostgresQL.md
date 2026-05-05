Consider this `docker-compose.yml` file for the BI tool Metabase on ARM64 chip (https://github.com/StephaneTurquay/metabase-arm64-docker):

Context: Metabase is a BI tool that connects to your server's MySQL/MongoDB/etc so it can present live data in a way that's easy for non-database professionals to understand, to make business decisions, or to show investors that the business is thriving, usually in the form of totals, bar charts, line charts, etc

docker-compose.yml:
```
version: '3.8'
services:
  metabase:
    image: stephaneturquay/metabase-arm64:latest
    ports:
      - "${PORT:-3000}:${PORT:-3000}"
    environment:
      MB_JETTY_PORT: "${PORT:-3000}"
      MB_DB_TYPE: "${DB_TYPE:-postgres}"
      MB_DB_DBNAME: "${DB_NAME:-metabaseappdb}"
      MB_DB_PORT: "${DB_PORT:-5432}"
      MB_DB_USER: "${DB_USER:-myuser}"
      MB_DB_PASS: "${DB_PASS:-mypassword}"
      MB_DB_HOST: "${DB_HOST:-db}"
    depends_on:
      - db

  db:
    image: postgres:latest
    ports:
      - "5432:5432"
    environment:
      POSTGRES_USER: myuser
      POSTGRES_PASSWORD: mypassword
      POSTGRES_DB: metabaseappdb
    volumes:
      - postgres-data:/var/lib/postgresql/data

volumes:
  postgres-data:
```

  Here’s a breakdown of what happens:

1. **PostgreSQL Container**:
    - The `db` service specifies `postgres:latest` as the image, so Docker will pull it if it doesn't already exist on your system.
    - It maps port `5432` from the container to the host, making it accessible at `localhost:5432`.
    - It initializes a database with the name `metabaseappdb` and sets up the account `myuser` with the password `mypassword` based on the `POSTGRES_USER`, `POSTGRES_PASSWORD`, and `POSTGRES_DB` environment variables.
    - The data for PostgreSQL is stored in a volume named `postgres-data` to persist data even if the container restarts.
      
2. **Metabase Container**:
    - The `metabase` service uses `stephaneturquay/metabase-arm64:latest`, which Docker will download if it's not already present.
    - It has a dependency on `db`, meaning the `db` container will start before the `metabase` container to ensure PostgreSQL is available when Metabase tries to connect.
    - The environment variables within `metabase` (like `MB_DB_HOST`, `MB_DB_USER`, etc.) configure Metabase to connect to the `db` PostgreSQL container in order for Metabase to be able to save Metabase configurations and user profiles. Docker either pull values from a `.env` file (if available) or use the specified defaults if not (`${VARIABLE:-default}`).
      
3. **Environment Variables**:
    - The `${...}` syntax reads values from a `.env` file if it exists. If a variable isn’t defined in `.env`, it falls back to the specified default value after the `:-`.

In short, Docker Compose will follow this sequence:

- Pull the `postgres:latest` and `stephaneturquay/metabase-arm64:latest` images if they aren’t already on the system.
- Set up PostgreSQL first, using the specified environment variables.
- Launch the Metabase container, passing it the environment variables required to connect to the database.