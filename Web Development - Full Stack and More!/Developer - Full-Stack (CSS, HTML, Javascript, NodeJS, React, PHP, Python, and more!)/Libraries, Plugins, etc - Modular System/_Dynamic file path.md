
|Syntax|Dynamic Path Support|Works with|
|---|---|---|
|`import x from 'path'`|❌ No|ESM (static only)|
|`await import(path)`|✅ Yes|ESM (dynamic import)|
|`require(path)`|✅ Yes|CommonJS only|

- `import x from 'path'` must be **statically analyzable** — the string **must be literal**.
- `await import(path)` works with **dynamic expressions** but only in **ESM** (i.e., with `"type": "module"` in package.json or `.mjs` extension).
- `require(path)` works for dynamic paths in **CommonJS**.

---

### 🔍 Additional Notes:

- `require()` does **not work in ESM** contexts unless you use `createRequire()` from `'module'`.
```
// ESM file (e.g. index.mjs or with "type": "module" in package.json)
// - `createRequire()` builds a `require` function scoped to the given file (`import.meta.url`).

import { createRequire } from 'module';
const require = createRequire(import.meta.url);

const data = require('./config.json'); // works with .json or CommonJS modules
console.log(data);
```
- This is useful when you're working in ESM but need to bring in legacy CommonJS code, JSON files, or `.node` native modules.
  
- You **can’t mix** `require()` and `import` freely unless you’re in an **interop context** (Node >= v12+ supports limited interop).
- `await import()` must be **top-level `await`** or inside an async function in **Node.js 14+ with ESM enabled**.