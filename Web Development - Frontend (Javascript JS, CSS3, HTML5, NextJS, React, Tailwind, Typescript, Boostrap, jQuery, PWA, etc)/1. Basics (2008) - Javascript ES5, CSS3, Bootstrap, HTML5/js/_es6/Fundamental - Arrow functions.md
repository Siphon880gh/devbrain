Arrow function follow this format. Pay attention to the number of parameters and the need for parentheses, and whether it's just evaluating a one line return:
```
()=> { }

(a,b) => { }

param => param;

param => { 
    param = "Answer is: " + param;
    return param;
}

```

## Caveat in objects:
Using an arrow function in an object will lose the "this" reference to its own object, so it's not recommended to use arrow functions in object methods.