This guide is for backing up **all MongoDB databases on your server** from the SSH terminal. Note this also works on your regular terminal for backing up your local MongoDB.

The guide includes **restoring the MongoDB databases on the newer server**.

MongoDB’s `mongodump` tool connects to `localhost:27017` by default, so if your local MongoDB is running on the normal port, you do **not** need a URI. MongoDB also states that if you do not specify `--db`, `mongodump` copies all databases in the instance into the dump files. ([MongoDB](https://www.mongodb.com/docs/database-tools/mongodump/ "mongodump - Database Tools - MongoDB Docs")). Our goal for this tutorial is to copy all databases. If you prefer to copy only specific databases, it's the other tutorial [[MongoDb Backup and Restore with CLI - Specific Databases]]

---

## 1. Confirm MongoDB is running locally

Open your terminal and run:

```bash
mongosh
```

Then check your databases:

```javascript
show dbs
```

^ Likely will complain about authentication. That's good. That proves you have authentication set up already. Then backtrack by exiting the shell and using this command instead to go into the mongosh: `mongosh -u root -p MONGO_PASSWORD`

Exit MongoDB shell:

```javascript
exit
```

---

## 2. Back up all local databases into a folder

Run this from your terminal, not inside `mongosh`:

```bash
mongodump --gzip --out ./dump
```
^ Note if it complains about authentication, you append to the command (at the end): `-u _USER_ -p _PASSWORD_` so it becomes: `mongodump --gzip --out ./dump -u _USER_ -p _PASSWORD_`

This creates a local folder like:

```text
dump/
  database1/
  database2/
  database3/
  someFile.json.gz
```

MongoDB’s directory dump format creates a root dump folder, then one subfolder per database. ([MongoDB](https://www.mongodb.com/docs/database-tools/mongodump/ "mongodump - Database Tools - MongoDB Docs"))

---

## 3. Transfer dump folder to other remote server

You should have a dump/ folder consisting of all your databases. Let's archive that for easy transfer:
```
tar -czf dump.tar.gz dump/
```

Using your preferred method, make sure you download `dump.tar.gz` so you can upload it to the new server.

When ready, upload `dump.tar.gz` to your new server with whatever methods (FTP, SFTP, scp, rsync, etc).

At the remote server, go ahead and unarchive the `dump.tar.gz` back into a `dump/` folder:
```
tar -xzf dump.tar.gz
```


---

## 4. Restore all local databases from the dump/ folder at the remote server

At the remote server you should also have the dump/ folder now. So it's not just the original server with that folder

Let's restore the database to your newer server's MongoDB, WITHOUT replacing your admin credentials:

```bash
mmongorestore --drop --gzip --nsExclude="admin.*" ./dump  -u '_USER_' -p '_PASSWORD_'
```

The `--drop` option drops matching collections before restoring them. It does **not** drop collections that are not in the backup. ([MongoDB](https://www.mongodb.com/docs/database-tools/mongorestore/ "mongorestore - Database Tools - MongoDB Docs")). The admin folder would exist too and dropping/restoring that would accidentally wipe your new remote server's MongoDB credentials and replace them with the old remote server's.

Notice the flag --nsExclude. That will make sure not to touch the admin folder.

However if somehow you didn't have the --nsExclude set to admin folders, then your MongoDB auth credentials are changed. You can decide to change the password back - refer to [[MongoDB Shell - Change Root Password]]
