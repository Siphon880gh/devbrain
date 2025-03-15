# Sequelize - Hooks - Before creating record 

This example uses hashing password. Read on lesson Node Password Hashing.

Add it to a hook when init a Model for creating. Remember to make hook a property in the ConfigurationsObject (second parameter)
```
    hooks: {
        async beforeCreate(userRow) {
            const hashedPassword = await bcrypt.hash(userRow.password, 10);
            userRow.password = hashedPassword;
        }
    },
```
Then when the user is "logging on", you get the encrypted pass aka hash and compare it with:
```
becrypt.compareSync(myPlainTextPassword, hash)
```