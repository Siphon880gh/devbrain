You can also export the authenticated database connection in MySQL2 so that you can do queries everywhere in the app.

Db.js:
```
const mysql = require('mysql2');

module.exports = class Db {

    constructor() {
        this.conn = mysql.createConnection({

            host: 'localhost',

            port: 8889,

            // Your MySQL username
            user: 'root',

            // Your MySQL password
            password: 'root',

            database: 'employee_manager'

        });
    }
    getConnection() {
        return this.conn;
    }
}
```

Other files referencing the Db.js:
```
const Db = require("./config/Db.js")
const db = new Db();

const conn = db.getConnection();

conn.connect(err => {
    ...
    conn.query(...
    conn.end();
});
```
