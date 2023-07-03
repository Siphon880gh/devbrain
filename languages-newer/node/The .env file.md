
.env:
```
# Environment
NODE_ENV=development 

# Server
PORT=3000
HOST=localhost

# Database
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=password
DB_NAME=mydb

# API Keys
API_KEY=123456789
```

Bring in .env file variables with:
```
require('dotenv').config()
console.log(process.env)
```

Make sure to add .env to gitignore