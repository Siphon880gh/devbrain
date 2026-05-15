## Overview of differences

Give your app the ability to persist data and query data. A common application is user creation and management. The database can store users and passwords (Sidenote: encrypted passwords so the admin cannot snoop on people's passwords and then maliciously use the password at common websites like Google and Facebook).

There are different types of databases. Basically there are SQL and noSQL databases. For this lesson we are doing SQL databases. This means there are tables that can be connected by similar fields. A table has different rows called records that can represent different entities of information (For example, a Table Users has a record representing one user). If you are going for NoSQL database, that is outside the scope of this lesson. 

An analogy: Spreadsheet file is the database. A tab is the table. Each row with different data fields is a record. In a conventional Excel spreadsheet tab, there are headers. A SQL table also have headers that help you do conditional querying (for example, you have an id column, so you can filter and return your record with: WHERE id=4).

Even with SQL databases, there are different flavors. For this lesson we are doing SQLite3 and MySQL. They are similar to each other and your skills are transferable between the two. But some SQL statements have slight differences.

As for the architecture, a SQLite3 database is represented with a .db file. On the other hand, MySQL does not have database files. MySQL runs as a background process that listens at a port like a server. So MySQL listens for server requests and responds with records as a server response. In real life, a client requests for information to your Express API server, then your Express API requests your MySQL database. The MySQL database responds with records. Then your Express API can return a response from your server to the client as json text.

SQLite3 and MySQL have different tools. SQLite3 has a shell that you can invoke in the terminal so you can test SQLite3 flavored SQL statements and also SQLite3 commands that facilitate database management. MySQL also has such a shell. 

SQLite3 and MySQL both have node modules so that your Express API app can interface with the database, to query it, and to get records from it.

## Some technical differences

Here are some differences between SQLite3 and MySQL at a technical level. in SQLite3, you don't create or drop databases with SQL statements. Instead you delete a database by deleting the .db file; and for creating a database, you run the SQLite3 Shell command `.open db/<filename>.db` in the SQLite3 Shell but make sure the folder "db" exists.

But in MySQL, no such architecture exists. There is no .db file for you to delete the database, and there is no extra MySQL Shell command to create databases. So you create or drop databases with SQL statements which is usually how SQL databases are managed (SQLite3 is the exception and not the norm). For this reason, the MySQL schema.sql has more SQL statements than the SQLite3 schema.sql, because you have to check if a database exists, then drop the database if it exists, and then create the database, all in SQL statements at the top of the file. Refer to MySQL Migration lesson.

You'd choose MySQL for bigger projects. Those projects would need a whole MySQL server running as a background process at a specific port (most web hosting services have this by default). When you connect to MySQL on your app, it's actually connecting locally on that server to the MySQL port. 

Use SQLite3 for smaller projects or for repositories. The .db file convention makes it easy to migrate databases.

Both MySQL and SQLite3 databases can migrate using the conventional schema.sql (Create Table queries) and seeds.sql (Insert Into queries). Remember that MySQL schema.sql has extra SQL statements at the top regarding detection of database, dropping it, and creating a fresh database.