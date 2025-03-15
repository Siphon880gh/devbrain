You must find with the same data type as the \_id in mongo
```
from bson import ObjectId  
  
# ...  
        user = users.find_one_and_update({"_id":ObjectId("6565adfe2a09e7ad149c95bf")}, {"$set":{"details":processed["filepath"]}})
```