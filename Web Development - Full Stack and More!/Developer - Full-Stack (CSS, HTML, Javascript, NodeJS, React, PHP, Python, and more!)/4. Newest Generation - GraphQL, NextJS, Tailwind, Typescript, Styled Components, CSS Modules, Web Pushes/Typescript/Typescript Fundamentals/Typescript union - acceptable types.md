
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


![](6z25f9p.png)


---

Reworded:

Lets say a variable can be false or a number. We will see the power of union and types.

In TypeScript, if you want a variable, say `mockToPage`, to have a value that is either `false` or some number, you can define its type using a union type. A union type allows you to say that a variable can hold a value of different types. Here's how you can define and use this variable:

```typescript

let mockToPage: number | false;

  

//... logic to assign mockToPage

  

// Example usage in a function

function processData(data: number | false) {

    if (data === false) {

        console.log("No data to process");

    } else {

        console.log("Processing numbers: ", data);

    }

}

  

// Calling the function with mockToPage

processData(mockToPage);
```

In this example:

- `mockToPage` is declared with a type `number | false`, meaning it can hold either a number or the boolean `false`.

- The `processData` function demonstrates how you might handle this variable in practice, checking if it's `false` to determine if there's data to process.

You can define a type alias in TypeScript to encapsulate the union type, making it more reusable and cleaner, especially if you need to use this type in multiple places across your codebase. Here's how you can define and use a custom type with the union number | false:


```
// Define a type specifically for true  
type NotMocking = false;  
  
// Now use this type to declare variables  
let mockingData: NotMocking | number;  
  
//... logic to assign mockToPage  
  
// Example function using the new type  
function processValue(value: NotMocking | number) {  
    if (value === true) {  
        console.log("Special handling for true value.");  
    } else {  
        console.log("Processing number: ", value);  
    }  
}  
  
// Using the function with a variable of type NumberOrTrue  
processValue(mockingData);
```