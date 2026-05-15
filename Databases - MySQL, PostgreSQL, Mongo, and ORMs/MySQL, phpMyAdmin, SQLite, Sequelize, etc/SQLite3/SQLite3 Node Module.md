SQLite3 has a node module so that your Express API app can interface with the database, to query it, and to get records from it.

Instructions
1. Install sqlite3 as a npm package. If it fails to install, refer to Troubleshooting lesson.
2. Require sqlite3 at the top but make it verbose mode. You can think that verbose() method returns the sqlite3 object too.
```
const sqlite3 = require("sqlite3").verbose();
```

3. Create a new database connection to the .db file:
```
const db = new sqlite3.Database("./db/election.db", err => {
    if (err) return console.error(err.message);
    console.log("Connected to database");
});
```

4.If you are using Express in the same file, make sure database instance is ready before Express listens, or else the Express routes will have no access to the database. As a mnemonic, think back to $.on("load":
```
db.on("open", () => {
    app.listen(3001, () => {
        console.log("Server running");
    })
})

```


5. Some basic queries are getting one row and getting all applicable rows.

5a. Get one row:
```
db.get(`SELECT * FROM candidates WHERE id = 1`, (err, row) => {
    if (err) console.error(err.message);
    console.log(row);
})
```

5b. Get multiple rows as applicable:
```
db.all(`SELECT * FROM candidates`, (err, rows) => {
    if (err) console.error(err.message);
    console.log(rows);
})
```