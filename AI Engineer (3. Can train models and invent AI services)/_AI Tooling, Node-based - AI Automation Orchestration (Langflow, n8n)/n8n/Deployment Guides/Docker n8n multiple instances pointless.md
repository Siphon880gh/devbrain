A single n8n instance can handle multiple workflow triggers, including workflows that are running at the same time after being triggered, especially when they spend time waiting on API calls or other slow steps.

At first, running multiple n8n instances on the same server or local machine may seem like a way to scale performance. In practice, that is not really what is happening. When more than one instance is running, one instance can interfere with the other. For example, if one instance is triggered and starts handling workflow activity, the other instance may fail when trying to run workflows or make API calls at the same time. You can also see signs of shared state in the login behavior: logging into one instance may log you out of the other, even if you selected “Remember Password.”

Still, this can be a useful thought experiment. Even if multiple local instances are not functionally useful for real scaling, setting them up helps you understand how n8n stores and uses database information. It also gives you practice with moving n8n from one environment to another, even if only indirectly.

---

Requirements:
- Postgres setup correctly on the localhost or server you'll be running multiple instances at

compose.yml:
```
services:
  postgres:
    image: postgres:15-alpine
    environment:
    - POSTGRES_DB=XXX
    - POSTGRES_USER=XXX
    - POSTGRES_PASSWORD=XXXX
    ports:
    - "127.0.0.1:5433:5432"
    volumes:
    - postgres_data:/var/lib/postgresql/data
    healthcheck:
      test: ["CMD-SHELL", "pg_isready -U n8n"]
      interval: 5s
      timeout: 5s
      retries: 5
  
  n8n5002:
    image: registry.heroku.com/n8n-tc/web:latest
    platform: linux/amd64
    ports:
    - "127.0.0.1:5002:5678"
    environment:
    - PORT=5678
    - HOST=0.0.0.0
    - N8N_PROTOCOL=http
    - N8N_URL=http://localhost:5002
    - N8N_PORT=5678
    - N8N_HOST=0.0.0.0
    - DATABASE_URL=postgresql://XXX:XXXX@postgres:5432/n8n
    - DB_TYPE=postgresdb
    - DB_POSTGRESDB_HOST=postgres
    - DB_POSTGRESDB_PORT=5432
    - DB_POSTGRESDB_DATABASE=n8n
    - DB_POSTGRESDB_USER=XXX
    - DB_POSTGRESDB_PASSWORD=XXXX
    - N8N_COMMUNITY_PACKAGES_ENABLED=true
    depends_on:
      postgres: 
        condition: service_healthy
    volumes:
    - n8n_data_5002:/root/.n8n
  
  n8n5003:
      image: registry.heroku.com/n8n-tc/web:latest
      platform: linux/amd64
      ports:
        - "127.0.0.1:5003:5678"
      environment:
        - PORT=5678
        - HOST=0.0.0.0
        - N8N_PROTOCOL=http
        - N8N_URL=http://localhost:5003
        - N8N_PORT=5678
        - N8N_HOST=0.0.0.0
        - DATABASE_URL=postgresql://XXX:XXXX@postgres:5432/XXX
        - DB_TYPE=postgresdb
        - DB_POSTGRESDB_HOST=postgres
        - DB_POSTGRESDB_PORT=5432
        - DB_POSTGRESDB_DATABASE=XXX
        - DB_POSTGRESDB_USER=XXX
        - DB_POSTGRESDB_PASSWORD=XXXX
        - N8N_COMMUNITY_PACKAGES_ENABLED=true
      depends_on:
         postgres:
           condition: service_healthy
      volumes:
         - n8n_data_5003:/root/.n8n
  
volumes:
  postgres_data:
  n8n_data_5002:
  n8n_data_5003:
```

You'd run:
```
docker compose up -d
```

---


Open your browser and navigate to:
```
http://localhost:5002
```

And:
```
http://localhost:5003
```

Try to log into both instances. Then return to one of the instances. You're asked to login again!

---

Let's convert it back to one instance so the next time you run docker compose, it'll stick to one instance. Lets comment out the 5003 instance and volumes. You may want to erase volumes too (1. List volumes with `docker volume ls`, 2. Then delete a particular volume with `docker volume rm __`):

compose.yml-
```
services:
  postgres:
    image: postgres:15-alpine
    environment:
    - POSTGRES_DB=XXX
    - POSTGRES_USER=XXX
    - POSTGRES_PASSWORD=XXXX
    ports:
    - "127.0.0.1:5433:5432"
    volumes:
    - postgres_data:/var/lib/postgresql/data
    healthcheck:
      test: ["CMD-SHELL", "pg_isready -U n8n"]
      interval: 5s
      timeout: 5s
      retries: 5
  
  n8n5002:
    image: registry.heroku.com/n8n-tc/web:latest
    platform: linux/amd64
    ports:
    - "127.0.0.1:5002:5678"
    environment:
    - PORT=5678
    - HOST=0.0.0.0
    - N8N_PROTOCOL=http
    - N8N_URL=http://localhost:5002
    - N8N_PORT=5678
    - N8N_HOST=0.0.0.0
    - DATABASE_URL=postgresql://XXX:XXXX@postgres:5432/n8n
    - DB_TYPE=postgresdb
    - DB_POSTGRESDB_HOST=postgres
    - DB_POSTGRESDB_PORT=5432
    - DB_POSTGRESDB_DATABASE=XXX
    - DB_POSTGRESDB_USER=XXX
    - DB_POSTGRESDB_PASSWORD=XXXX
    - N8N_COMMUNITY_PACKAGES_ENABLED=true
    depends_on:
      postgres: 
        condition: service_healthy
    volumes:
    - n8n_data_5002:/root/.n8n
  
  # n8n5003:
      # image: registry.heroku.com/n8n-tc/web:latest
      # platform: linux/amd64
      # ports:
        # - "127.0.0.1:5003:5678"
      # environment:
        # - PORT=5678
        # - HOST=0.0.0.0
        # - N8N_PROTOCOL=http
        # - N8N_URL=http://localhost:5003
        # - N8N_PORT=5678
        # - N8N_HOST=0.0.0.0
        # - DATABASE_URL=postgresql://XXX:XXXX@postgres:5432/n8n
        # - DB_TYPE=postgresdb
        # - DB_POSTGRESDB_HOST=postgres
        # - DB_POSTGRESDB_PORT=5432
        # - DB_POSTGRESDB_DATABASE=XXX
        # - DB_POSTGRESDB_USER=XXX
        # - DB_POSTGRESDB_PASSWORD=XXXX
        # - N8N_COMMUNITY_PACKAGES_ENABLED=true
      # depends_on:
         # postgres:
           # condition: service_healthy
      # volumes:
         # - n8n_data_5003:/root/.n8n
  
volumes:
  postgres_data:
  n8n_data_5002:
  # n8n_data_5003:
```