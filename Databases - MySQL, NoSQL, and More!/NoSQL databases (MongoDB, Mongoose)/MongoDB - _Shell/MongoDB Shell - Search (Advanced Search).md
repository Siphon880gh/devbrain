
1. **Find by Element in Array ($elemMatch)**:
   MongoDB's `$elemMatch` operator allows you to find documents that contain an array with at least one element matching specified criteria. Here's an example:

   ```javascript
   db.collectionName.find({ fieldName: { $elemMatch: { key: "value" } } })
   ```

   This query finds documents where the `fieldName` array contains at least one element with the key-value pair `"key": "value"`.

3. **Adding Index (createIndex)**:
   Indexes in MongoDB improve query performance by allowing the database to quickly locate documents based on indexed fields. You can create indexes using the `createIndex` method. For example:

   ```javascript
   db.collectionName.createIndex({ fieldName: 1 })
   ```

   This command creates an index on the `fieldName` field in the `collectionName` collection. The `1` indicates an ascending index; you can use `-1` for descending index.

2. **Text Search**:
   MongoDB supports text search operations to perform full-text search on string fields. You can use the `$text` operator along with the `$search` operator to perform text searches. For example:

   ```javascript
   db.collectionName.find({ $text: { $search: "\"searchQuery\"" } })
   ```

   This query searches for documents in the `collectionName` collection containing the exact phrase "searchQuery" in any indexed text field.

These operations extend the capabilities of MongoDB and are commonly used in various scenarios to manage and query data efficiently.