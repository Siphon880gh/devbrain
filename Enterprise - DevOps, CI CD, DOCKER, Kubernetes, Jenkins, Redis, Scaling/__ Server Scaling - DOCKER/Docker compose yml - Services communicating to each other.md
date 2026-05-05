
Let's look at this docker-compose.yml:
```
version: "3.8"
services:
  app:
    image: my-web-app
    ports:
      - "8080:80"  # Exposes internal port 80 to host port 8080
    depends_on:
      - db

  db:
    image: postgres
    environment:
      POSTGRES_PASSWORD: secret
    ports:
      - "5432:5432"  # Optional if only used internally

```

The multiple independent containers you can see with `docker ps` are "app" and "db"

As multiple independent containers, they are connected to the same network:
- Each container can **communicate with other containers by service name as the host** (not just IP or `localhost`)
- You can connect to another container using its **internal port** — no need to expose it to the host with `-p`

In terms of service name as the host and the internal port:
- The `db` container runs **PostgreSQL on internal port `5432`**.
- The `app` container can connect to the database using:    
    - Host being "db"
    - Port being 5432
    - So app container / process can make a request to the url `db:5432`?
