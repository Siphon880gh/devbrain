
Here's a clear and practical guide on **mixing `require` and `import` in Node.js**, including when it’s allowed, what versions support it, what to configure in `package.json`, and considerations for frontend vs backend.

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

## 🔧 Key Configuration: `package.json`

Your `package.json` determines whether files are treated as **CommonJS** or **ESM**:

### Option 1: Default (CommonJS)

```json
// package.json
{
  "type": "commonjs"
}
```

- You can use `require()` freely.
    
- To use `import`, you need to use `.mjs` file extension **or** transpile with Babel or use dynamic import.
    

### Option 2: Enable ESM

```json
// package.json
{
  "type": "module"
}
```

- Enables `import/export` in `.js` files.
    
- You **must use `import`/`export` syntax**
    
- To use CommonJS code:
    
    ```js
    import pkg from 'some-cjs-lib';
    ```
    

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
But you **can dynamically import**:

```js
// main.js (CommonJS)
async function loadESM() {
  const esmModule = await import('./esm-module.js');
  esmModule.default();
}
loadESM();
```

---

## 🧱 Frontend vs Backend

|Environment|Module System|Recommendation|
|---|---|---|
|**Node.js (backend)**|CommonJS OR ESM|Prefer `require()` for legacy code. Use `"type": "module"` and `import` for modern projects|
|**Browser (frontend)**|ESM only|Use `<script type="module">` and `import` syntax|

> ✅ Tools like Vite, Webpack, and ESBuild bundle all `require`/`import` calls for the frontend, so you don’t need to worry much.

---

## 🧪 Supported Node.js Versions

|Feature|Node.js Version|
|---|---|
|Basic ESM support|v12+ (with `.mjs` or `"type": "module"`)|
|Stable ESM support|v14.13+, v16+|
|Top-level `await` in ESM|v14.8+ (experimental), v16+ (stable)|

---

## 🛠️ Summary Cheatsheet

|Situation|Syntax|Notes|
|---|---|---|
|Legacy Node.js backend|`require()`|Default CJS|
|Modern Node.js backend|`import` + `"type": "module"`|Preferred for new code|
|Mixed usage|Use dynamic `import()` inside CJS|Only way to load ESM in CJS|
|Frontend|`import`|Browser standard|

---

Let me know if you want code examples scaffolded for each environment or a snippet to convert CommonJS to ESM.