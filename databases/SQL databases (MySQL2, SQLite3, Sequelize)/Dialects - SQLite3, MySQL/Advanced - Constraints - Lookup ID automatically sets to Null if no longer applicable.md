Lookup ID automatically sets to Null if no longer applicable

In other words, you can have look up id's set to NULL if a looked up record is dropped. Here is the formal definition:
```
[CONSTRAINT [symbol]] FOREIGN KEY
    [index_name] (col_name, ...)
    REFERENCES tbl_name (col_name,...)
    [ON DELETE reference_option]
    [ON UPDATE reference_option]
```
