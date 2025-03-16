Challenge:

Create “docker_tests” database in PostgreSQL with a table called “test”, and the first entry would be
- id
- my_key: “Hello world”

Note we are not using key for column because it’s a reserved keyword

Note the following is guide on using the GUI to create database, table, insert row. At anytime, you can choose to use pgAdmin4’s Query Tool to manually enter SQL queries. Refer to [[pgAdmin4 - Query Tool]]

Create table
![[Pasted image 20250315202757.png]]

Or Run this query:
```
CREATE TABLE test (  
    id SERIAL PRIMARY KEY,  
    my_key TEXT NOT NULL  
);  
INSERT INTO test (my_key) VALUES ('Hello world!');  
SELECT * from test;
```

Create table:  
Selected database → Schemas → Tables → Right click to create table:

A-
![[Pasted image 20250315203152.png]]

B-
![[Pasted image 20250315203204.png]]

C-
![[Pasted image 20250315203244.png]]

D-
![[Pasted image 20250315203252.png]]

E-
![[Pasted image 20250315203305.png]]

in **PostgreSQL**, the `SERIAL` data type is considered **auto-incrementing** because it automatically assigns a unique sequential integer value to the column.
![[Pasted image 20250315203315.png]]

![[Pasted image 20250315203404.png]]

Or you ran this Create Table query:
```
CREATE TABLE my_table (  
    id SERIAL PRIMARY KEY,  -- Auto-incrementing ID  
    my_key TEXT NOT NULL  
);
```

---

Now to insert rows:

Right click selected table → Scripts → Insert script
![[Pasted image 20250315203452.png]]

At the opened panel, it gets prefilled with a script. You fill in the “?”’s:
![[Pasted image 20250315203500.png]]

Actually you will skip id because that’s serial (aka auto-incrementing in normal MySQL)
![[Pasted image 20250315203509.png]]

Or you ran this Insert Into query
```
INSERT INTO public.test(  
	my_key)  
	VALUES ('Hello world');
```

---

See all rows:
Right click selected table → View/Edit Data → All Rows
![[Pasted image 20250315203532.png]]

  
Or you ran this
```
SELECT * FROM public.test;
```

Btw, to **cleanup**, you can drop the table like so:
![[Pasted image 20250315203552.png]]

