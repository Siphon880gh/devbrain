Refer to the lesson on "Best Practice - Migrating with Schema and Seeds" for the concepts.

MySQL and SQLite3 have differences.

MySQL schema.sql:
The difference here is that you have to manage the database dropping and creation with SQL statements as part of the schema.sql SQL statements file. The other difference is the CREATE TABLE query, especially where id is concerned. The id has AUTO_INCREMENT key. There is a PRIMARY KEY(id) as the last item.
```
DROP DATABASE IF EXISTS books_db;
CREATE DATABASE books_db;
USE books_db;

CREATE TABLE authors (
    id INTEGER NOT NULL,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);

CREATE TABLE books (
    id INTEGER AUTO_INCREMENT NOT NULL,
    authorId int NOT NULL,
    title VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);
```

MySQL seeds.sql:
```
INSERT INTO authors (id, firstName, lastName)
VALUES ( 1, "Jane", "Austen"),
 ( 2, "Mark", "Twain"),
 ( 3, "Lewis", "Carroll"),
 ( 4, "Andre", "Asselin");

INSERT INTO books (authorId, title)
VALUES ( 1, "Pride and Prejudice"),
 ( 1, "Emma"),
 ( 2, "The Adventures of Tom Sawyer"),
 ( 2, "Adventures of Huckleberry Finn"),
 ( 3, "Alice''s Adventures in Wonderland"),
 ( 4, "Dracula");
 ```

Run these MySQL Shell commands:
```
mysql -u root -p
source schema.sql
source seeds.sql
```