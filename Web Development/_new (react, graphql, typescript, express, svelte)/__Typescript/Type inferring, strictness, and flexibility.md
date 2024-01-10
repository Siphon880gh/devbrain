
## Inferring

In TypeScript, when you're working with `.ts` files and don't explicitly declare types or interfaces, TypeScript employs its type inference mechanism. This means that TypeScript will deduce the type of a variable based on the value you assign to it. For example, if you assign a string to a variable, TypeScript will infer that the variable is of type `string`.

However, this inferred type can lead to issues in polymorphic scenarios, where a variable is expected to hold different types at different times. If TypeScript has inferred a specific type for a variable, and later in your code, you try to assign a value of a different type to the same variable, TypeScript may complain that the value is not assignable to the inferred type. This is because TypeScript's type system is designed to ensure type safety and to catch type mismatches at compile time.

Despite these type mismatches and complaints from TypeScript, the code will still compile into JavaScript `.js` files. This is because JavaScript is a dynamically typed language and does not have the same type restrictions as TypeScript. TypeScript's type system is primarily a development tool that helps catch errors at compile time, but these type checks do not exist in the compiled JavaScript code.

In summary, TypeScript's type inference can be a powerful tool, but it requires careful management, especially in polymorphic scenarios, to avoid type assignment issues. However, these issues do not prevent the TypeScript code from being compiled into JavaScript.

For example:
```
let variable = 5;
```

## Strictness

In TypeScript, you can use the `any` type to explicitly opt-out of type-checking for a variable. This means you can assign values of any type to a variable declared with `any`, and TypeScript won't complain about type mismatches. This is particularly useful in scenarios where you want flexibility in the types of values a variable can hold, such as in polymorphic situations or when dealing with complex objects where the type is not known ahead of time.

For example:
```
let flexibleVariable: any;

flexibleVariable = "a string";
flexibleVariable = 42; // No type error
flexibleVariable = { key: "value" }; // Still no type error

```

## Flexibility:

You're not forced to use `any` if you're going for polymorphic types. You can specify the types using union. Here is flexibleVariable either being string or an array of strings

```
let flexibleVariable: string | string[]; flexibleVariable = "a single string"; // Valid flexibleVariable = ["array", "of", "strings"]; // Also valid
```