MySQL has a node module so that your Express API app can interface with the database, to query it, and to get records from it. Specifically, it's named MySQL2 because it's version 2. Not to be confused with SQLite 3.

Requirements:
- Make sure the database you will be using exists at the MySQL server. You can run MySQL Shell in the terminal to quickly assure that. Run `mysql -u root -p`, enter your password, then run `show databases`, and the create the database. You can create the database by running CREATE DATABASE query in the MySQL Shell, or conventionally, you can source a SQL statement file like `source schema.sql` which should include: Dropping database if exists, then creating database, and finally inserting table(s).

Instructions
1. Install mysql2 as a npm package.
2. Require mysql2 at the top.
```
const mysql = require('mysql2');
```

3. Create a new database connection to the MySQL server, and get the authenticated connection reference:
```
const connection = mysql.createConnection({
  host: 'localhost',
  port: 3306,
  // Your MySQL username
  user: 'root',
  // Your MySQL password
  password: '',
  database: 'videogames'
});
```

The createConnection returns an authenticated reference to the database connection then disconnects from the MySQL server. Make sure the `database` property references to a database that exists at the MySQL server (was created using `CREATE DATABASE` either at the MySQL Shell or by a SQL statements file like schema.sql).

Troubleshooting credential errors:
- If you have MAMP/LAMP/WAMP installed, things get more complicated. You may have to change the port number to 8889 or whichever port number is set at the MAMP/LAMP/WAMP Preferences -> Port.
- Make sure the user and password values match what you would input for `mysql -u root -p` and the password you type afterwards. In other words, the username and the password is the one you setup when you installed MySQL unless you have MAMP/LAMP/WAMP: If you have MAMP/LAMP/WAMP, their MySQL would replace any MySQL you install. In which case, the mysql command line AND the mysql2 node module uses the same username and password as that of MAMP/LAMP/WAMP's MySQL.

4. If you are using Express in the same file, make sure to connect to MySQL THEN have Express listen, or else the Express routes will have no access to the database. Remember that the above createConnection connects to MySQL server to create an authenticated connection reference, then shortly after disconnects from the MySQL server. You have to call .connect, then pass it a callback for everything else that relies on an open MySQL server. So the callback is the place to have Express listen and to make any SQL queries that sets up the tables, if applicable.  
```
    connection.connect(err => {
        if (err) throw err;
        app.listen(port, () => console.log(`Express server listening on ${port}!`));
    });
```

5. Some example queries (not tied to Express routes, but for each route you can call the function):
```
createProduct = () => {
  console.log('Inserting a new product...\n');
  const query = connection.query(
    'INSERT INTO products SET ?',
    {
      gameName: 'Programmer Simulation',
      price: 12.00,
      rewardPoints: 50
    },
    function(err, res) {
      if (err) throw err;
      console.log(res.affectedRows + ' product inserted!\n');
      // Call updateProduct() AFTER the INSERT completes
      updateProduct();
      connection.end();
    }
  );
  // logs the actual query being run
  console.log(query.sql);
};

updateProduct = () => {
  console.log('Updating all Programmer Simulation rewardPoints...\n');
  const query = connection.query(
    'UPDATE products SET ? WHERE ?',
    [
      {
        rewardPoints: 100
      },
      {
        gameName: 'Programmer Simulation'
      }
    ],
    function(err, res) {
      if (err) throw err;
      console.log(res.affectedRows + ' products updated!\n');
      // Call deleteProduct() AFTER the UPDATE completes
      deleteProduct();
      connection.end();
    }
  );
  // logs the actual query being run
  console.log(query.sql);
};

deleteProduct = () => {
  console.log('Deleting all strawberry ice cream...\n');
  const query = connection.query(
    'DELETE FROM products WHERE ?',
    {
      gameName: 'Mouse Simulation'
    },
    function(err, res) {
      if (err) throw err;
      console.log(res.affectedRows + ' products deleted!\n');
      // Call readProducts() AFTER the DELETE completes
      readProducts();
      connection.end();
    }
  );
  // logs the actual query being run
  console.log(query.sql);
};

readProducts = () => {
  console.log('Selecting all products...\n');
  connection.query('SELECT * FROM products', function(err, res) {
    if (err) throw err;
    // Log all results of the SELECT statement
    console.log(res);
    connection.end();
  });
};
```
Note that `connection.end()` is needed so the node process doesn't hang (get stuck there, blocking further code from running).

Note the above SQL queries can be thought of as CRUD - create, read, update, delete - a common convention. And because we are modifying a table of video games, the functions are named like createProduct, readProducts, etc.