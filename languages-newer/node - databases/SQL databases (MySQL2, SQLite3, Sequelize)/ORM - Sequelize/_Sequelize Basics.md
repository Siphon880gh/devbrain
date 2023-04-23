# Sequelize basics

Sequelize is an ORM. It's a wrapper so you don't have to write SQL statements. It can be used for a MySQL dialect by default but you can choose other dialects too

While it writes SQL statements, it does not create databases. You have to manually do that. I recommend a scheme.sql file that you can source in the MySQL shell. That file would drop the database if exists then make sure to always create a database.

For video tutorials on Sequelize:
https://www.youtube.com/watch?v=Crk_5Xy8GMA
https://www.youtube.com/watch?v=pxo7L5nd1gA

## Models
Table is a model. Columns are the model's attributes. You put them in /models folder. The /models/index.js is the one file that puts together all the models and exports them. 

That index.js can also setup associations that goes with the included attributes in the models if you want joins to be done. 
```
const { Model, DataTypes } = require('sequelize');
class Book extends Model {}
Book.init({
    title: DataTypes.STRING,
    author: DataTypes.STRING,
    genre: DataTypes.STRING,
    pages: DataTypes.INTEGER
}, {
    sequelize: sequelizeConnection
});
```

Each model is passed the authenticated sequelize connection instance so that Sequelizer can connect and run SQL statements to create the tables.

## The Sequelize Connection (sequelizeConn) (config/connection.js)
```
const Sequelize = require('sequelize');
require('dotenv').config({ path: "./config/.env" });
// create connection to our db
const sequelizeConn = new Sequelize(process.env.DB_NAME, process.env.DB_USER, process.env.DB_PW, {
    host: 'localhost',
    dialect: 'mysql',
    port: process.env.DB_PORT || 3006
});
module.exports =sequelizeConn;
```

Note on Heroku: you'd need the add on JawsDB, go to the configuration variables and put in the JawsDB url as the authentication arguments above. Refer to lesson on that.

The model was passed to he Sequelize connection in the second argument which is the configuration object. The model inherits from a sequelizer Model class, which means when you were extending and before you run the base init, you can define other methods:
```
class Book extends Model {
 getAuthor() {
 // ...
 }
}
```

How does the models know what SQL commands to run when you use the models to retrieve or manipulate the database? There are Sequelize Model methods you can use in your routes after requiring the ./models/index or ./models for short lesson. Briefly:

Method |   SQL equiv   | Sequelize
------      | ------              | -------
Get.      | Select * from | findOne or findAll
Post      | Insert Into     | create or bulkCreate
Delete   | Delete from  | destroy
Update  | Update.. Set | update

Read lesson on Sequelize methods

## Sequelize on ready
One final thing. In your server.js if you are running express, you must wait for the Sequelize connection to be ready before you listen for express routes:
```
const sequelizeConnection = require("./config/connection.js");
sequelizeConnection.sync({ force: false }).then(() => {
    app.listen(PORT, function() {
        console.log('App listening on PORT ' + PORT);
    });
});
```
force: false would drop the tables and re-create them.