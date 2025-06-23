
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

### 🔁 Require ESM in CommonJS

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
