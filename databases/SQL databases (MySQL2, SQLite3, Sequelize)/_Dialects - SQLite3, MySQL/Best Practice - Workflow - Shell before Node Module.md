# Best Practice - Workflow - Shell before Node Module
This applies to MySQL too, but you can quickly test Sqlite3 operations and SQL statements in the Sqlite3 shell before mentally translating that to code in Node JS.

First run sqlite shell so that all other commands are interpretted by sqlite3 until you quit the shell with `.quit`:
```
sqlite3
```

Remember that a SQL database is represented with a .db file. A database can have one or more tables. A table can have many rows aka records.

An analogy: Spreadsheet file is the database. A tab is the table. Each row with different data fields is a record. In a conventional Excel spreadsheet tab, there are headers. A SQL table also have headers that help you do conditional querying (for example, WHERE id=4).

Creating databases, going into a database, and viewing the tables of the database you selected - those use Sqlite3 commands. Dropping databases is not a Sqlite3 command because you can simply delete the .db file to drop a database.

Creating/dropping a table, updating a table's records, deleting a table's records, and inserting a record into the table, and finally, viewing record(s) - those are all SQL statements. Think back to CRUD. All CRUD operations are SQL statements. 

When you use SQLite3's flavor of SQL, it will not allow you to run SQL statements to create or drop databases, because a database is intimately tied to a db file. With MySQL, there is no .db file, so you can create and drop databases as SQL statements.

Another distinction is viewing when it related to tables: Sqlite3 operations show table names, but SQL statements show table's inside records.


SQLite operations are preceded with a period ".", and they include:
```
.open db/animals.db
.database
.tables
```

The above sqlite3 operations are for:
1. Open or create a database, then keep the database selected for doing SQL statements (Make sure the db folder exists because Sqlite3 will create the .db file at that path that Sqlite3 uses).
2. Verify database connection. It'd return the .db filepath.
3. Show all current tables at the selected database

All SQL statements are not preceded by a ".". Keywords are capitalized for readability purposes since capitalizing is not necessary.

To see all the records of a table, yon run a SQL statement:
```
SELECT * from Animals
```


To quit the sqlite3 shell, run quit:
```
quit
```
