Aka: Get Started

Required knowledge
- Know what is BA vs BI: [[_What is BA and BI]]
- What is Metabase and why we choose Metabase: [[Choosing MongoDB Shell vs Mongo Native Driver for Node vs Mongoose]]

Required technical specs
- Have either Docker daemon or Docker Desktop installed
- Have progres
## Installation

### Install on Non-Mac or Non ARM64 chip

Clone git into a local folder then follow instructions on the Readme (yarn install, etc):
https://github.com/metabase/metabase

For Production, you want to config the Metabase container to use another database besides H2 (which lacks concurrency and is more for development phase):
https://www.metabase.com/docs/latest/installation-and-operation/configuring-application-database

### Install on Mac or ARM64 chip

You usually download and install Metabase. However if you're on a Mac M1/M2/etc or any device on an ARM64 chip, it becomes a bit problematic showing the warning:
```
_WARNING: The requested image's platform (linux/amd64) does not match the detected host platform (linux/arm64/v8) and no specific platform was requested_
```

Someone has packaged the JAR file into a Docker image that runs well on ARM64-based architecture:

https://github.com/StephaneTurquay/metabase-arm64-docker

### Run Docker Compose on Mac or ARM64 chip

#### Docker Daemon
1. Make sure your terminal is in the same folder where you cloned metabase-arm64-docker

2. Run Docker daemon
- either having installed and run Docker daemon
- or having installed and run Docker Desktop (GUI for Docker).

#### Docker directly without a persistent Metabase app config database
3. Run docker directly (do not run the docker-compose.yml yet because we want to figure out the correct options by running options in the docker cli directly, since it gives the errors right away):
	```
	docker run \  
	-p 3500:3000 \  
	-e MB_JETTY_PORT=3000 \  
	stephaneturquay/metabase-arm64:latest
	```
	^ Notice that `-d` is not part of the cli which is usually included in docker cli's. Without the -d, it's no longer in daemon or detached mode, meaning errors can show up right away, and we want to see any errors.
	
	If you get an error like:
	`docker: invalid reference format.
	`See 'docker run --help'.`
	`zsh: command not found: -p`
	Then make sure there's no space after `\`.

4. Visit http://localhost:3500/ which will ask you to setup Metabase. The wizard includes connecting to your desired database. You may choose to connect your database, but your work will be wiped out the next time Metabase restarts. This is because it's using H2 database and the purpose is for you to explore Metabase. Now that we know we can run Metabase, let's run Metabase with a persistent database on your computer.

#### Docker directly with Metabase app config database

Metabase to store its application data in PostgreSQL, so all settings, dashboards, and other configurations will be remembered as long as the PostgreSQL data volume is intact.

5. Possible approaches
	1. APPROACH 1: Now we will adjust the docker cli command to take in your postgres. Note if you DO NOT have postgres, you may want to install postgres at [[PostgreSQL - _PRIMER]]
	   
	   We attempt to figure out the correct options to connect to your machine's postgres:
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

		Note the host.docker.internal is a variable that Docker cli will read (And Docker compose will read in our future docker-compose.yml file)

	   
	2. APPROACH 2: Or you may want to run the postgres container. In that case you can work with the Docker compose yml file directly, uncommenting all the lines:
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
	- But notice that PostgreSQL is using a named volume (`postgres-data`), so that all data, including the Metabase configuration saved to the database, will persist across container restarts. However, Docker does not automatically created that folder path /var/lib/postgresql/data that mounts to `postgres-data:` (a consistent uri folder path that the postgres container can use). Make sure to create the folder path along `/var/lib/postgresql/data` and you'll likely have to create it with the sudo command because `/var/` requires superadmin or root: `sudo mkdir -p /var/lib/postgresql/data`. Make sure to uncomment the lines!
		- The PostgresQL container itself is ephemeral like all containers, but the data is stored in the `postgres-data` volume, which is not deleted on container restart or shutdown. Only when you explicitly remove the volume (`docker volume rm postgres-data`) will the data be erased.
	- Go to next section on working with the Compose file, which you would have from working on the docker cli.