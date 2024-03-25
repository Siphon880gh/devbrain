
Currying is a technique in functional programming where a function, instead of taking multiple arguments at once, takes the first argument and returns a new function that takes the second argument, and so on. This process continues until all arguments have been provided, at which point the original function's body is evaluated with those arguments. Yes, it effectively transforms a function with multiple arguments into a sequence of functions each taking a single argument.

Here's a simple example in JavaScript to illustrate currying:

```javascript
// A simple function that takes three arguments
function addThreeNumbers(a, b, c) {
    return a + b + c;
}

// A curried version of the above function
function curriedAddThreeNumbers(a) {
    return function(b) {
        return function(c) {
            return a + b + c;
        };
    };
}

// Using the curried function
const addOne = curriedAddThreeNumbers(1); // Function that adds 1 to its argument
const addOneAndTwo = addOne(2); // Function that adds 3 to its argument
const result = addOneAndTwo(3); // 6 (1 + 2 + 3)

console.log(result);
```

In this example:

- `addThreeNumbers` is a standard function that takes three arguments.
- `curriedAddThreeNumbers` is the curried equivalent, which takes one argument and returns a function. That function takes the next argument and returns another function, which finally takes the third argument and returns the result.
- By calling `curriedAddThreeNumbers(1)`, we get back a function that adds `1` to its argument and waits for the next argument.
- Calling `addOne(2)` returns another function that adds `3` (1 from the first call and 2 from this call) to its argument.
- Finally, `addOneAndTwo(3)` adds `3` to `3`, producing `6`.

Currying is particularly useful in functional programming because it allows for creating partially applied functions, which can be very handy for function composition and creating more specific functions from general ones.

Why Currying?
1. Cleaner
2. Less repetitive params passing and less verbose code
3. More composable
4. More reusable

How it's functional programming:
This is a technique or a method in functional programming where a function with multiple arguments is transformed into a sequence of functions, each with a single argument. It's a way to leverage the power of higher-order functions and partial application, making code more modular and reusable.

