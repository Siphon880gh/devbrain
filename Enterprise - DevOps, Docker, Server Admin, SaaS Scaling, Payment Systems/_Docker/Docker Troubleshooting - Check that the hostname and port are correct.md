
Getting this error:
```
Caused by: org.postgresql.util.PSQLException: Connection to 127.0.0.1:5432 refused. Check that the hostname and port are correct and that the postmaster is accepting TCP/IP connections.
```


From this command:
```
docker run -d \  
-p 3500:3000 \  
-e MB_JETTY_PORT=3000 \  
-e MB_DB_TYPE=postgres \  
-e MB_DB_DBNAME=metabaseappdb \  
-e MB_DB_PORT=5432 \  
-e MB_DB_USER=root \  
-e MB_DB_PASS=root \  
-e MB_DB_HOST=host.docker.internal \  
stephaneturquay/metabase-arm64:latest
```

Or from running `docker compose up` that reads `docker-compose.yml` file:
```
version: '3.8'

services:
  metabase:
    image: stephaneturquay/metabase-arm64:latest
    ports:
      - "3500:3000"
    environment:
      MB_JETTY_PORT: 3000
      MB_DB_TYPE: postgres
      MB_DB_DBNAME: metabaseappdb
      MB_DB_PORT: 5432
      MB_DB_USER: root
      MB_DB_PASS: root
      MB_DB_HOST: host.docker.internal
    restart: always

```

If you're using `host.docker.internal`, it is probably not available because you don't have Docker Desktop or this is a production environment server (Linux distro as of Oct 2024 does not provide host.docker.internal). Swap it out with the IP address of your server

If you're using an IP address already, then that IP address could be wrong.

Find your Host IP Address and have that in place of "host.docker.internal" or the old incorrect IP address:
```
hostname -I | awk '{print $1}'
```
