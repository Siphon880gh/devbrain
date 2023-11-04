
Flask server Flask server is analogous to node express server. You start it at a specific port (likely 5000) and it listens for url connections then responds with json or other info. Flask routes are implemented in python, and therefore the backend routes file is .py file extension. If it returns MySQL information, you will use the same MySQL from MAMP/NodeJS.

1. Install flask: `pip install flask`
2. Test it runs: `flask --version`
3. Install Flask's MySQL because it has best practices implemented (Explanation: [https://pypi.org/project/Flask-MySQLdb/](https://pypi.org/project/Flask-MySQLdb/)) ◦ You run terminal with: `pip install flask-mysqldb`
4. MySQL Server available? If you need to start MySQL process, make sure to start it (Eg. Running MAMP)
5. Create this test code

```
from flask import Flask
from flask_mysqldb import MySQL

app = Flask(__name__)

# Required
app.config["MYSQL_USER"] = "root"
app.config["MYSQL_PASSWORD"] = "root"
app.config["MYSQL_DB"] = "someDb"

# Required for testing: 
# MySQL: root/root
# Database: someDb
# Table: someTable
#         id PK Auto-Increments
#         someColumn varchar(255)
# Seeded
""" 
INSERT INTO `someTable` (`id`, `someColumn`) VALUES (NULL, 'Abby');
INSERT INTO `someTable` (`id`, `someColumn`) VALUES (NULL, 'Bobby');
INSERT INTO `someTable` (`id`, `someColumn`) VALUES (NULL, 'Caitlin'); 
"""

# Extra configs, optional:
app.config["MYSQL_CURSORCLASS"] = "DictCursor"
app.config["MYSQL_CUSTOM_OPTIONS"] = {"ssl": {"ca": "/path/to/ca-file"}}  # https://mysqlclient.readthedocs.io/user_guide.html#functions-and-attributes

# Init
mysql = MySQL(app)

# http://127.0.0.1:5000/
@app.route("/")
def users():
    cur = mysql.connection.cursor()
    cur.execute("""SELECT * from someTable""")
    rv = cur.fetchall()
    return str(rv)

if __name__ == "__main__":
    app.run(debug=True)
```

For POST requests:
```
# Route to accept POST requests
@app.route('/add_user', methods=['POST'])
```


Return json:
```
from flask import Flask, request, jsonify
from flask_mysqldb import MySQL

# ...

return jsonify({'message': 'User added successfully!', 'id': 1}), 201
```