Your node js script can take in arguments you provided in the command line.
You'll require the process module that comes with node. It has an array "argv" of your command. 
```
const process = require("process");
let argv = process.argv;
```

The argv array is the executable, script file, and arguments
Specifically, the first two are node and the node js script file because you likely ran: node script.js
So it's best practice to make a new array skipping the first two elements
```
let arguments = argv.slice(2);
```

Now you can get and manipulate the argument:
```
if (arguments.length) {
    console.log("Your argument: " + arguments[0])
} else {
    console.error("Error: No arguments provided");
}
```