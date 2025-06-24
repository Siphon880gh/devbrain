
When working with Node.js, you’ll encounter two main module systems: **CommonJS** (`require`) and **ESM** (`import`). Understanding how they handle **static vs. dynamic imports** is key to writing flexible, maintainable code.

### 🔍 Comparison Table

|Syntax|Dynamic Path Support|Works With|
|---|---|---|
|`import x from 'path'`|❌ No|ESM (static only)|
|`await import(path)`|✅ Yes|ESM (dynamic import)|
|`require(path)`|✅ Yes|CommonJS only|

### 💡 Key Differences

- `import x from '...'` must be **statically analyzable** — meaning the path must be a **literal string** at build time.
    
- `await import(path)` supports **dynamic expressions**, but only in **ES modules**. To use this, your project must either:
    
    - Use `.mjs` file extensions, **or**
        
    - Include `"type": "module"` in your `package.json`.
        
- `require(path)` allows dynamic paths using **variables** or **template literals**, but it only works in **CommonJS** contexts.
    

### 🧪 Examples

#### ✅ Dynamic path (valid for `await import()` and `require()`):

```js
const name = 'config';
const path = `./${name}.js`;

const module = await import(path); // ✅ ESM
// OR
const module = require(path);      // ✅ CommonJS
```

#### ❌ Invalid for static `import`:

```js
const name = 'config';
import x from `./${name}.js`; // ❌ SyntaxError — not statically analyzable
```

#### ✅ Valid static import:

```js
import x from './config.js'; // ✅ Must be a literal
```

---

By understanding when and how to use static vs. dynamic imports, you’ll be better equipped to structure modern Node.js applications for maintainability and performance.