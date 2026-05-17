
## Check upper/lower case

- Check if the username was created with case sensitivity (if surrounded by quotes) or automatically all lower case (no quotes).
- To view all users, get into the postgres shell:
	```bash
	sudo -u postgres psql
	```
	^ **`-u postgres`** tells `sudo` to switch to the **`postgres` system user** (instead of root)
- Check that the username is what you expected (because of the lowercase/uppercase nuance):
	```
	\du
	```
	^ Means display users


---

## Check Authentication Method

**Authentication config (`pg_hba.conf`)**

PostgreSQL authentication rules are controlled by `pg_hba.conf`. On Debian-based systems, the file is often located at:

```bash
/etc/postgresql/*/main/pg_hba.conf
```
^ Where * is the version number

A typical local password-auth rule looks like this:

```conf
host    all    all    127.0.0.1/32    scram-sha-256
```
^ The final column is the authentication column. It can have values like `peer`, `scram-sha-256`, `trust`, etc

After editing that file, reload PostgreSQL:

```bash
sudo systemctl reload postgresql
```

