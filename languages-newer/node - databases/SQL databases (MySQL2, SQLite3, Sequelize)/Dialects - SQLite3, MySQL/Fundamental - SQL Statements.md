# Fundamental - SQL Statements
You can run SQL statements in the MySQL/SQLite3 shell, or they can be coded with the MySQL/SQLite3 node modules in your Express API app, or you can have them in SQL statement files like schema.sql, seeds.sql, run_queries.sql, etc.

Create a table with SQLite3:
```
CREATE TABLE persons (
    id INTEGER PRIMARY KEY,
    firstName varchar(255) NOT NULL,
    lastName varchar(255) NOT NULL,
);
```

Or create a table with MySQL:
```
CREATE TABLE persons (
    id INTEGER NOT NULL,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);
```

Notice `NOT NULL` vs `NULL` distinction. NOT NULL, as in the LastName being UNNULLABLE makes it so that if the client sends a request with no  lastname parameter, it'd throw an error.

NULL, as in the city being NULLABLE, allows that information to be missing in the request. It'd not throw an error

Insert record
```
INSERT INTO table_name
VALUES (value1, value2, value3);
```

Insert multiple records.
You can insert multiple records to the same table:

```
INSERT INTO table_name
VALUES (value1, value2, value3);
VALUES (value1, value2, value3);
```

View record(s)

```
SELECT * FROM Persons WHERE Zip>93100 AND Zip<93200
```

View record(s) with some columns

```
SELECT LastName, FirstName FROM Persons
```

WHERE rules. 
- Worth noting: <> means not, = means is.
- Wildcard searches uses a LIKE operator and a % for the wildcard symbol.
- Instead of multiple OR, you can check if the value matches any in an array
```
WHERE Zip<>9300
WHERE isEmployerReady=1 OR isEmployerCompetitive=1
WHERE LastName LIKE "A%"
WHERE City IN ('Paris','London');
```

WHERE Range rules
For ranges, you can use compound AND with the comparison operators, or the more readable BETWEEN operator
```
WHERE Zip>93100 AND Zip<93200
WHERE Zip>=93100 AND Zip<=93200
WHERE Zip BETWEEN 93100 AND 32000

## Sorting
Default is ASCending order. (Top is A, bottom is D, if alphabets)
For DESCending order (Top is D, bottom is A, if alphabets), add to very end of your SQL query:
```
.. DESC;
```

Sort by another column. If you don't have a primary key assigned to the table or would like to sort with another column instead:
```
ORDER BY otherColumn
```

## Commenting
```
-- This table holds first names and last names of persons
CREATE TABLE persons (
    id INTEGER NOT NULL,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);
```