# Advanced - Create table from an older table

You can create a table from an old table by combining create and select:
```
CREATE TABLE new_table_name AS
    SELECT column1, column2,...
    FROM existing_table_name
    WHERE ....;
```

The following SQL creates a new table called "TestTables" (which is a copy of the "Customers" table)

CREATE TABLE TestTable AS
SELECT customername, contactname
FROM customers;