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