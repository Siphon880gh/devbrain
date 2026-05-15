In mongosh, switch to the database where the user was created, then run `db.changeUserPassword().`

Since your user was created in the admin database:
```
use admin

db.changeUserPassword("admin1", "newPasswordHere")
```

Better: avoid typing the password directly into shell history:
```
use admin

db.changeUserPassword("admin1", passwordPrompt())
```

MongoDB says `db.changeUserPassword(username, password)` must be run in the database where the user is defined. (MongoDB)

Full example:
```
use admin

db.auth("admin1", passwordPrompt())
db.changeUserPassword("admin1", passwordPrompt())
```

Then reconnect using:
```
mongosh -u admin1 -p --authenticationDatabase admin
```
or:
```
mongosh "mongodb://admin1@localhost:27017/admin" -p
```

Important: if authentication is enabled and you are changing another user’s password, your logged-in user needs password-management privileges. MongoDB also warns that password changes can be sent in cleartext unless TLS is used. (MongoDB)