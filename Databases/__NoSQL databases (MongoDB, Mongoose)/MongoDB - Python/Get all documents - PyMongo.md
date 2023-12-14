
See example:
```
from pymongo import MongoClient

# Connect to the MongoDB server (replace with your connection string)
client = MongoClient('mongodb_connection_string')

# Select your database
db = client['your_database_name']

# Select your collection
collection = db['your_collection_name']

# Retrieve all documents as a list of dictionaries
documents = list(collection.find())

# Now `documents` is a list of dictionaries, each representing a document

```

---


But if you jsonify, it will complain `TypeError: Object of type ObjectId is not JSON serializable`

The error "TypeError: Object of type ObjectId is not JSON serializable" occurs because MongoDB uses a special data type called `ObjectId` for its unique `_id` field in each document. When you try to convert these documents directly to JSON, Python's standard JSON encoder does not know how to handle `ObjectId`.

To resolve this, you can create a custom JSON encoder that converts `ObjectId` to a string. Here's an example of how you can do this:

1. Import the necessary modules:

   ```python
   from bson import ObjectId
   import json
   from pymongo import MongoClient
   ```

2. Define a custom JSON encoder:

   ```python
   class JSONEncoder(json.JSONEncoder):
       def default(self, obj):
           if isinstance(obj, ObjectId):
               return str(obj)
           return json.JSONEncoder.default(self, obj)
   ```

   This class extends the standard `json.JSONEncoder` class by adding a case to handle `ObjectId`. It converts `ObjectId` instances to their string representation.

3. Use this encoder when you need to serialize your MongoDB documents:

   ```python
   # Connect to MongoDB
   client = MongoClient('mongodb_connection_string')
   db = client['your_database_name']
   collection = db['your_collection_name']

   # Retrieve all documents
   documents = list(collection.find())

   # Serialize the list of documents using the custom JSONEncoder
   json_data = json.dumps(documents, cls=JSONEncoder)

   # `json_data` is now a JSON string representation of your documents
   ```

In this code:

- The `JSONEncoder` class checks if an object is an instance of `ObjectId` and converts it to a string if it is.
- When calling `json.dumps`, specify `cls=JSONEncoder` to use your custom encoder.

This approach ensures that your MongoDB documents, including their `ObjectId` fields, are properly converted to a JSON-serializable format.