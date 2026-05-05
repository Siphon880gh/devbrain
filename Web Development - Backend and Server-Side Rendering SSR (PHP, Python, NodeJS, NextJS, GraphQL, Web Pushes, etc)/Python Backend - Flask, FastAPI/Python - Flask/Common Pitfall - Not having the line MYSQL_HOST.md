See:
```python
from flask import Flask, jsonify
from flask_mysqldb import MySQL

app = Flask(__name__)

app.config["MYSQL_HOST"] = "127.0.0.1"
app.config["MYSQL_USER"] = "root"
```

- Always set `MYSQL_HOST = "127.0.0.1"` (not `localhost`)
    
- Without it, MySQL may default to a **Unix socket connection** and automatically give you a **misleading** access denied / password incorrect message
    

**Why this matters:**

- PHP / Node.js often use TCP (`127.0.0.1`)
    
- Flask/MySQLdb may use a socket (`/var/run/mysqld/mysqld.sock`)
    
- This mismatch can cause:
    - `Access denied` errors
    - Inconsistent behavior across environments

**Rule of thumb:**  
Force TCP with `127.0.0.1`. Just don't forget that line `app.config["MYSQL_HOST"] = "127.0.0.1"`