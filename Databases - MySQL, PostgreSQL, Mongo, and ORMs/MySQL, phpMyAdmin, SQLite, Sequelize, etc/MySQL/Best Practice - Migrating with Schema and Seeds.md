# Best Practice - Migrating with Schema and Seeds

Migration: When you're restoring a database to a previous backup, resetting the database (so it has no data but keeps the same table structure), or you are moving to another server. SQL database migration follows a schema.sql and seeds.sql convention.

Schema (schema.sql)
When you migrate to another server, you want to just load some CREATE TABLE queries to recreate your database table structures

Seeds (seeds.sql)
Then you want to repopulate the tables by running INSERT queries on those tables. You are spreading the seeds into the tables to repopulate them.

You can have text files of those CREATE TABLE sql statements and INSERT INTO sql statements for when you change server and have to copy over the database, but that's not best practice because the workflow is messy. You can import/export an entire database but that's not best practice either because what if you decide to start the database with the same structure but with fresh data?

Here are the instructions on how to load SQL statement files for schema and seeds. SQLite3 and MySQL have similar migration steps, but there are nuances. Those nuances brielf are:
- SQLite3 does not use SQL statements to create/drop databases 
- SQL statements are slightly different between MySQL and SQLite 3(especially INSERT INTO queries).
- SQLite3 Shell commands are different than MySQL Shell commands.

Remember __.db files is what sqlite3 uses. In comes __.sql files. These files can store SQL statements that can be ran.

To run the command sqlite3 on a .db file and take the SQL statements from the .sql file, the format follows:
```
"migrate": "sqlite3 db/election.db < db/schema.sql",
"seed": "sqlite3 db/election.db < db/seeds.sql",
"db": "sqlite3 db/election.db"
```

Notice the commands are placed as package.json scripts. When you migrate to a new server, you can create the database (make sure db folder is in place), migrate the table structure, and seed the data with:
```
npm run db; npm run migrate; npm run seed;
```

For more information how the "<" operator works by running the SQL statement contents of the SQL file on the right onto the command on the left which selects the database, read up on the lesson on Redirection.