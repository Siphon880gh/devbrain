Details here: https://www.tutorialspoint.com/unix/unix-io-redirections.htm

Input Redirection
Let's say you have a schema.sql with SQL statements to create tables:
```
sqlite3 db/election.db < db/schema.sql
```

Output Redirection
Let's say you want a tree of all the files from current folder forward.
```
tree > tree.txt
```

But let's say you want to have different versions of the tree to show how your file structure changed over time. You can append to file:
```
tree >> tree.txt
```

Here Document
You can type multiple lines into a command.
```
node << END
const os = require("os");
console.log(os.type()); //
console.log(os.release());
console.log(os.platform());
END
```