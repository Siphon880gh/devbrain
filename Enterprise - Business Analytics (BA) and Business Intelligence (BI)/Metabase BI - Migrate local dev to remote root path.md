Migrating to remote:
- Likely you planned to install Metabase on your computer (aka local dev) to see if it works before installing on production remote server. This section adds instructions to the local development installation instructions at [[Metabase BI - _PRIMER]] because the instructions are essentially the same but remote server setup is a bit more complicated.

What is remote subpath:
- http://domain.tdl:3500 to access Metabase web portal

Requirement:
-  This guide assumes you have a working local copy and therefore a working docker-compose.yml because you will be making changes to the working yml copy then migrating the file over to the remote server. In addition, you'll perform other checks and changes to postgres and docker to make a Containerized Metabase work over the internet.

---

### Server
- Make sure server has postgres and docker installed
	- Setup if needed: [[PostgreSQL - _PRIMER]]
	- Setup if needed: [[Docker - __PRIMER Concept]]

#### PostgresQL
Compared to local environment, there are additional considerations to make PostgresQL work with Metabase in a public way (business partners being able to visit the web portal).

1. Make sure postgres has the `root`/`root` user and password, and it has the database created `metabaseappdb`.
2. Make sure postgres can listen to incoming internet connections:
	- Find the line for `listen_addresses` and ensure it’s set to accept external connections:
	```
	listen_addresses = '*'
	```

	- Restart postgreSQL to apply the changes:
	```
	sudo service postgresql restart
	```

3. Make sure postgres shell works when you run `psql postgres` for compatibility with Metabase container, otherwise you have to disable peer and switch it to md4 or trust
	
	- Edit the postgresql authentication config file (Get the exact version folder by running `ls /etc/postgresql/`):
	```
	vi /etc/postgresql/<version>/main/pg_hba.conf
	```
	
	- Change the peer authentication method or add an entry either to:
		- Allow connections from your IP for user root on the database root. For example:
		```
		host    root    root    208.76.249.75/32    md5
		```
		- Or allow all databases and users from any host:
		```
		host    all     all     0.0.0.0/0          md5
		```
		^ Note using 0.0.0.0/0 is less secure as it opens access to all IPs. Consider limiting it to specific IPs if possible.
	
		- Restart postgres service to apply the changes:
		```
		sudo service postgresql restart
		```


#### Docker Compose
Compared to local environment, there are additional considerations to make Docker Compose work with Metabase in a public way (business partners being able to visit the web portal).

1. Adjust your docker-compose.yml file so that there is no "host.docker.internal". You would replace it with the host machine's IP address. If need to find the host machine's IP address, run in terminal: `hostname -I | awk '{print $1}'`
	- You can test that Docker containers can connect to your Postgres via the host machine IP address: `psql -h <IP> -U root -d postgres` and if you want to test by interactively entering your passWord `psql -h <IP> -U root -d postgres -W`.
	- Why we can't use 127.0.0.1 when Metabase and Postgres is on the same host machine? When Metabase runs on a container from PostgreSQL, `127.0.0.1` would refer to the Metabase server/container itself rather than the host machine that the PostgreSQL server is on.
2. Likely you're going to adjust docker-compose.yml's main image if you used the ARM64 version of metabase because servers are usually not on ARM 64 chip architecture. You can use the official metabase `metabase/metabase:latest`. If the latest tag has problems, you can go to an older one (The last one that worked that I've tested was v0.50.31 on Oct 31, 2024. On how to select tags of the image: [[Docker Images - Tags]]).
3. Make sure the docker-compose.yml has restart always on and as long as docker will start when the server restarts or crashes, it'll do its best to make sure your container(s) are always on:
```
restart: always
``` 

#### Port Access
- Run `docker-compose.yml` using `docker composer up` command initially to see errors. Foreshadow: When you're ready, you can shutdown composer then run the docker in detached mode so that your terminal can close without closing down Metabase.
- See if you can access Metabase at port 3500 in the **same network**:
```
curl https://127.0.0.1:3500
```
- Let's make Metabase at port 3500 available to the **internet's network** so anyone can open the Metabase web portal in a web browser.
	- Find out your server's firewall architecture, whether it's iptables, nftables, ufw, firewalld. Refer to:
		- [[Check if server is protected by iptables or nftables as the underlying firewall]]
		- [[Check if server firewall is made easier with ufw or firewalld]]
	- Then depending on your firewall architecture, use the appropriate command to enable port 3500 to the internet:
		- [[UFW - Enable specific ports]]
		- [[IPTables - Enable specific ports]]
		- [[firewalld - Enable specific ports]]

---

Your docker-compose.yml's may look like this:
Local development on Mac M1:
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

Then the remote docker-compose.yml:
```
version: '3.8'  
  
services:  
  metabase:  
    image: metabase/metabase:latest  
    ports:  
      - "3500:3000"  
    environment:  
      MB_JETTY_PORT: 3000  
      MB_DB_TYPE: postgres  
      MB_DB_DBNAME: metabaseappdb  
      MB_DB_PORT: 5432  
      MB_DB_USER: root  
      MB_DB_PASS: root  
      MB_DB_HOST: 111.22.333.44  
    restart: always
```

---

Visiting the root path http://domain.tld:3500 will give this warning. Just click "Continue to site"
![](https://i.imgur.com/U3U0qFy.png)

Now you can work on creating reports for your cofounders/founders/strategists/investors that they can see live and won't accidentally modify your database.
