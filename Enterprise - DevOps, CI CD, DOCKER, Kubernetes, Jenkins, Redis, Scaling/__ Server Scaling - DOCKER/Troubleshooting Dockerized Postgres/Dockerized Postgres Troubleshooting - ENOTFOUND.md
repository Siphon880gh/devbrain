### **Troubleshooting `getaddrinfo ENOTFOUND` in a Dockerized PostgreSQL Setup**

#### **Issue:**
Your Node.js application inside the `express_test_container` cannot find the PostgreSQL container, resulting in the following error:
```
Error executing query Error: getaddrinfo ENOTFOUND postgres_test_container
```

This error means the application is using an incorrect hostname to connect to the PostgreSQL service.

#### **Solution:**

1. **Check the running services and their assigned hostnames:** Run the following command to list the services and their associated hostnames:
```
docker compose ps  
```

2. **Identify the correct hostname:**
	- The service names listed in the "SERVICE" column of the `docker compose ps` output are the hostnames that containers should use to communicate with each other.
	- If your PostgreSQL service is named `read_postgres`, use that in your connection string instead of `postgres_test_container`.

3. **Update the connection string in your application (`app.js` or `.env`):** Modify the database connection URL in your app to match the correct service name. Example:
	```
	const { Pool } = require('pg');  
	  
	const pool = new Pool({  
	    user: 'your_user',  
	    host: 'read_postgres',  // Correct hostname from docker compose  
	    database: 'your_database',  
	    password: 'your_password',  
	    port: 5432,  
	});
	```

4. **Restart the services:** Apply the changes and restart the containers:
	```
	docker compose down && docker compose up -d  
	```

#### **Additional Debugging Steps:**

- **Check logs for errors:**
	```
	docker compose logs -f express_test_container  
	docker compose logs -f postgres_container  
	```

- **Confirm the database service is listening on port 5432:**
	```
	docker exec -it read_postgres psql -U your_user -d your_database -c "\conninfo"
	```

- **Ensure the application service depends on the database service in `docker-compose.yml`:**
	```
	services:  
	  read_postgres:  
	    image: postgres:latest  
	    restart: always  
	    environment:  
	      POSTGRES_USER: your_user  
	      POSTGRES_PASSWORD: your_password  
	      POSTGRES_DB: your_database  
	  
	  express_test_container:  
	    build: .  
	    depends_on:  
	      - read_postgres  
	    environment:  
	      DATABASE_HOST: read_postgres
	```

By following these steps, you should be able to resolve the `getaddrinfo ENOTFOUND` error and ensure that your application correctly connects to the PostgreSQL database within Docker Compose.