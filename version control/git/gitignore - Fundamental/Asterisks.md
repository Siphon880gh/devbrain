
- An asterisk ( * ) means any number of characters (zero or more) in the filename.
- Two asterisks ( ** ) specify any number of subdirectories including forward slashes
- Two asterisk with forward slash `(**/)` is any paths to this folder or any paths after this folder
- A question mark ( ? ) replaces zero or one character

eg.
```
# profiles
**/Coming Soon/**
**/Private/**
**/Private**
```


The third one `**/Private**` deletes any folders like "Private - Joe" and "Private - John"