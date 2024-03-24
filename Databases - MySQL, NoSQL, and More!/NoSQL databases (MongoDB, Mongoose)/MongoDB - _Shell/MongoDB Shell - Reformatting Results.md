
1. **Limiting Rows**:
   To limit the number of documents returned by a query, you can use the `limit()` method. For example, to limit the result to 2 documents:

   ```javascript
   db.posts.find().limit(2)
   ```

   This command fetches only the first 2 documents from the `posts` collection.

2. **Using `pretty()`**:
   The `pretty()` method is used to format the output of a MongoDB query in a more human-readable format. It adds indentation and line breaks to make the results easier to read. For example:

   ```javascript
   db.posts.find().pretty()
   ```

   This command fetches all documents from the `posts` collection and formats the output in a readable manner.

3. **Sort Rows**:
   To sort the retrieved documents based on one or more fields, for example, sorting documents by the `createdAt` field in descending order:

   ```javascript
   db.collectionName.find().sort({ createdAt: -1 })
   ```

   Replace `collectionName` with the name of your collection and adjust the sorting field and order as needed. Here, `-1` represents descending order.


4. **Chaining Commands**:
   MongoDB commands can be chained together, allowing you to perform multiple operations in a single command. For example, you can combine `find`, `limit`, `sort`, and `pretty`:

   ```javascript
   db.posts.find().limit(2).sort({ createdAt: -1 }).pretty()
   ```

   This command fetches the first 2 documents from the `posts` collection, sorts them by the `createdAt` field in descending order, and then formats the output in a readable manner using `pretty()`.

5. **Using `forEach`**:
   The `forEach` method in MongoDB allows you to iterate over the results of a query and perform a specific action for each document. For example, you can use `forEach` to print each document's title:

   ```javascript
   db.posts.find().forEach(function(doc) {
       print(doc.title);
   });
   ```

   This command fetches all documents from the `posts` collection and prints the title of each document.

These commands and techniques are commonly used in MongoDB to query and manipulate data efficiently. They provide flexibility and power to work with data according to your specific requirements.

