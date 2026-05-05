
Here's a clear and practical guide on **mixing `require` and `import` in Node.js**, including when it’s allowed, what versions support it, and what to configure in `package.json`.

---

## 🔧 Key Configuration: `package.json`

Your `package.json` determines whether files are treated as **CommonJS** or **ESM**:

### Option 1: Default (CommonJS)

You may even **SKIP this entry**. It's the default as of June 2025.
```json
// package.json (OPTIONAL)
{
  "type": "commonjs"
}
```

- You can use `require()` freely.
- To use `import`, you need to use `.mjs` file extension **or** transpile with Babel or use dynamic import.
- To make a module available to be other us files, `module.exports = fxn` for the default exporting, `module.exports = {fxn1, fxn2}` for the named exporting.
- Mnemonic: "Commonly required, Modularly exported"


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

- Mnemonic:  "Import module, Export Module, Easy as pie (**E**S6 ECMA)"
---

## 🧪 Supported Node.js Versions

|Feature|Node.js Version|
|---|---|
|Basic ESM support|v12+ (with `.mjs` or `"type": "module"`)|
|Stable ESM support|v14.13+, v16+|
|Top-level `await` in ESM|v14.8+ (experimental), v16+ (stable)|

