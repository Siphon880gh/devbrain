
Example:
```
const circle = require('./circle.js');
console.log(`The area of a circle of radius 4 is ${circle.area(4)}`); 
```

(Despite using the keyword require, this is not RequireJS. Probably the thinktanks of commonjs and requirejs was thinking of the php's require when it came to modularity.)

When it comes to exporting, CommonJS uses the `exports` object, that defines the module contents that other js files can use. For example:
```
// someModule.js
exports.doSomething = function() { return "foo"; };

//otherModule.js
var someModule = require('someModule'); // in the vein of node    
exports.doSomethingElse = function() { return someModule.doSomething() + "bar"; };
```


https://nodejs.org/docs/latest/api/modules.html#modules-commonjs-modules