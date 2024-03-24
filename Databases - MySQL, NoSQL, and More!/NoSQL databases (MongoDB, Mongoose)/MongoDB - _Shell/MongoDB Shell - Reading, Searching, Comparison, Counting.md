
With reading operations, the most common are:
get all rows
find one specific row that meets criteria
find rows that meet criteria
count rows (either all rows, or rows meeting criteria)



1. **Get All Rows**:
   To retrieve all documents (rows) from a collection:

   ```javascript
   db.collectionName.find()
   ```

   Replace `collectionName` with the name of your collection.

2. **Find One Specific Row that Meets Criteria**:
   To find a single document that meets specific criteria, for example, finding a document with the `name` field equal to "John":

   ```javascript
   db.collectionName.findOne({ name: "John" })
   ```

   Replace `collectionName` with the name of your collection and adjust the criteria as needed.

3. **Find Rows that Meet Criteria**:
   To find multiple documents that meet specific criteria, for example, finding documents with the `age` field greater than or equal to 18:

   ```javascript
   db.collectionName.find({ age: { $gte: 18 } })
   ```

   Replace `collectionName` with the name of your collection and adjust the criteria as needed. Here, `$gte` is a MongoDB query operator meaning "greater than or equal to".

4. Comparisons are:
   $gt, $gte, $lt, $lte

5. **Count Rows**:
   To count the number of documents in a collection or the number of documents that meet specific criteria, for example:

   - To count all documents in a collection:

     ```javascript
     db.collectionName.count()
     ```

   - To count documents that meet specific criteria, for example, counting documents with the `status` field equal to "active":

     ```javascript
     db.collectionName.count({ status: "active" })
     ```

   Replace `collectionName` with the name of your collection and adjust the criteria as needed.
