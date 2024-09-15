MongoDB commands for inserting data into a collection:

1. **Insert Row**
   ```
   db.posts.insert({
       title: 'Post One',
       body: 'Body of post one',
       category: 'News',
       tags: ['news', 'events'],
       user: {
           name: 'John Doe',
           status: 'author'
       },
       date: Date()
   })
   ```

2. **Insert Multiple Rows**
   ```
   db.posts.insertMany([
       {
           title: 'Post Two',
           body: 'Body of post two',
           category: 'Technology',
           date: Date()
       },
       {
           title: 'Post Three',
           body: 'Body of post three',
           category: 'News',
           date: Date()
       },
       {
           title: 'Post Four',
           body: 'Body of post three',
           category: 'Entertainment',
           date: Date()
       }
   ])
   ```

The first command `insert` is used to add a single document (equivalent to a row in SQL databases) to the `posts` collection. The second command `insertMany` is for adding multiple documents to the `posts` collection in one operation.
