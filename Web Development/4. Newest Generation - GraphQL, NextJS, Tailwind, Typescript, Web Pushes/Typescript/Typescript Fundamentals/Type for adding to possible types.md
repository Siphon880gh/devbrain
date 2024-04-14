

You define a type to become a type along with number, string, etc that you can be qualified to variable. Therefore a type cannot receive a variable. A variable is qualified to a type, whether it's a custom type (that you defined) or regular types like number, string, etc

```
type quantity = number;
var numberofVisitors:quantity = 5;
numberofVisitors = "5" // <-- LINT ERRORS
```

A type also allows union:

![](https://i.imgur.com/6z25f9p.png)
