SQLite3 Shell is usually installed to test SQLite SQL statements in the terminal. There are SQLite commands that run in the SQLite Shell and those commands are preceded with a period ".":
```
.databases
.open db/animals.db
.tables
.quit
```

The above lets you view all databases, select/create a database, show tables, and quit the shell.

If unable to create the database, make sure the db folder exists. Having a db folder to house all SQL statement files and .db files is a convention.

SQLite3 Shell commands to make records display prettier:
```
.headers on
.mode column
```

Other SQLite3 Shell commands include:
```
.database
.schema
.table
```

For all other table and record manipulations, you use SQL statements. You also use SQL statements to query for records. SQLite3 SQL statements are similar to MySQL SQL statements with some differences; Refer to SQL statements lesson to see the differences.