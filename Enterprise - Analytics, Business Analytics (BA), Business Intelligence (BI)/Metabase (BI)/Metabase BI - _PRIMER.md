Aka: Get Started

Required knowledge
- Know what is BA vs BI: [[_BI vs BA - What is]]
- What is Metabase and why we choose Metabase: [[Metabase BI - _Choosing Metabase]]

Required technical specs
- Have either Docker daemon or Docker Desktop installed
- Have postgresQL

Additional Reading - What Metabase can do: [[Metabase BI - _Choosing Metabase]]

## I. Installation

### Install on Non-Mac or Non ARM64 chip

#### A. If Desktop GUI
Clone git into a local folder then follow instructions on the Readme (yarn install, etc):
https://github.com/metabase/metabase

For Production, you want to config the Metabase container to use another database besides H2 (which lacks concurrency and is more for development phase):
https://www.metabase.com/docs/latest/installation-and-operation/configuring-application-database

#### B. If Server (Eg. Debian 12)

Run:
```
docker pull metabase/metabase:latest
```

You would normally follow rest of instructions here:
https://www.metabase.com/docs/latest/installation-and-operation/running-metabase-on-docker
BUT... you should instead follow my directions because we will not only use `docker run` like the official instructions, but we will transition from a successful `docker run` to copying the docker run options into a Docker Compose yml file, so that your server running metabase is more maintainable - Go to section:  **Docker directly without a persistent Metabase app config database**

### Install on Mac or ARM64 chip

You usually download and install Metabase. However if you're on a Mac M1/M2/etc or any device on an ARM64 chip, it becomes a bit problematic showing the warning:
```
_WARNING: The requested image's platform (linux/amd64) does not match the detected host platform (linux/arm64/v8) and no specific platform was requested_
```

Someone has packaged the JAR file into a Docker image that runs well on ARM64-based architecture:

https://github.com/StephaneTurquay/metabase-arm64-docker

---

`Continued from any of the above OS:`
## II. Make sure Docker Daemon is running

#### Docker Daemon
1. Make sure your terminal is in the same folder where you had cloned metabase-arm64-docker or where we will write the docker-compose.yml file

2. Run Docker daemon
- Either having installed and run Docker daemon
- Or having installed and run Docker Desktop (GUI for Docker).
  
  Not doing so will cause this error when running most any Docker commands:
  Cannot connect to the Docker daemon at [unix:///Users/wengffung/.docker/run/docker.sock.](unix:///Users/wengffung/.docker/run/docker.sock.) Is the docker daemon running?


---

### III. Test directly with Docker without a persistent Metabase app config database
3. Run docker directly (do not run the docker-compose.yml yet because we want to figure out the correct options by running options in the docker cli directly, since it gives the errors right away) - Please adjust the image name if not arm64:
	```
	docker run \
	-p 3500:3000 \
	-e MB_JETTY_PORT=3000 \
	stephaneturquay/metabase-arm64:latest
	```
	OR:
	```
	docker run \
	-p 3500:3000 \
	-e MB_JETTY_PORT=3000 \
	metabase/metabase:latest
	```
	^ Notice that `-d` is not part of the cli which is usually included in docker cli's. Without the -d, it's no longer in daemon or detached mode, meaning errors can show up right away, and we want to see any errors.
	
	 *WAIT* If you're doing server Debian 12, for example, and it's not
	
	 We are testing with port 3500, but it could've easily been `-p 3000:3000`. I don't recommend using 3000 as a practice because 3000 is a common port for NodeJS apps, so I like to have a range that's way off for BI tools. You may want to google what are good port numbers that services don't use, including services on your computer/server, and services you may potentially use in the future.
	
	If you get an error like:
	`docker: invalid reference format.
	`See 'docker run --help'.`
	`zsh: command not found: -p`
	Then make sure there's no space after `\`.
	
	You'll see this red warning which is OK because we haven't linked PostgresQL to Metabase as the database to persist its configuration and user profiles: "WARNING: Using Metabase with an H2 application database is not recommended for production deployments..."

4. Visit http://localhost:3500/ which will ask you to setup Metabase. The wizard includes connecting to your desired database.
   
5. STOP! You may choose to connect your database, but your work will be wiped out the next time Metabase restarts. This is because it's using H2 database and the purpose is for you to explore Metabase. Now that we know we can run Metabase, let's run Metabase with a persistent database on your computer.

### IV. Test directly with Docker WITH a persistent Metabase app config database

Metabase to store its application data in PostgreSQL, so all settings, dashboards, and other configurations will be remembered as long as the PostgreSQL data volume is intact.

Decide if you want to use the PostgreSQL that's on your host machine, or you do not want to install PostgreSQL (or prefer not to affect your host machine's PostgreSQL); in that case, you could run a PostgreSQL container before running the Metabase container, and you mount PostgreSQL to a folder on your host machine so that the PostgreSQL container's databases are stored there as files.

From personal experience, I recommend using the Postgres on your host machine because it's easier to debug from the same place you use Postgres. If you do not have Postgres, I still recommend you install it.

#### Approach A: Postgres that's locally installed on host machine
1. Now we will adjust the docker cli command to take in your postgres. Note if you DO NOT have postgres, you may want to install postgres at [[PostgreSQL - _PRIMER]] (recommended) or use the Docker container postgres while mounting its persistent data to a folder (NOT recommended).
   
   Go into PostgresSQL shell and prepare the database:
	   - Create the database metabaseappdb which our command will choose as the database for Metabase to store its configuration and user profiles. Hint: `CREATE DATABASE metabaseappdb;`. 
	   - Create the username and password you'll be using in the command options for docker run with postgres. There are instructions on creating accounts at [[PostgreSQL - Create Database Account]]
   
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

	The `host.docker.internal` is a special DNS name provided by Docker Desktop to allow containers to communicate with the host machine. This name is:
	- **Supported only by Docker Desktop** on macOS, Windows, and Linux.
	- **Not available on native Linux installs of Docker Engine** (without Docker Desktop). In such cases, you'll need to use the host network's specific IP addresses to connect to services on the host.

	 If using `host.docker.internal`, test if a Docker containerized mini OS alpine can ping that variable's IP
	```
	docker run --rm alpine ping -c 4 host.docker.internal
	```

	^ If fails, then just find the host IP address of the host machine directly and use that IP address instead:
	```
	hostname -I | awk '{print $1}'
	```
		
	Regardless if you chose `host.docker.internal`, later we will rewrite the Docker CLI command into a docker-compose.yml file for portability and we'll have to use the host IP because it'll be on the remote server which doesn't support Docker Desktop or Docker Desktop's `host.docker.internal`.

	Run the command with the DB_HOST you decided/discovered.

	See if there is any problems connecting because of the database credentials or the host machine IP address.

	- The error about not having the correct host machine IP address or not being able to connect to it looks like:
	```
	Caused by: org.postgresql.util.PSQLException: Connection to 127.0.0.1:5432 refused. Check that the hostname and port are correct and that the postmaster is accepting TCP/IP connections.
	```

	This area of the output could review database problems:
	```
	metabase-1  | 2024-10-28 09:11:46,110 INFO metabase.core :: Setting up and migrating Metabase DB. Please sit tight, this may take a minute...  
	metabase-1  | 2024-10-28 09:11:46,115 INFO db.setup :: Verifying postgres Database Connection ...
	```

	If there are errors, look into whether your database username and password exists, if the database connection information are correct, etc.
	
	LASTLY: Visit http://localhost:3500 if locally, or http://IP:3500 if remote server. Test that you see setup screen! We may skip setup screen for now.

#### Approach B: Postgres in a Dependent Image/Container
1. Or you may want to run the postgres container. In that case you can work with the Docker compose yml file directly, uncommenting all the lines:
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
- But notice that PostgreSQL is using a named volume (`postgres-data`), so that all data, including the Metabase configuration saved to the database, will persist across container restarts. However, Docker does not automatically create that folder path `/var/lib/postgresql/data` that mounts to `postgres-data:` (a consistent uri folder path that the postgres container can use). 
- Make sure to create the folder path along `/var/lib/postgresql/data` and you'll likely have to create it with the sudo command because `/var/` requires superadmin or root: `sudo mkdir -p /var/lib/postgresql/data`. 
	- Explanation of why mounting is needed: The PostgresQL container, like all Docker containers, is ephemeral meaning the data does not persist and what it remembers resets when the container restarts, but by having data stored in a host machine's folder by mounting a path to  `postgres-data:` volume,  the data can persist across container restarts. For future cleanup or migration, you can remove the volume to have the data erased: (`docker volume rm postgres-data`).
- Go to next section where we work with the Docker Compose file.

---

### VI. Adjust the docker compose file

Now we work on the docker compose file more directly. 

The goal is you have the correct options that successfully makes metabase available on your web browser AND persistently saves your Metabase configuration and user profiles VIA having been ran with the docker compose file, regardless if we chose to use a postgresql container or to have a locally installed postgresql as the database of Metabase. We will now disregard directly running `docker run` commands because that's not sustainable in the long run. With a docker-compose.yml file, it's better for automation, CI/CD, DevOps, etc.

##### **Approach A:** Docker Compose file if running local postgresql

You may ask ChatGPT: `How to make this command into a docker compose file?` and in the same prompt, paste the command that successfully ran Metabase in your webbrowser and persist with PostgresQL (whether it's your local machine's PostgresQL or the dependency image's PostgresQL)

Your compose-docker.yml could look like:
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

Note your options may differ depending on the above discussed (like host.docker.internal or your production IP address) (like your DB username and password) (like the host machine post you want other than 3500). 

FYI: Jetty information at [[Metabase BI - Deep Dive - Java Parts]] and Jetty port is the same port as the container app, so leave it alone.

---
### **VII:** Docker Compose file if running container postgresql
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


---

`Continued from any of the above approaches to derive docker-compose.yml:`
### Run with Docker Compose

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

Visit http://localhost:3500 or http://IP:3500 to see that Docker Compose with database successfully initiated Metabase that you can open in the web browser 

---

## Configure Metabase

Docker now able to run Metabase successfuly. Now we will configure Metabase itself so it can connect to our data and visualize the data to interested team members/strategists/stakeholders/investors. Metabase's GUI runs in the web browser.

Firstly, you may want to switch `docker compose` from foreground mode into detached/daemon mode because that is how it is when you move it to the server so that you don't have to supervise the terminal on your computer to keep the service alive for the business partners/team members to open the web portal.

Here's how - Shutdown the compose's container then put it back up with detached mode flag:

```
docker compose down
docker compose up metabase -d
```

Visit your http://localhost:3500 or http://IP:3500 if not on there yet.

Setup your account and connect your database
![](x6QRZ8V.png)

^ If MongoDB: I recommend connecting to MongoDB on a remote server that's opened to internet requests (not blocked by firewall like iptables or ufw). Connecting to a MongoDB locally takes some tweaking.
![](3qPbFI0.png)

**Or** you can click “Paste connection string” and paste, eg
```
mongodb://MYUSER:MYPASSWORD!@IP:27017/DB_NAME?authSource=admin&directConnection=true
```

Once successfully setup, you could go offline (`docker compose down`) and go back online (`docker compose up -d`)  and see that it won't ask you to connect to your database for BI viewing again. This means your postgresql (whether it's a local postgresql or an image postgresql persisting to a mounted volume path) is successfully persisting the Metabase configuration and user profiles.

---

## Migrate to Production Server

Likely you planned to install Metabase on your computer to see if it works before installing on production remote server. If you got Metabase to work on production remote server, you can skip this section. This section adds instructions to the above so that Metabase can be installed on a remote machine as well.

### Root to port 3500 or https subpath?

Free Metabase: You're limited to http://domain.tld:3500. Subpaths not allowed
Pro or Enterprise Metabase: You can use http://domain.tld:3500 OR https://domain.tld/subpath

On free version if you try to do subpaths by having reverse proxy from a subpath to domain.tld:3500, Metabase on the web browser will fail because the static files will be 404'd. On the paid or enterprise version, you can set the subpath so that this won't happen. Therefore, the free version limits you in this way.

Refer to appropriate migration guide:
- [[Metabase BI - Migrate local dev to remote root path]]
- Or [[Metabase BI - Migrate local dev to remote subpath]]
