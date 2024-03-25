
Reminder: MongoDB native driver for NodeJS is a wrapper that does not enforce schemas (unlike Mongoose), and has less abstractions, but the drawback is the lack of validation

To install the native MongoDB Node.js driver and use it in your NodeJS project, follow these steps:

### Installation

1. **Initialize a Node.js Project (if you haven't already)**: If you're starting a new project, create a new directory for your project and initialize it with npm:

   ```bash
   mkdir myproject
   cd myproject
   npm init -y
   ```

   This command creates a `package.json` file in your project directory, which will track your project's dependencies.

2. **Install MongoDB Node.js Driver**: Run the following command in your project directory to install the MongoDB driver:

   ```bash
   npm install mongodb
   ```

   This command installs the MongoDB driver and adds it as a dependency in your `package.json` file.

### Usage

Here's a basic example of how to use the MongoDB Node.js driver to connect to your MongoDB database, insert a document, and fetch documents:

1. **Create a JavaScript file**: For example, `app.js`.

2. **Use the MongoDB Driver**: Add the following code to `app.js`:

   ```javascript
   const { MongoClient } = require('mongodb');

   // Connection URL
   const url = 'mongodb://localhost:27017';
   const client = new MongoClient(url);

   // Database Name
   const dbName = 'myproject';

   async function main() {
     // Use connect method to connect to the server
     await client.connect();
     console.log('Connected successfully to server');
     const db = client.db(dbName);
     const collection = db.collection('documents');

     // Insert a document
     const insertResult = await collection.insertOne({a: 1});
     console.log('Inserted document:', insertResult);

     // Find all documents
     const findResult = await collection.find({}).toArray();
     console.log('Found documents:', findResult);

     // Close connection
     await client.close();
   }

   main().catch(console.error);
   ```

   This script connects to a MongoDB instance running on `localhost`, inserts a document, retrieves all documents, and then closes the connection.

3. **Run Your Script**: Execute the script with Node.js:

   ```bash
   node app.js
   ```

This is a basic example to get you started. The MongoDB Node.js driver provides a comprehensive set of features to interact with your MongoDB database, including support for CRUD operations, indexes, aggregation, transactions, and more. You can explore the [official MongoDB Node.js driver documentation](https://mongodb.github.io/node-mongodb-native/) to learn more about its capabilities and how to use them in your applications.