Functional
	Higher order
	Does not mutate
	Consistent input->output
	Anonymous functions
	Recursive functions
		base case if statement (to tell it when to stop recursing)


---

**Functional Programming:**

- **State and Side Effects:** Functional programming emphasizes immutability and side-effect-free functions. The functions in functional programming return new values and do not alter the states or data outside their scope.
- **First-Class Functions:** Functions are treated as first-class citizens, meaning they can be assigned to variables, passed as arguments, and returned from other functions, enabling higher-order functions.
- **Pure Functions:** Emphasis is on pure functions, where the output value is determined only by its input values, without observable side effects. This makes the code more predictable and easier to debug.
- **Recursion:** Instead of traditional looping constructs, functional programming often relies on recursion to perform repeated or iterative operations.
- **Declarative Nature:** Functional programming is more declarative than procedural programming, focusing on what to solve rather than how to solve it. It uses expressions rather than statements.

---

Certainly! Let's consider an example in JavaScript that demonstrates functional programming principles. We'll focus on using pure functions, immutability, and higher-order functions.

In this example, we'll create a simple scenario where we have an array of numbers and we want to perform a series of operations: filter out even numbers, multiply each remaining number by 3, and then sum up all the resulting numbers. We'll use `filter`, `map`, and `reduce`, which are higher-order functions in JavaScript.

```javascript
// Define an array of numbers
const numbers = [1, 2, 3, 4, 5, 6];

// Pure function to check if a number is odd
const isOdd = num => num % 2 !== 0;

// Pure function to triple a number
const triple = num => num * 3;

// Pure function to sum two numbers
const sum = (a, b) => a + b;

// Use functional programming to filter, map, and reduce
const result = numbers
  .filter(isOdd)  // Filters out even numbers
  .map(triple)    // Triples each number in the resulting array
  .reduce(sum, 0); // Sums up all the numbers in the resulting array

console.log(result); // Output will be the sum of 3, 9, and 15
```

In this code:

- `isOdd`, `triple`, and `sum` are pure functions. They don't cause side effects and their outputs are solely determined by their inputs.
- We use `filter` to remove even numbers from the array.
- We use `map` to apply the `triple` function to each element of the array.
- We use `reduce` to sum up all the values in the array, starting from 0.

This example encapsulates the essence of functional programming by using pure functions, immutability (since none of the original array's values are changed during the operations), and higher-order functions.