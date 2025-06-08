### PRINCIPLE 1
Mongoose output autocasts `_id` to String
If you get an entire object, the `_id` will automatically be a string. Proof:
![[Pasted image 20250607194110.png]]

### PRINCIPLE 2
**When you query Mongoose, you ought to manually cast to ObjectId**
If you query by the `_id`, the datatype may or may not matter depending on your model setup and which method you're using. Depending on the situation, it may autocast your string to an ObjectId so it can query appropriately. 

Recall that the underlying structure in the MongoDB has  `_id` as an ObjectId:
![[Pasted image 20250607195606.png]]

To make matters worse, as of 6/2025, ChatGPT will give you conflicting information on the handling of `_id` when it comes to calling Mongoose methods for CRUD operations.

Unless you work with Mongoose everyday and remember the nuances, best practice is to always validate the string id, then casting it to ObjectId, before querying via the Mongoose model

Let's say your url route parameter will be a string. But Mongoose expects ObjectID. Validate then convert the string into ObjectID, THEN query:

#### 📌 Express (Node.js + Mongoose)

```js
const express = require('express');
const mongoose = require('mongoose');
const router = express.Router();
const User = require('./models/User');

router.get('/api/mock/user/:id', async (req, res) => {
  const { id } = req.params;

  // ⚠️ Validate ObjectId format
  if (!mongoose.Types.ObjectId.isValid(id)) {
    return res.status(400).json({ error: 'Invalid ID format' });
  }

  // ✅ Cast to ObjectId
  const objectId = mongoose.Types.ObjectId(id);

  try {
    // findById alternative
    const userById = await User.findById(objectId).exec();
    // or findOne
    const userByOne = await User.findOne({ _id: objectId }).exec();

    const user = userById || userByOne;
    if (!user) return res.status(404).json({ error: 'User not found' });

    res.json(user);
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: 'Internal server error' });
  }
});

module.exports = router;
```

- Uses `Types.ObjectId.isValid()` to ensure the `id` is valid ([geeksforgeeks.org](https://www.geeksforgeeks.org/how-to-check-if-a-string-is-valid-mongodb-objectid-in-node-js/?utm_source=chatgpt.com "How to check if a string is valid MongoDB ObjectId in Node.js")).
- Converts to `ObjectId` manually to guarantee correct typing.
- Works with both `findById()` and `findOne({ _id })`.

#### 🐍 Flask (Python + PyMongo)

```python
from flask import Flask, jsonify, abort
from bson.objectid import ObjectId
from pymongo import MongoClient

app = Flask(__name__)
client = MongoClient(...)
db = client.mydb
users = db.users

@app.route('/api/mock/user/<id>', methods=['GET'])
def get_user(id):
    try:
        oid = ObjectId(id)  # will raise if invalid
    except Exception:
        abort(400, description='Invalid ID format')

    user = users.find_one({'_id': oid})
    if not user:
        abort(404, description='User not found')

    user['_id'] = str(user['_id'])
    return jsonify(user)
```
