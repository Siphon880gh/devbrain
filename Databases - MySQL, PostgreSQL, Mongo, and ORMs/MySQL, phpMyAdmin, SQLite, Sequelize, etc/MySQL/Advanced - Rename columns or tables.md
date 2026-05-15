You can rename columns and tables with AS:
``
SELECT id AS IdentificationNumber FROM employees as Workers
``

Renaming the above table may not seem useful because the records don't change, but when you are joining tables, it's useful when you can just reference the new table name:
```
SELECT A.id, A.name, B.*,
FROM LongTableName AS A 
JOIN LongTableName2 AS B 
ON A.X = B.Y;
```