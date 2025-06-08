Replace the `$`variables with the appropriate database name or MongoDb connection URI, as appropriately.

Backup from online MongoDb (Eg. Atlas, VPS)
```
mongodump --uri "$MONGODB_URI" --gzip --out ./dump
```

Backup from local MongoDb (Eg. Compass)
```
mongodump --db $DB_NAME --out ./dump
```

---

Restore to local MongoDb
- Requires you have the backup at folder "dump/"
```
mongorestore --drop --gzip dump/
```

Restore to remote MongoDb
- Requires you have the backup at folder "dump/"
```
mongorestore --drop --uri "$MONGODB_URI" dump/
```

---

**Important Note on MongoDB URI for Backups and Restores**

When backing up **all databases** in MongoDB, your `MONGODB_URI` should **not** include a specific database name. This is different from how Mongoose typically connects, where the URI usually **does** specify the database name.

When restoring a `dump/` folder to a remote MongoDB instance, keep in mind that the folder already contains the database names as subdirectories. In this case, **do not include a database name in the URI**. The `mongorestore` tool expects to determine the target database(s) from the folder structure itself—each subfolder within `dump/` maps to a corresponding database.