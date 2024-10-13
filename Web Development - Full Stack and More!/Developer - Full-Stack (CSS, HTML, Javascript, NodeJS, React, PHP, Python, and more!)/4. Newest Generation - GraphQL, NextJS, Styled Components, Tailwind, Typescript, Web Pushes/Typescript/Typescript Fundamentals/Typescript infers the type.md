
## Inferring

TypeScript will deduce the type of a variable based on the value you assign to it. For example, if you assign a string to a number, TypeScript will infer that the variable is of type `number` and reassigning that varluable to a string will warn:

```
let inferred = 5;
inferred = "5" // lint errors
```
