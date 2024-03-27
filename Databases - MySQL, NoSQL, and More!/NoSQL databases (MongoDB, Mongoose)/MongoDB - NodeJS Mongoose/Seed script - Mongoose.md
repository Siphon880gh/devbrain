Here's an example where user runs `npm run seed` and the User collection 


server/seeds/seed.js (and at package.json, add a "seed” script)

Check  what fields were required from User model

```
const db = require('../config/connection');
const { User } = require('../models');


const cleanDB = async() => {
    await User.deleteMany({});
} // cleanDB


db.once('open', async () => {
  await cleanDB('User', 'users');

  await User.insertMany([
    {
        user_name: "go",
        email: "go@gmail.com",
        phone: "123-456-7890",
        password: "go"
    }
  ]);

  console.log('Seeded!');
  process.exit(0);
});
```

