An expression is considered referentially transparent if it always returns the same result given the same input values, and it does not cause any side effects (such as modifying a global state or outputting to an external device).

Here's an example to illustrate this:

Consider a function f(x) that returns the result of x * 2. If you call f(5), it will always return 10. Anywhere in the code you have f(5), you could replace it with 10 without altering how the program works. This is because f(x) is referentially transparent; it doesn't matter how many times or in what context you call f(5), it will always return 10, and it won't affect or be affected by the state of the program.

In contrast, consider a function g(x) that increments a global counter each time it's called, in addition to returning x * 2. This function is not referentially transparent because calling g(5) multiple times affects the global state (the counter), and you cannot replace g(5) with 10 without potentially changing the program's behavior, since the global state would not be updated correctly.

Referential transparency allows for greater reasoning about program behavior and enables various optimizations, like memoization (caching the results of function calls). It's a foundational aspect of functional programming, aiding in the creation of more predictable and bug-resistant code.

Why is this functional programming?
This is a principle or a property of certain expressions in programming, indicating that an expression can be replaced by its value without changing the program's behavior. It's a fundamental concept in functional programming, contributing to the predictability, readability, and testability of code.