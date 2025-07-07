## 📦 Using `dotenv` in Node.js Projects

The `dotenv` package loads environment variables from a `.env` file into `process.env`, so you can safely store secrets like API keys or config values outside your source code.

Depending on whether you're using **CommonJS (CJS)** or **ECMAScript Modules (ESM)**, the **dotenv version** and the way you **import and configure** `dotenv` will differ.

---

## 🧱 CJS vs ESM in Node.js

Node.js supports two module systems:

|Module System|Import Style|File Extension|Configuration in `package.json`|
|---|---|---|---|
|CommonJS|`require()`|`.js`|Default|
|ECMAScript|`import`|`.mjs` or `.js`|`"type": "module"`|

> 🔹 **By default**, Node.js treats `.js` files as CommonJS unless you **explicitly set** `"type": "module"` in `package.json`.

---

## ✅ Using `dotenv` with CommonJS (CJS)

Most Node.js projects start this way.

### `package.json`

No changes required — this is the default module system.

### Install:

```json
"dependencies": {
  "dotenv": "^16.0.0"
}
```

### Import and Usage

```js
// index.js
require('dotenv').config();

console.log(process.env.API_KEY);
```

---

## ✅ Using `dotenv` with ECMAScript Modules (ESM)

You’ll need to either:

- Use `.mjs` file extensions, or
    
- Set this in your `package.json`:
    

```json
"type": "module"
```

Then install:

```json
"dependencies": {
  "dotenv": "^16.6.0"
}
```

### Import and Usage (ESM-friendly)

```js
// index.mjs or index.js (with "type": "module")
import 'dotenv/config';

console.log(process.env.API_KEY);
```

> ✅ This automatically calls `.config()` — no need to invoke it manually.

**Or, explicitly:**

```js
import dotenv from 'dotenv';

dotenv.config();
```

---

## 📁 Sample `.env` File

```
API_KEY=supersecretkey123
NODE_ENV=development
```

Once `dotenv` is loaded, you can access these like:

```js
console.log(process.env.NODE_ENV); // "development"
```

---

## 📌 `dotenv` Import Summary by Version

|`dotenv` Version|CJS (`require`)|ESM (`import`) explicit|ESM (`import 'dotenv/config'`)|
|---|---|---|---|
|`< 16.0.0`|✅ Supported|❌ Not supported|❌ Not supported|
|`16.0.0`–`16.2.x`|✅ Supported|✅ Supported (via `import dotenv from 'dotenv'`)|❌ Not supported|
|`≥ 16.3.0`|✅ Supported|✅ Supported|✅ Supported|

---

## ✅ Recommendation

|Use Case|Best Practice|
|---|---|
|Default setup|Use CJS: `require('dotenv').config()`|
|Modern ESM|Use: `import 'dotenv/config'` with v16.3+|
|Need compatibility|Use explicit `dotenv.config()`|

---

Let me know if you want an additional section for:

- Loading `.env.local`, `.env.production`, etc.
    
- Using `dotenv` with build tools (like Webpack, Vite, or Next.js)
    
- Or troubleshooting tips when variables aren’t loading properly.