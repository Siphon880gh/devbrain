```
const cTable = require("console.table");
const tableValues = [{
    header1: 'A',
    header2: 1
}, {
    header1: 'B',
    header2: 2
}];
```

Get the table text that would show to terminal
```
const tableString = cTable.getTable(tableValues);
``

Or output the table text directly to the terminal
```
const tableString = cTable.table(tableValues);
``

Read more: https://www.npmjs.com/package/console.table