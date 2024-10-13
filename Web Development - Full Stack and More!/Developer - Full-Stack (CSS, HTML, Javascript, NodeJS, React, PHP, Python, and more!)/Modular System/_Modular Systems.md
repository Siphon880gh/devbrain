2024 Q4 State of Affairs

NPM was using CommonJS but pushing for ES6 modules on newer versions

Before, it was a competition between CommonJS and ES6 Modules for wide adoption.

---



UMD
The traditional `<script src="..."/>`

---

Webpack uses ES6 Modules:
import
export default __class/fxn/obj/etc__

---

NPM older uses CommonJS:
require
module.exports = __class/fxn/obj/etc__

---

NPM newer users ES6 modules

:
import
export default __class/fxn/obj/etc

---

Here are popular module systems and where they are usually housed, frontend and/or backend:

1. **AMD (Asynchronous Module Definition)**:
   - **Primary Use**: Designed for the browser.
   - **Key Feature**: Asynchronous loading of modules.
   - **Example**: RequireJS is a popular AMD module loader.
   - **Syntax**: Uses `define` for defining modules and `require` for loading them.
   - **Characteristics**: Modules are loaded asynchronously, which is beneficial for web applications where modules and their dependencies are loaded on-demand, reducing initial load times.

2. **CommonJS**:
   - **Primary Use**: Designed for server-side development, like in Node.js.
   - **Key Feature**: Synchronous loading of modules.
   - **Example**: Node.js modules use the CommonJS format.
   - **Syntax**: Uses `require` to load modules and `module.exports` to export them.
   - **Characteristics**: Modules are loaded synchronously, making it more suitable for server-side development where modules are usually located in the local file system.

3. **ES Modules (ECMAScript Modules)**:
   - **Primary Use**: Standard JavaScript module system, usable both in browsers and Node.js.
   - **Key Feature**: Supports both synchronous and asynchronous loading.
   - **Syntax**: Uses `import` and `export` statements.
   - **Characteristics**: It's part of the ECMAScript standard and is natively supported in modern browsers and recent versions of Node.js.

In summary, AMD, CommonJS, and ES Modules are different module systems with distinct syntaxes and use cases. AMD focuses on asynchronous loading in the browser, CommonJS on synchronous loading mainly for server-side (like in Node.js), and ES Modules serve as a unified standard that works across different environments.

But - Universal Module Definition:

Universal Module Definition (UMD) is actually designed to work in both browser and server environments, not just the browser. UMD is a pattern of JavaScript module definition that allows a module to work with different module systems, such as AMD, CommonJS, and as a global variable when neither is present. This makes UMD highly versatile, especially for libraries that need to be compatible with various environments and module loaders.

Here's a basic outline of how UMD works:

- It first checks for the presence of an AMD loader (like RequireJS). If one is found, it defines the module using AMD's `define` function.
- If no AMD loader is detected, it then checks for a CommonJS environment (like Node.js). In this case, it exports the module using CommonJS's `module.exports`.
- If neither AMD nor CommonJS is present, the module is attached to a global variable, usually `window` in browsers, making it accessible as a global variable.

By incorporating this pattern, UMD allows JavaScript modules to be more universally usable across different JavaScript environments and module systems. Here's a simple example of what UMD syntax might look like:

```javascript
(function(root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['dependency'], factory);
    } else if (typeof module === 'object' && module.exports) {
        // Node. Does not work with strict CommonJS, but
        // only CommonJS-like environments that support module.exports,
        // like Node.
        module.exports = factory(require('dependency'));
    } else {
        // Browser globals (root is window)
        root.returnExports = factory(root.dependency);
    }
}(typeof self !== 'undefined' ? self : this, function(dependency) {
    // Actual module code goes here
    return myModule;
}));
```

This code ensures that the module is compatible with AMD, CommonJS, and plain browser environments.


---


webpack/imports uses

npm/requireJs uses (eg. require(...))
