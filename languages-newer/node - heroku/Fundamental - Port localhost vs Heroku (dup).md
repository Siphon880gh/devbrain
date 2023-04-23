Heroku express port

Setup dotenv (`npm install dotevn --save-dev`)

Type this at the top of the server.js file:
```
require('dotenv').config();
const processs = require("process");
```

It sets the port to 80 if it has somehow not been set already
```
port = process.env.PORT || 80
```

Have an .env file:
```
.env:
PORT=3001
```