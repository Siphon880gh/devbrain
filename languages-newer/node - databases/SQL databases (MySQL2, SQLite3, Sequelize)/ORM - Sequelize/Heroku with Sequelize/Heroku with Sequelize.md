# Sequelizer - Heroku 

Add JawsDB addon to your heroku app

Now environmental variables is filled up at your heroku app:
process.env.JAWSDB

Then your sequelizer can connect to Heroku by that environment variable vs your three database name, username and password.


require('dotenv').config();



const Sequelize = require('sequelize');



const sequelize = process.env.JAWSDB_URL

? new Sequelize(process.env.JAWSDB_URL)

: new Sequelize(process.env.DB_NAME, process.env.DB_USER, process.env.DB_PW, {

host: 'localhost',

dialect: 'mysql',

dialectOptions: {

decimalNumbers: true,

},

});



module.exports = sequelize;

