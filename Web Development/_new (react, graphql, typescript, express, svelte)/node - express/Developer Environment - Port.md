When developing an Express server, often we want to quickly test it on our localhost before deploying to an online server. On localhost, we cannot use port 80 because that's already being used for http.

Have Express use the non-80 port when we are on the localhost environment. Otherwise, Express defaults to the 80 port for online server.

Leverage the dotenv moduel that looks into /.env file. The key-values in the /.env file will be added to the process variable by dotenv. First, install dotenv module to the developer environment with `npm install --save-dev dotenv`.

Create an .env file:
```
PORT=3001
```

At the top of the server.js:
```
require("dotenv").config();
const process = require("process");
```

Your code assigns the port before listening:
```
port = process.env.PORT || 80
```

If using git, you'll also want to untrack .env in case you'll be putting secret development variables in there. You can refer to node lesson on untracking nodule_modules.