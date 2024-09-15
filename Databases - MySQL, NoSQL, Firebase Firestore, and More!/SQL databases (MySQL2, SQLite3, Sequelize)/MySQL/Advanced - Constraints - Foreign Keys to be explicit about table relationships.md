Probably useless. You can connect lookup id's to other table's id to make the SQL database aware of the relationships. This does not automatically replace lookup id with another column from the other table. In phpMyAdmin, it does make it easier for other developers to conceptulize your table relationships because when browsing a table, its lookup id's become links that will query for the relevant record in the other table when clicked:

Here is the formal definition:
```
ALTER TABLE table_name
    ADD CONSTRAINT fk_foreign_key_name
    FOREIGN KEY (foreign_key_name)
    REFERENCES target_table(target_key_name);
```

An example:
```
ALTER TABLE employee
    ADD CONSTRAINT fk_foreign_key_name
    FOREIGN KEY (role_id)
    REFERENCES role(id);
```