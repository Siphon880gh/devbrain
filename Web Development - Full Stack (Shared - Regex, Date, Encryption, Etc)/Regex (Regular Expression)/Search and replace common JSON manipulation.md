
You are manipulating a JSON file that has an array of objects. Each object with identical keys.

Insert new property b_key after existing property a_key (Find and Substitute fields):
```
("a_key":.*)\n  
  
$1\n\t\t"b_key": "",\n
```

Move line up (Eg. Move the new b_key line to above a_key line) (Find and Substitute fields):
```
(.*\n)(.*"b_key".*\n)  
  
$2$1
```

If you rather had moved it up a few lines (Find and Substitute fields):
```
(.*\n.*\n.*\n)(.*"b_key".*\n)  
  
$2$1
```