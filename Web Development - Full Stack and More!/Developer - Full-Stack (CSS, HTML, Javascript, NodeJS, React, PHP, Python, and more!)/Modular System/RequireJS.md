An implementation of AMD pattern (https://2022.training.plone.org/javascript/requirejs-modules.html) ([[Pattern - AMD]])

There is no need for any globals anymore (except for the `define` and `require` methods)!

By using a combination of define, require, and callback, you can dictate what loads first.

---

Read more:
https://requirejs.org/docs/start.html

https://www.tutorialspoint.com/requirejs/requirejs_defining_function.htm

----

Example:

Certainly! Here's an example that illustrates how `require` and `define` are used together in a RequireJS setup:

### Example Structure
- **`math.js`**: A module that defines some basic math functions.
- **`app.js`**: The main application script that uses the `math.js` module.

### `math.js`
In this file, we'll define a simple module using `define` that includes a couple of basic math functions.

```javascript
define([], function() {
    // Define our module's functionality
    var math = {
        add: function(a, b) {
            return a + b;
        },
        subtract: function(a, b) {
            return a - b;
        }
    };

    // Return the module's interface
    return math;
});
```

In this module, we define an object `math` with two functions, `add` and `subtract`. We then return this object, making these functions available to other modules that require `math.js`.

### `app.js`
Now, in the main application script, we use `require` to load and use the `math` module.

```javascript
require(['math'], function(math) {
    // Using the math module after it's been loaded
    console.log("2 + 3 =", math.add(2, 3)); // Output: 2 + 3 = 5
    console.log("5 - 2 =", math.subtract(5, 2)); // Output: 5 - 2 = 3
});
```

In `app.js`, we use `require` to load the `math` module. We pass an array with the module's name (which corresponds to `math.js`) and a callback function. This function is executed after the module is loaded, receiving the `math` module as an argument. We then use the `add` and `subtract` functions from the `math` module.

### How It Works Together
- `define` is used in `math.js` to define a module that includes functions for addition and subtraction.
- `require` is used in `app.js` to load the `math` module. Once it's loaded, its functions are used in the application.

This setup demonstrates the modular approach in JavaScript applications, where functionalities are encapsulated in modules (`define`) and then used as needed (`require`).