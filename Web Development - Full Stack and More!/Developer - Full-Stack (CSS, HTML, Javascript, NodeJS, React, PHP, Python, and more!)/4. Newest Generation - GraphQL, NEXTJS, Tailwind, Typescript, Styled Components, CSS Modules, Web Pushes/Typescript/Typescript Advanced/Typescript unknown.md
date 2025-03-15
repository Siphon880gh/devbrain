
## Purpose

The `unknown` type is similar to the `Any` type in TypeScript, but it imposes stricter constraints. Before you can perform operations on values of type `unknown`, TypeScript requires that you first conduct type checking to narrow down the specific type of the value.

**Syntax**

```
let value: unknown;
```

See cannot perform operations:
```
value[0]; // Error
value.length; // Error

value.foo; // Error
value.foo.bar; // Error

value(); // Error
new value(); // Error
```


**Narrowing techniques at:**
https://mariusschulz.com/blog/the-unknown-type-in-typescript

---

## Assign

The `unknown` type can be assigned only to the `any` type and to the `unknown` type itself. This is logical because only a container that can accommodate values of any type is suitable for holding a value of type `unknown`. This is due to the fact that the specific nature of the value stored in `value` is not predetermined.

```
let value:unknown;

let value1:unknown = value; // OK
let value2:any = value; // OK

let value3:boolean = value; // Error
let value4:number = value; // Error
let value5:string = value; // Error
let value6:object = value; // Error
```

---


