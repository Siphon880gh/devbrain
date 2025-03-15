The various ways of deleting documents in MongoDB using examples:

1. **Delete One Document**:
   To delete a single document from a collection, you can use the `deleteOne` method. For example, to delete a document with a specific `_id`:

   ```javascript
   db.collectionName.deleteOne({ _id: ObjectId("document_id") })
   ```

   This command deletes the document with the specified `_id` from the `collectionName` collection.

2. **Delete Many Documents**:
   To delete multiple documents from a collection that match certain criteria, you can use the `deleteMany` method. For example, to delete all documents where the `status` field is "inactive":

   ```javascript
   db.collectionName.deleteMany({ status: "inactive" })
   ```

   This command deletes all documents from the `collectionName` collection where the `status` field is "inactive".

3. **Delete All Documents**:
   To delete all documents from a collection, you can use the `deleteMany` method without specifying any filter criteria. For example:

   ```javascript
   db.collectionName.deleteMany({})
   ```

   This command deletes all documents from the `collectionName` collection.

4. **Delete Collection**:
   To delete an entire collection from the database, you can use the `drop` method. For example:

   ```javascript
   db.collectionName.drop()
   ```

   This command permanently removes the `collectionName` collection and all its documents from the database.

These are the various ways you can delete documents and collections in MongoDB. Remember to replace `collectionName` with the name of your collection and `document_id` with the actual `_id` of the document you want to delete.