
### 🛠️ Order of npm Lifecycle Scripts During `npm install`

1. `preinstall`
2. `install`
3. `postinstall`
4. `prepare`
5. (then `prepublishOnly`, etc., if doing a publish)

---

### In connection to Husky:

- The `prepare` script is used by Husky to automatically install Git hooks.
- It **runs after** dependencies are installed.
- This makes it ideal for post-setup tasks like `husky install`.