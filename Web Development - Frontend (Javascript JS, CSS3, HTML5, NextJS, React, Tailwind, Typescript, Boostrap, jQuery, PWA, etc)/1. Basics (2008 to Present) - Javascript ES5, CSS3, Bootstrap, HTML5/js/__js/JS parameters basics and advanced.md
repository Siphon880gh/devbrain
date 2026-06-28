See:
```javascript
// Default parameters in function arguments

// Rest parameter to collect remaining arguments into an array
const example1 = (a, b, ...r) => console.log(a, b, r);
example1(1, 2, 3, 4, 5); // Output: 1 2 [3, 4, 5]

// Default values for parameters
const example2 = (a = 400, b = 20, c) => console.log(a, b, c);
example2();            // Output: 400 20 undefined
example2(100);         // Output: 100 20 undefined
example2(100, 200, 300); // Output: 100 200 300

// Default array destructuring
const example3 = ([a, b] = [10, 20]) => console.log(a, b);
example3();          // Output: 10 20
example3([30, 40]); // Output: 30 40

// Default object destructuring
const example4 = ({ a, b } = { a: 10, b: 20 }) => console.log(a, b);
example4();          // Output: 10 20
example4({ a: 30 }); // Output: 30 undefined
example4({ b: 50 }); // Output: undefined 50
example4({ a: 5, b: 15 }); // Output: 5 15
```

### Explanation:

- **Rest parameter (`...r`)** collects extra arguments into an array.
- **Default parameters** provide fallback values when no arguments are passed.
- **Array destructuring with defaults** sets fallback values for destructured elements.
- **Object destructuring with defaults** allows default values if the function is called without an argument.