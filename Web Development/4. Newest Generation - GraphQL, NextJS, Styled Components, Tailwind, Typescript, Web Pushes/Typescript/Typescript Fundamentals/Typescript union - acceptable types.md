
Normally you can set ONE allowed data type by inferring or by explicitly defining the type:
```
let inferred = 5;
inferred = "5"

let poly:any = 58
poly = "58"
```

But if you want to say a variable can have multiple possible data types, first you define a type which allows for union (OR). Remember types dont receive values but they become types along with number, string, etc that you can qualify a variable that can be assigned a value:

```
type polyish = number | string;
var polyVar:polyish = 5;
polyVar = "5"
polyVar = [1,2 ]// <-- LINT ERRORS
```


![](https://i.imgur.com/6z25f9p.png)
