
Aka:
- Always on
- Persistent
- Supervised

See the docker-compose.yml example:
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

The key is that there's:
```
    restart: always
```