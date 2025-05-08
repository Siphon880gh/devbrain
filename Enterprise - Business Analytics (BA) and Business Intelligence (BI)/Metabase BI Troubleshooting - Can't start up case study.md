
Webpage to Metabase login page shows:
```
{"via":[{"type":"clojure.lang.ExceptionInfo","message":"Connections could not be acquired from the underlying database!","data":{"toucan2/context-trace":[["resolve connection",{"toucan2.connection/connectable":"class metabase.db.connection.ApplicationDB"}],["resolve connection",{"toucan2.connection/connectable":"default"}],["resolve connection",{"toucan2.connection/connectable":null}],
```

So the underlying database may not be running. SSH with console to investigate.

If dockerized metabase, get the name of the container with:
- Note the `-a` includes docker containers that have been stopped
```
docker ps -a
```

Then see logs for that docker with:
```
docker logs <metabase_container_name>
```

If the logs revealed:
```
Caused by: org.postgresql.util.PSQLException: Connection to XXX.XX.XXX.XX:5432 refused. Check that the hostname and port are correct and that the postmaster is accepting TCP/IP connections.
```

Check if postgresql is running:
```
sudo systemctl status postgresql
```

If the status revealed:
```
● postgresql.service - PostgreSQL RDBMS Loaded: loaded (/lib/systemd/system/postgresql.service; enabled; preset: enabled) Active: active (exited) since Thu 2024-10-31 02:46:50 UTC; 6 months 5 days ago Process: 229365 ExecStart=/bin/true (code=exited, status=0/SUCCESS) Main PID: 229365 (code=exited, status=0/SUCCESS) CPU: 1ms
```

Then that status shows that **`postgresql.service` is _not actually running_**. It's marked as **"active (exited)"**, which means the service unit exists and was started, but **it didn't launch the actual PostgreSQL database server**.

Try to start the service with:
```
sudo systemctl start postgresql@15-main
```

If it fails and suggests to look into logs again, go ahead and look into logs because this time it logged the starting of the service:
```
sudo systemctl status postgresql
```

Said to look into `systemctl status postgresql@15-main.service`.

You did and it revealed:
```
ay 07 08:03:54 vps0 postgresql@15-main[3615339]: Error: /usr/lib/postgresql/15/bin/pg_ctl /usr/lib/postgresql/15/bin/pg_ctl start -D /var/lib/postgresql/15/main -l /var/log/postgres> May 07 08:03:54 vps0 postgresql@15-main[3615339]: 2025-05-07 08:03:54.626 UTC [3615344] FATAL: data directory "/var/lib/postgresql/15/main" has invalid permissions May 07 08:03:54 vps0 postgresql@15-main[3615339]: 2025-05-07 08:03:54.626 UTC [3615344] DETAIL: Permissions should be u=rwx (0700) or u=rwx,g=rx (0750). May 07 08:03:54 vps0 postgresql@15-main[3615339]: pg_ctl: could not start server May 07 08:03:54 vps0 postgresql@15-main[3615339]: Examine the log output. May 07 08:03:54 vps0 systemd[1]: postgresql@15-main.service: Can't open PID file /run/postgresql/15-main.pid (yet?) after start: No such file or directory
```

Says has "invalid permissions"! Your fix is:
```
sudo chown -R postgres:postgres /var/lib/postgresql/15/main  
sudo chmod 700 /var/lib/postgresql/15/main
```