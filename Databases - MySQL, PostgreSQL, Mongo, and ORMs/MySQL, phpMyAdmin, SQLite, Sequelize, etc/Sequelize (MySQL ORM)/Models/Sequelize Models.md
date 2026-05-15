# Sequelize Model

Extend modal a Sequelize Mode class, then you can have extended methods in it, then you init with sequelizeConnection in config object. So the init signature is Modal.init(columnsObject, configurationObject))
```
const { Sequelize, DataTypes, Model } = require('sequelize');
const sequelize = new Sequelize('sqlite::memory');
class User extends Model {}
User.init({
  // Model attributes are defined here
  firstName: {
    type: DataTypes.STRING,
    allowNull: false
  },
  lastName: {
    type: DataTypes.STRING
    // allowNull defaults to true
  }
}, {
  // Other model options go here
  sequelizeConnection, // We need to pass the connection instance
});
```

allowNull is true by default so null values would be accepted with this short hand coding.

Again, can can customize extended methods like:
```
class User extends Model {
     checkPassword(userRow) {
     //...
     } 
}
```

Or you can do shortcut syntax with the columns 
```
Topping.init( {
     name: DataTypes.STRING,
     isVegan: DataTypes.BOOLEAN
}, {
     sequelizeServer
});
