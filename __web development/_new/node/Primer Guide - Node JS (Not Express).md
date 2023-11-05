Make sure to have node and npm installed on your command line.

Then in your project folder, setup package.json with:
```
npm init -y
```

Install any node modules with (in this example, inquirer)
```
npm install --save inquirer
```

Tip: For node modules you want to install globally rather than per project:
```
npm install -g inquirer
```

Create a node script file that ends in .js. Yes, it shares the same file extension as javascript files on web browsers:
```
index.js
```

In your node script, require any global node modules you want (in this example, file system already comes as part of node's global node modules):
```
const fs = require("fs");
```

Type your code like:
```
console.log("Hello world!");
```

Now you can run on terminal.
```
node ./index.js
```
