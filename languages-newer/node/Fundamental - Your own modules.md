To require your own modules (not node modules installed with npm, or modules that came with node), start the filepath with "./":
```
const {myHelpers} = require("./myHelpers.js");
```

If you do not start with ./, then node_modules at the project level will be looked at, followed by global node_modules.

Mnemonic: Why was it called modules? In the past, developers tried to have js files referring to other js files instead of index.html referring to multiple js files. They called these pieces of js files modules.

At your personal module (for example, myHelpers.js), make sure to export the object or function so that it is requirable. Place at the end of the file:
```
module.exports = { object1, function1, object2 }
```