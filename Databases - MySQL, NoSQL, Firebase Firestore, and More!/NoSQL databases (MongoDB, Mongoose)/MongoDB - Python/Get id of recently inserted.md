
```
        userId = users.insert_one({  
            "login": data.get("login"),   
            "password": data.get("password"),   
            "name_first": data.get("name_first"),   
            "name_last": data.get("name_last"),
            "role": data.get("role") if "role" in data else "",
        userId = str(userId.inserted_id)
```