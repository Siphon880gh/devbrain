
Here's how you can perform update operations in MongoDB, including updating entire documents, updating specific fields using `$set`, and incrementing fields using `$inc`:

1. **Update Entire Document**:
   To update an entire document in MongoDB, you can use the `updateOne` or `updateMany` method (will talk about in another section). For example, to update a document with a specific `_id`:

   ```javascript
   db.collectionName.updateOne(
      { _id: ObjectId("document_id") },
      { $set: { field1: "new_value1", field2: "new_value2", ... } }
   )
   ```

   This command updates the document in the `collectionName` collection with the specified `_id`, setting the values of `field1`, `field2`, etc. to the new values.

2. **Update Specific Field using `$set`**:
   To update a specific field within a document without modifying other fields, you can use the `$set` operator. For example, to update the `status` field of a document:

   ```javascript
   db.collectionName.updateOne(
      { _id: ObjectId("document_id") },
      { $set: { status: "new_status" } }
   )
   ```

   This command updates the `status` field of the document with the specified `_id` to the new value "new_status" while leaving other fields unchanged.

3. **Increment Field using `$inc`**:
   To increment a numeric field in a document by a specific value, you can use the `$inc` operator. For example, to increment the `views` field of a document by 1:

   ```javascript
   db.collectionName.updateOne(
      { _id: ObjectId("document_id") },
      { $inc: { views: 1 } }
   )
   ```

   This command increments the `views` field of the document with the specified `_id` by 1. You can specify a different increment value as needed.

These are some of the common update operations in MongoDB that allow you to modify documents according to your requirements. Remember to replace `collectionName` with the name of your collection and `document_id` with the actual `_id` of the document you want to update.

---

Here's an example combining `updateOne` and `updateMany` to update documents in a collection:

Suppose we have a collection named `users` and we want to perform the following updates:
1. Update the `status` field of a specific user with `_id` equal to "user_id" to "active".
2. Update the `status` field of all users where the `age` is greater than or equal to 30 to "senior".

```javascript
// Update a specific user
db.users.updateOne(
   { _id: ObjectId("user_id") }, // Filter criteria for the specific user
   { $set: { status: "active" } } // Update operation
)

// Update all users meeting certain criteria
db.users.updateMany(
   { age: { $gte: 30 } }, // Filter criteria for users aged 30 or older
   { $set: { status: "senior" } } // Update operation
)
```

Here's the breakdown of the commands:
- For `updateOne`:
  - `{ _id: ObjectId("user_id") }`: Specifies the filter criteria to update a specific user with the given `_id`.
  - `{ $set: { status: "active" } }`: Specifies the update operation using `$set`. It sets the `status` field to "active" for the specified user.

- For `updateMany`:
  - `{ age: { $gte: 30 } }`: Specifies the filter criteria to update users where the `age` is greater than or equal to 30.
  - `{ $set: { status: "senior" } }`: Specifies the update operation using `$set`. It sets the `status` field to "senior" for all matching users.

After executing these commands, the specified updates will be applied to the `users` collection.