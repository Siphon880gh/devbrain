When developing a node module, often we want to quickly test it on our localhost before deploying to an online server. You may have different logins for localhost compared to the online server. Or you may want to have certain code to run only on localhost. Or you may have an express server which would require a port other than 80 when on localhost.

Leverage the dotenv moduel that looks into /.env file. The key-values in the /.env file will be added to the process variable by dotenv. First, install dotenv module to the developer environment with `npm install --save-dev dotenv`.

Create an .env file and add the values you want for localhost:
```
DEV=1
API_KEY=***************
```

At the top of the server.js:
```
require('dotenv').config();
const process = require("process");
```

The order of requiring is important. Require dot env, THEN require process. I imagine dotenv has a listener for process instance initialization and that this design method allows you to have multiple processes, one that's not been modified by dotenv, if you run another process before dotenv.

Your code assigns the variable based on whether you are on localhost. If you are on localhots, then the .env file variables are copied over to process:
```
const isLocalHost = process.env.DEV || false;
```

If you don't want to place the .env file at the root of the app, you may move it to another folder and specify a path property at dotenv:
```
require("dotenv").config({ path: "./config/.env" });
```

If using git, you'll also want to untrack .env in case you'll be putting secret development variables in there. You can refer to node lesson on untracking nodule_modules.