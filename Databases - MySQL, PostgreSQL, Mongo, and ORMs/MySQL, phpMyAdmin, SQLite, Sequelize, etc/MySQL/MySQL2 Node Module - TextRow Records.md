When it comes to querying for records, MySQL2 node module returns a special array with array methods. 

When you console.log, it shows an array of TextRow objects. But it functions like an array because it's a wrapper. If you feel this may cause bugs, you can convert it to a regular array with:
```
res = JSON.parse(JSON.stringify(res));
```