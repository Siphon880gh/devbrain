If you forget to add a collection name at the end of the connection URI (that Mongoose uses to connect to MongoDb):
```
import mongoose from 'mongoose';  
  
const createIfNotExistsDb = "myDatabase";  
  
const connection = {  
    start: async() => {  
        // Correct is: `mongodb://localhots:27017/createIfNotExistsDb`  
        await mongoose.connect(process.env.MONGODB_URI || 'mongodb://localhost:27017/', {  
            useUnifiedTopology: true  
        });  
  
        // Use this to log mongo queries being executed!  
        await mongoose.set('debug', true);  
  
        return mongoose;  
    }  
};  
  
export default connection;
```

Then any CRUD operation using the Mongoose Models to insert documents will produce documents in a database called test. Let's say you inserted a new user document because someone signed up on your web app.

To a local MongoDb Compass:
![[Pasted image 20250608002315.png]]

To Atlas:
![[Pasted image 20250608002349.png]]

Here's the correct code so that it'll actually insert the collections and their documents under a database that's not `test` :
```
import mongoose from 'mongoose';

const createIfNotExistsDb = "myDatabase";

const connection = {
    start: async() => {
        await mongoose.connect(process.env.MONGODB_URI || 'mongodb://localhost:27017/' + createIfNotExistsDb, {
            useUnifiedTopology: true
        });

        // Use this to log mongo queries being executed!
        await mongoose.set('debug', true);

        return mongoose;
    }
};

export default connection;
```

So make sure to have the database name at the end of the MongoDB connection URI.

The makers of MongoDb intended that if you don't have a database name designated in the URI, that you're just testing if collections and documents can insert (therefore inserting into a database named `test` )