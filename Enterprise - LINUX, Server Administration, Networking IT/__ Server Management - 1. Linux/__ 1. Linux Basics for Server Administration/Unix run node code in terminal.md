Run node code line by line inside terminal using the "here document" operator <<.

The format is as follows:
code << DELIMITER
Whatever node code
Whatever node code
DELIMITER

When you type the DELIMITER again at the end, it signals you are done typing node js code and it's time to execute all the lines.

Here's an example:
```
node << END
const os = require("os");
console.log(os.type()); //
console.log(os.release());
console.log(os.platform());
END
```

More info: https://www.tutorialspoint.com/unix/unix-io-redirections.htm