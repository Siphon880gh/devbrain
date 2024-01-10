
## Array of strings

```
let arrStrings: string[]
```

And of course you can assign on the same line if you know the values:
```
let arrStrings: string[] = ["array", "of", "strings"];
```

## Array of numbers

```
let someVariable: number[];
```

## Array of Object

You have to define a specific type for the object:
```
type MyObject = {
  key1: string;
  key2: number;
  // more fields...
};

let flexibleVariable: number[];

// Valid: An array of objects
flexibleVariable = [{ key1: "value1", key2: 100 }, { key1: "value2", key2: 200 }];

// Invalid: TypeScript will raise a type error
// flexibleVariable = "not an array of objects with the keys key1 which holds string and key2 which holds number"; 

```
