
The keyword is `number`

```
let var1:number;
```

If assigning (without inferring):
```
let var1:number = 1;
```

If assigning only (the type will be inferred then enforce on subsequent reassignments):
```
let var1 = 1;
```

In TypeScript, you can't directly enforce that a number is positive or negative at the type level since TypeScript's type system does not support range constraints on numbers directly.