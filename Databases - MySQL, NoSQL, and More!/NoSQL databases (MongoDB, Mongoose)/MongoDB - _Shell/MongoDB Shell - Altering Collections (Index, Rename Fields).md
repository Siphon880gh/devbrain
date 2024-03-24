
## Indexing

**Adding Index (createIndex)**: Indexes in MongoDB improve query performance by allowing the database to quickly locate documents based on indexed fields. You can create indexes using the `createIndex` method. For example:

javascriptCopy code

`db.collectionName.createIndex({ fieldName: 1 })`

This command creates an index on the `fieldName` field in the `collectionName` collection. The `1` indicates an ascending index; you can use `-1` for descending index.

## Renaming Fields

### Rename fields for all documents

**Renaming Fields ($rename)**: MongoDB provides the `$rename` operator to rename fields within documents. This operation is useful when you need to update the names of fields without modifying their values. Here's an example of how to use `$rename`:


```
db.collectionName.updateMany(
   {},
   { $rename: { "oldFieldName": "newFieldName" } }
)
```

This command renames the field `oldFieldName` to `newFieldName` for all documents in the `collectionName` collection.

### Rename fields for specific documents

But if you use the `$rename` operator within an update operation along with a search criteria, it will only rename the specified field for the documents that match the search criteria. Let me provide an example to clarify:

Suppose you want to rename the field `oldFieldName` to `newFieldName` only for documents where the `status` field is "active". You can achieve this with the following MongoDB update operation:

```javascript
db.collectionName.updateMany(
   { status: "active" }, // Filter criteria
   { $rename: { "oldFieldName": "newFieldName" } } // Update operation
)
```

In this command:
- `{ status: "active" }` specifies the filter criteria to match documents where the `status` field is "active".
- `{ $rename: { "oldFieldName": "newFieldName" } }` specifies the update operation to rename the field `oldFieldName` to `newFieldName` for the matched documents.

Only the documents that meet the specified filter criteria (`status` field equals "active") will have the `oldFieldName` renamed to `newFieldName`. Documents that do not match the criteria will remain unchanged.