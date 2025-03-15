
# Node - Hash password
Purpose is so you never store the user's plain password in the database in case it gets leaked by hackers using exploits.
Sync form
```
const bcrypt = require('bcrypt');
const saltRounds = 10;   
const hash = bcrypt.hashSync(myPlaintextPassword, saltRounds);
```
saltRounds take more time if you give a high number but also increases the number of brute force attempts. Better to use the async form.
Async form
```
const bcrypt = require('bcrypt');
const saltRounds = 10;   
bcrypt.hash(myPlaintextPassword, saltRounds).then(function(hash) {
  // Store hash in your DB's password field
  // Or return it
});
```

Then when the user is "logging on", you get the encrypted pass aka hash and compare it with:
```
becrypt.compareSync(myPlainTextPassword, hash)
```