
If you're going to seed with MongoDB Shell (instead of running a NodeJS script using either MongoDB native driver or Mongoose ORM), you could write in bash scripts.

Keep in mind this is ok for a quick and dirty way of seeding, but if your seeds is complicated, you would have an easier time coding it in NodeJS/Python/etc even though that requires a bit more setup:

---


Yes, you can write a Bash script to drop a MongoDB database, recreate it, and insert seed data using the MongoDB shell. Here's a general structure of how you can achieve this:

```bash
#!/bin/bash

# Define variables
MONGO_HOST="localhost"
MONGO_PORT="27017"
MONGO_DB="your_database_name"

# Drop the database
mongo --host $MONGO_HOST --port $MONGO_PORT $MONGO_DB --eval "db.dropDatabase()"

# Create the database by simply using it
# MongoDB creates databases and collections automatically when you first store data in them.

# Insert seed data
# You can either insert data directly via the shell or use a JavaScript file.

# Example: Inserting directly
mongo --host $MONGO_HOST --port $MONGO_PORT $MONGO_DB --eval 'db.your_collection_name.insert({"key": "value"})'

# Example: Using a JavaScript file
# Suppose you have a file `seed.js` with MongoDB commands to insert data
mongo --host $MONGO_HOST --port $MONGO_PORT $MONGO_DB < seed.js
```

In this script:

1. **Dropping the database**: The `db.dropDatabase()` command is used to drop the specified database.
2. **Creating the database**: MongoDB doesn't require you to create a database explicitly. It gets created automatically when you insert some data into it.
3. **Inserting data**: You can insert data directly by using the `--eval` option with a MongoDB insert command. Alternatively, you can write your MongoDB commands in a JavaScript file and execute it using the MongoDB shell.

For the `seed.js` file, it could look something like this:

```javascript
// seed.js
db.your_collection_name.insertMany([
    { "name": "John Doe", "age": 30 },
    { "name": "Jane Doe", "age": 25 }
]);
```

Make sure to replace `your_database_name`, `your_collection_name`, and the insert data with your actual database and collection names and data you want to seed.

Before running the script, make sure you have the necessary permissions and MongoDB is running. Also, ensure that the user executing the script has the appropriate permissions to drop and create databases and insert data.

---

For more information on seeding, in particular the inserting queries, refer to: [[MongoDB Shell - Insert or seeding]]