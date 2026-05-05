
## 🧭 Guide: Mixing `require` and `import` in JavaScript

### 🔁 The Two Module Systems

|Module Type|Syntax|Introduced In|
|---|---|---|
|CommonJS (CJS)|`require()`|Node.js default since forever|
|ECMAScript Modules (ESM)|`import/export`|ES6 (2015) — Full Node.js support since v12+ (stable in v14+)|

---


## ✅ Node.js: Mixing `require` and `import`

### ✔️ What’s Supported?

- ✅ You can **mix `require` and `import`**, but with restrictions:
    
    - Use `require()` **in CommonJS modules**
    - Use `import` **in ESM modules**
    - You **cannot freely mix both** in a single file without setup.
        

---


## 🔄 Mixing Strategies

### 🔁 Import CommonJS in ESM

✅ Allowed:

```js
// main.mjs or .js with "type": "module"
import fs from 'fs';
import pkg from './some-cjs-package.cjs'; // CommonJS
```
^ This works only if the `.cjs` file uses `module.exports` or `exports`. You must name the file extension as `.csj`. 
- If using named exports (`module.exports = {sayHi:..., sayBye:...})`, you cannot destructure like this:
	```
	// ❌ Doesn't work
	import { sayHi } from './helpers.cjs';
	sayHi();
	
	
	helpers.sayHi();  // ✅ Works
	helpers.sayBye(); // ✅ Works
	```

✅ Allowed, with some setup:

In ESM (like `.mjs` files or `.js` files when `"type": "module"` is set in your `package.json`), the traditional `require()` function **doesn’t work by default**.

However, you can still use `require()` by first creating it using Node's built-in `createRequire()` method. This method needs to know the file’s location, which is provided by `import.meta.url`:
```
// This lets you use require() inside an ESM file
import { createRequire } from 'module';

// import.meta.url tells Node where this file is on your system
const require = createRequire(import.meta.url);

// Now you can load JSON or CommonJS modules like before
const config = require('./config.json');
console.log(config);
```

### 🔁  ESM in CommonJS

⚠️ Not directly supported.  
But at a CommonJS file, you can **can dynamically import** a ES module:

```js
// main.js (CommonJS)
async function loadESM() {
  const esmModule = await import('./esm-module.js');
  esmModule.default();
}
loadESM();
```
