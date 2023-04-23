Notice the syntax for inserting multiple rows:
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