Let's look at this example for Metabase container on ARM64 (Mac M1):

Uncommenting all the lines, running `docker compose up` will read the `docker-compose.yml` file at the working directory, then downloads if not exist the postgres image, then starts a container off postgres. After this, then it finally downloads/run the container for metabase-arm64. These images have been published to Docker so they are looked up and downloaded automatically when you run the docker compose up command:
```
version: '3.8'
services:
  metabase:
	image: stephaneturquay/metabase-arm64:latest
	ports:
	  - "${PORT:-3000}:${PORT:-3000}"
	# environment:
	#   MB_JETTY_PORT: "${PORT:-3000}"
	#   MB_DB_TYPE: "${DB_TYPE:-postgres}"
	#   MB_DB_DBNAME: "${DB_NAME:-metabaseappdb}"
	#   MB_DB_PORT: "${DB_PORT:-5432}"
	#   MB_DB_USER: "${DB_USER:-myuser}"
	#   MB_DB_PASS: "${DB_PASS:-mypassword}"
	#   MB_DB_HOST: "${DB_HOST:-db}"
#     depends_on:
#       - db

#   db:
#     image: postgres:latest
#     ports:
#       - "5432:5432"
#     environment:
#       POSTGRES_USER: myuser
#       POSTGRES_PASSWORD: mypassword
#       POSTGRES_DB: metabaseappdb
#     volumes:
#       - postgres-data:/var/lib/postgresql/data

# volumes:
#   postgres-data:
```

 Notice that PostgreSQL is using a named volume (`postgres-data`), so that all data, including the Metabase configuration saved to the database, will persist across container restarts. 
 
 However, Docker does not automatically created that folder path /var/lib/postgresql/data that mounts to `postgres-data:` (a consistent uri folder path that the postgres container can use). Make sure to create the folder path along `/var/lib/postgresql/data` and you'll likely have to create it with the sudo command because `/var/` requires superadmin or root: `sudo mkdir -p /var/lib/postgresql/data`.
