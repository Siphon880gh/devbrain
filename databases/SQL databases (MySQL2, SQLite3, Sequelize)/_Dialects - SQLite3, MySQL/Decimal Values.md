
To insert a decimal in MySQL, you can use the following syntax:
```
INSERT INTO table_name (column_name) VALUES (decimal_value);
```

Where:
`table_name` is the name of the table that you want to insert the decimal value into.
`column_name` is the name of the column that you want to insert the decimal value into.
`decimal_value` is the decimal value that you want to insert.

For example, the following query would insert the decimal value 123.45 into the `price` column of the `products` table:

```
INSERT INTO products (price) VALUES (123.45); 
```

You can also use the `DECIMAL()` function to insert a decimal value into MySQL. The syntax for the `DECIMAL()` function is:
```
DECIMAL(M,D) 
```

Where:
`M` is the precision, which is the maximum number of digits that can be stored in the value.
`D` is the scale, which is the number of digits that can be stored after the decimal point.

For example, the following query would insert the decimal value 123.45 into the `price` column of the `products` table:

```
INSERT INTO products (price) VALUES (DECIMAL(5,2)); 
```

The `DECIMAL()` function can be used to insert decimal values into any column that is defined as a `DECIMAL` data type.