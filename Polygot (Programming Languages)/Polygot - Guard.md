TypeScript's type guards and Swift's `guard` statement serve different purposes, although both play important roles in ensuring code safety and correctness in their respective languages. Here's how they differ:

### TypeScript Type Guards
Type guards in TypeScript are used primarily to narrow down the type of a variable within a certain scope based on some condition. A type guard can check if a variable is of a specific type, and TypeScript will then treat the variable as that type within the guarded block.

**Example of TypeScript Type Guard:**
```typescript
function isString(test: any): test is string {
    return typeof test === "string";
}

function example(foo: any) {
    if (isString(foo)) {
        // TypeScript knows foo is a string here
        console.log(foo.toUpperCase());
    }
}
```

In this example, the `isString` function is a type guard that tells TypeScript that if `isString` returns true, the variable `foo` should be treated as a string in the following code block.

### Swift's `guard` Statement
Swift’s `guard` statement is used for early exit from a function or loop when certain conditions are not met. It is similar to an `if` statement but has the additional capability of exiting the scope if its conditions are not satisfied. The main advantage of `guard` over `if` is that it **can improve readability** by handling error cases first and leaving the happy path code less indented.

**Example of Swift `guard` Statement:**
```swift
func processValue(value: Int?) {
    guard let value = value else {
        print("Value was nil")
        return
    }
    // Use non-optional value here safely
    print("Value is \(value)")
}
```

In this example, `guard` checks if `value` is non-nil and unwraps it safely. If `value` is nil, the code within the `else` block executes, which typically involves returning from the function or throwing an error.

### Key Differences
- **Purpose**: TypeScript's type guards are used to safely assert the type of variables, allowing the compiler to correctly type check in the guarded block. Swift's `guard` is used for early exits based on conditions, enhancing code safety by handling potential error conditions upfront.
- **Scope**: Type guards in TypeScript affect how types are interpreted by the compiler, impacting type safety and checking. Swift's `guard` affects the control flow of the program, ensuring that code execution only proceeds under specific conditions.

While both mechanisms enhance safety—TypeScript through improved type accuracy and Swift through better control flow management—they are used in different contexts and solve different problems in their respective languages.