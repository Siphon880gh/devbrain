This advanced version lets you have more granular control over the database (postgres) that n8n is built on top of and control the versions that run

Docker:
```
services:
  postgres:
    image: postgres:15-alpine
    environment:
    - POSTGRES_DB=n8n
    - POSTGRES_USER=n8n
    - POSTGRES_PASSWORD=n8n_password
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
    - DATABASE_URL=postgresql://n8n:n8n_password@postgres:5432/n8n
    - DB_TYPE=postgresdb
    - DB_POSTGRESDB_HOST=postgres
    - DB_POSTGRESDB_PORT=5432
    - DB_POSTGRESDB_DATABASE=n8n
    - DB_POSTGRESDB_USER=n8n
    - DB_POSTGRESDB_PASSWORD=n8n_password
    - N8N_COMMUNITY_PACKAGES_ENABLED=true
    depends_on:
      postgres: 
        condition: service_healthy
    volumes:
    - n8n_data_5002:/root/.n8n
  
volumes:
  postgres_data:
  n8n_data_5002:
```