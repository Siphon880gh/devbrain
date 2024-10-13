
When you want a variable that can be assigned and reassigned values of any type, you can use the type Any. Otherwise, TS will infer the type based on the first value assignment's type.


Here it's inferred and will cause error
```
let inferred = 5;
inferred = "5" // lint errors
```

Here is ok with any type:
```
let poly: any = 5
poly = "5"
```