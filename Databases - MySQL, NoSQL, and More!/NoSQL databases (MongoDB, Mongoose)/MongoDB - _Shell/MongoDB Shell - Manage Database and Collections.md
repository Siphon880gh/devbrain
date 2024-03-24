**Show All Databases**: `show dbs`

This command lists all databases on the MongoDB server you're connected to. Each database is a separate set of data, isolated from other databases.

**Show Current Database**: `db`
This command returns the name of the database you're currently using. In MongoDB, when you start the shell, you are automatically connected to a default database, usually test. You can change the current database using the use \<database name\> command.

**Create Or Switch Database**: `use acme`
This command switches the context to the specified database. If the database does not exist, MongoDB doesn't create it at this stage; it will be created as soon as you store data in it, for instance, by creating a collection.

**Drop**: `db.dropDatabase()`
This command deletes the current database, removing all data stored in it, along with any associated collections and indexes. It's a destructive operation and cannot be undone, so it must be used with caution.

**Create Collection**: `db.createCollection('posts')`
This command creates a new collection named 'posts' in the current database. Collections are like tables in relational databases and are used to store documents, which are the equivalent of records or rows in a SQL database.
Show Collections: show collections

This command lists all collections in the current database. It gives you an overview of the different types of data you have stored in the database.

Remember, when using these commands, especially ones that modify data like db.dropDatabase(), it's important to be sure you're operating on the correct database or collection to prevent accidental data loss.