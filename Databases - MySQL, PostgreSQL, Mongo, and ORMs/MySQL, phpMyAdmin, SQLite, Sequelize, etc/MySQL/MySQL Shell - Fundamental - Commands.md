## At the terminal, the MySQL Shell is invoked with a simple command that indicates the username. Then you will be prompted to enter the MySQL password.
For the Window's terminal equivalent, you can Windows -> Run -> `cmd` to open the Command Prompt, or you can use Cygwin or Git Bash.
```
mysql -u root -p
```

The password is from when you installed MySQL and entered a password. If MySQL already came with your computer, the password is likely root or blank.


MySQL commands to load SQL statement files (__.sql files), show databases, show tables, etc:
```
source schema.sql;
source seeds.sql;
show databases;
show tables;
quit;
```

For all other table and record manipulations or viewing, you use SQL statements. SQL statements are not preceded with a period "." MySQL also enabled the SQL statements for creating and dropping database because that's not tied to a .db file (unlike in SQLite3, where you create a database with a SQLite3 command and delete the database by deleting its .db file).