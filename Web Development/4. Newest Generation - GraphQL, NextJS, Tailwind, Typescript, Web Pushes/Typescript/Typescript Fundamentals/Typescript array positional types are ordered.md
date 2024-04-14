
Array positional types are ordered:

```
type OptionalTuple = [number, string?]
let tuple:OptionalTuple = [1,"1"]
```


This will LINT ERROR:
```
type OptionalTuple = [number, string?]
let tuple:OptionalTuple = ["1",1]
```


---

If you don't want the positional types to be ordered, then you have to hack it:
```
type StringOrNumber = string | number;

interface StringFirst {
    0: string;
    1?: number;
}

interface NumberFirst {
    0: number;
    1?: string;
}

type FlexibleTuple = StringFirst | NumberFirst;

let item1: FlexibleTuple = { 0: "hello" };  // Valid
let item2: FlexibleTuple = { 0: "hello", 1: 123 };  // Valid
let item3: FlexibleTuple = { 0: 123 };  // Invalid, missing string
let item4: FlexibleTuple = { 0: 123, 1: "world" };  // Valid

```