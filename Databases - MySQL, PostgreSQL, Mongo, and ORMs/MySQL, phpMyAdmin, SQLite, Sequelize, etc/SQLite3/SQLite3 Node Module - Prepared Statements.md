Using ?, we are doing prepared statements which protects against SQL injections (hackers trying to insert code that breaks your SQL code flow and give them unauthorized access to your database).

Take note that question mark in first argument, followed with value in second argument. Because WHERE uses a key-value pair, the value can be an object with key-value property.
```
connection.query('SELECT * FROM posts WHERE ?', {title: 'test'}, function(err, result, fields) {
  if (err) throw err;

  console.log(result.insertId);
});
```

A value filling in the ? can also be a string in the second argument.
```
...?', "col1"...
```

Multiple ? will require an array in the second argument
```
... ?, ?, ?', ["col1","col2","col3"]...
```