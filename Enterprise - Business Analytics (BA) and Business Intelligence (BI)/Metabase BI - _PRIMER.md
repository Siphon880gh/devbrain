Aka: Get Started

Required knowledge
- Know what is BA vs BI: [[_What is BA and BI]]
- What is Metabase and why we choose Metabase: [[Metabase BI - _Choosing Metabase]]

Required technical specs
- Have either Docker daemon or Docker Desktop installed
- Have progres

Additional Reading - What Metabase can do: [[Metabase BI - _Choosing Metabase]]

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
- Either having installed and run Docker daemon
- Or having installed and run Docker Desktop (GUI for Docker).
  
  Not doing so will cause this error when running most any Docker commands:
  Cannot connect to the Docker daemon at [unix:///Users/wengffung/.docker/run/docker.sock.](unix:///Users/wengffung/.docker/run/docker.sock.) Is the docker daemon running?

#### Docker directly without a persistent Metabase app config database
3. Run docker directly (do not run the docker-compose.yml yet because we want to figure out the correct options by running options in the docker cli directly, since it gives the errors right away):
	```
	docker run \  
	-p 3500:3000 \  
	-e MB_JETTY_PORT=3000 \  
	stephaneturquay/metabase-arm64:latest
	```
	^ Notice that `-d` is not part of the cli which is usually included in docker cli's. Without the -d, it's no longer in daemon or detached mode, meaning errors can show up right away, and we want to see any errors.
	
	 We are testing with port 3500, but it could've easily been `-p 3000:3000`. I don't recommend using 3000 as a practice because 3000 is a common port for NodeJS apps, so I like to have a range that's way off for BI tools. You may want to google what are good port numbers that services don't use, including services on your computer/server, and services you may potentially use in the future.
	
	If you get an error like:
	`docker: invalid reference format.
	`See 'docker run --help'.`
	`zsh: command not found: -p`
	Then make sure there's no space after `\`.

4. Visit http://localhost:3500/ which will ask you to setup Metabase. The wizard includes connecting to your desired database. You may choose to connect your database, but your work will be wiped out the next time Metabase restarts. This is because it's using H2 database and the purpose is for you to explore Metabase. Now that we know we can run Metabase, let's run Metabase with a persistent database on your computer.

#### Docker directly with Metabase app config database

Metabase to store its application data in PostgreSQL, so all settings, dashboards, and other configurations will be remembered as long as the PostgreSQL data volume is intact.

6. Possible approaches of postgres
	1. **APPROACH 1**: Now we will adjust the docker cli command to take in your postgres. Note if you DO NOT have postgres, you may want to install postgres at [[PostgreSQL - _PRIMER]]
	   
	   Go into PostgresSQL shell and create the database metabaseappdb which our command will choose as the database for Metabase to store its configuration and user profiles. Hint: `CREATE DATABASE metabaseappdb;`. 
	   
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

		The `host.docker.internal` is a special DNS name provided by Docker to allow containers to communicate with the host machine. This name is:
		- **Supported only by Docker Desktop** on macOS, Windows, and Linux (when using Docker Desktop).
		- **Not available on native Linux installs of Docker Engine** (without Docker Desktop). In such cases, you'll need to use the host network or specific IP addresses to connect to services on the host..
	
		To test if `host.docker.internal` can be used by Docker to connect to your local computer
		```
		docker run --rm alpine ping -c 4 host.docker.internal
		```

		^ If fails, then just find the host IP address:

		Find your Host IP Address and have that in place of "host.docker.internal"
		```
		hostname -I | awk '{print $1}'
		```
		
		Not fixing this will give error:
		```
		Caused by: org.postgresql.util.PSQLException: Connection to 127.0.0.1:5432 refused. Check that the hostname and port are correct and that the postmaster is accepting TCP/IP connections.
		```
		
		If you can, having it as the variable rather than hard coded IP address of course is more portable. However, on production server you have to us the ip address. We have to figure out what we will be using because later we will rewrite the Docker CLI command into a docker-compose.yml file for portability.
		
		Pay particular attention if there are database errors at approximately this area of the output:
		```
		metabase-1  | 2024-10-28 09:11:46,110 INFO metabase.core :: Setting up and migrating Metabase DB. Please sit tight, this may take a minute...  
		metabase-1  | 2024-10-28 09:11:46,115 INFO db.setup :: Verifying postgres Database Connection ...
		```

		LASTLY: Visit http://localhost:3500 if locally, or http://IP:3500 if remote server. Test that you see setup screen! We may skip setup screen for now.
		   
	1. **APPROACH 2**: Or you may want to run the postgres container. In that case you can work with the Docker compose yml file directly, uncommenting all the lines:
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
	- Go to next section where we work with the Compose file.

#### Adjust the docker compose file

Now we work on the docker compose file more directly to make sure the options are correct

The goal is you have the correct options that successfully makes metabase available on your web browser AND persistently saves your Metabase configuration and user profiles VIA the docker compose file, regardless if we chose to use a postgresql image or to have postgresql installed locally. We will now disregard directly running `docker run` commands because that's not sustainable in the long run.

##### **Approach 1:** Docker Compose file if running local postgresql
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

Note your options may differ depending on the above discussed (like host.docker.internal or your production IP address) (like your DB username and password) (like the hostmachine post you want other than 3500). You may ask ChatGPT: `How to make this command into a docker compose file?` and in the same prompt, paste the command that successfully ran Metabase in your webbrowser and persist with PostgresQL (whether it's your local machine's PostgresQL or the dependency image's PostgresQL)

FYI: Jetty information at [[Metabase BI - Deep Dive - Java Parts]] and Jetty port is the same port as the container app, so leave it alone.

##### **Approach 2:** Docker Compose file if running local postgresql
```
	version: '3.8'
	services:
	  metabase:
	    image: stephaneturquay/metabase-arm64:latest
	    ports:
	      - "${PORT:-3500}:${PORT:-3000}"
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

#### Continued: Docker directly with Metabase app config database

Run the docker compose yml file with this command in the same folder:
```
docker compose up
```

Up means to start. Down means to take it offline. Notice we do not have `-d` flag in the command because we want to see all output for any immediate errors.

Pay particular attention if there are database errors at approximately this area of the output:
```
metabase-1  | 2024-10-28 09:11:46,110 INFO metabase.core :: Setting up and migrating Metabase DB. Please sit tight, this may take a minute...  
metabase-1  | 2024-10-28 09:11:46,115 INFO db.setup :: Verifying postgres Database Connection ...
```

---

## Connect Metabase to Your Database that Needs BI Viewing

Firstly, you may want to kick the `docker compose` into daemon mode so it can run in the background and is not tied to having the terminal opened showing output:

```
docker compose down
docker compose up metabase -d
```

Visit your http://localhost:3500 or http://IP:3500

Setup your account and connect your database
![](https://i.imgur.com/x6QRZ8V.png)

^ If MongoDB: I recommend connecting to MongoDB on a remote server that's opened to internet requests (not blocked by firewall like iptables or ufw). Connecting to a MongoDB locally takes some tweaking.
![](https://i.imgur.com/3qPbFI0.png)

**Or** you can click “Paste connection string” and paste, eg
```
mongodb://MYUSER:MYPASSWORD!@IP:27017/DB_NAME?authSource=admin&directConnection=true
```

Once successfully setup, you could go offline (`docker compose down`) and go back online (`docker compose up -d`)  and see that it won't ask you to connect to your database for BI viewing again. This means your postgresql (whether it's a local postgresql or an image postgresql persisting to a mounted volume path) is successfully persisting the Metabase configuration and user profiles.

Now you can work on creating reports for your cofounders/founders/strategists/investors that they can see live and won't accidentally modify your database.

Before you use it long term, I recommend disabling updates in case things get broken from updates. Refer to [[Metabase BI - Updates Option]].

You may be interested in:
[[Metabase BI - Share Login Credentials]]