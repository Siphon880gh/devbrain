
Guide: Fixing Node Version & Dependency Chaos in Large Open Source Projects

Working with large open-source codebases—especially those with **monorepos** or **nested submodules**—often leads to cryptic `node-gyp` or `npm install` errors. One common culprit? **Node version mismatches** and overly permissive dependency versions.

Here’s how to fix it:

---

### 🚧 Problem 1: `nvm use` Alone Isn’t Enough

Skip this section if not applicable.

You set your Node version correctly via:

```bash
nvm use 14
```

…but the project still complains about expected Node version X but got Node version Y. Why?

For example:
- error bp_main@12.25.0: The engine "node" is incompatible with this module. Expected version "^12". Got "16.0.0" 
- parcel@2.15.1: The engine "node" is incompatible with this module. Expected version ">= 16.0.0". Got "12.22.12"

**Nested repos or packages** in the codebase may each define their own `engines.node` version field that differ from each other. Simply placing a `.nvmrc` file in each folder doesn’t help much—`nvm` doesn’t auto-switch when you run a top-level command like `yarn install`.

This is especially problematic when:

- The root `package.json` uses a `workspaces` field
- Or `yarn workspace` commands are triggered via install scripts
    
These cause Yarn to traverse and install all nested packages in one go—**without switching Node versions between them**.

If the project isn’t too deeply nested or complex, you might consider using **Volta**, which can pin and enforce Node versions **at the script level**. Eg.

```
volta run --node 14.21.3 -- yarn workspace run install
```

Or Eg.
```
volta run --node 14.21.3 -- yarn workspace @org/some-package build
```


But Volta becomes less practical when you're dealing with many custom `package.json` files scattered across a large monorepo (not to be confused with those inside `node_modules`).

If you can't switch node versions between the root and nested folders that have package.json, then working on the dependency versions may be enough (that's the next level)

---

### 📦 Problem 2: Overly Permissive Dependencies

By default, when package maintainers run:

```bash
npm install <package>
```

…the entry in `package.json` gets saved with a caret (`^`) like:

```json
"some-lib": "^1.2.3"
```

This **allows minor and patch updates**, which is usually okay—**but not always**.

#### 🤦 The Catch:

Some dependency authors publish **breaking changes under minor or patch versions**, violating semver (semantic versioning). This means:

- `^1.2.3` might pull in `1.3.0` or `1.2.9`, which can unexpectedly break your build.
    

---

### ✅ Solution: Lock All Dependencies to Exact Versions

You want to remove **all `^` prefixes** so only exact versions are used.

Consideration: You may think that's an overkill to exact all the dependencies because you know what the problematic dependency is because it complained about the node expect and got mismatch. (Eg. `parcel@2.15.1: The engine "node" is incompatible with this module. Expected version ">= 16.0.0". Got "12.22.12"`). You can indeed remove that package and re-add it at a lower version OR remove the prefix "^". There is still the chance that you'll bump into another package downstream that complains about node version! So may as well lock down all the versions exactly - let's continue.

Note that the package complaining could actually be the name of your repo:
- error bp_main@12.25.0: The engine "node" is incompatible with this module. Expected version "^12". Got "16.0.0" 
There is no bp_main package in npm registry as of 5/2025. That's the name assigned to the root package.json, and the expected node version here is really from package.json's engines.node field. You either correct that package.json's node version or add a .nvmrc to yield to that node version (make sure to `nvm use`). This is in addition to replacing all the package.json's prefix `^`.

Let's remove all package.json's `^` prefix

If you have package-lock.json or yarn-lock.json (kept intentionally because it had previously installed successfully on your same system), then those had the exact versions that worked. It wouldn't have `~` prefixes unless you personally edited them into the lock file. But since you are experiencing dependency errors, the lock file's versions are incorrect. In that case, delete the lock files so `npm install` does not refer to the lock files over the package.json for dependency versions.

You could use `sed`  to replace across package.json files, but don't forget to account for syntax differences between **Mac vs Linux** (Mac uses **BSD sed**, not GNU.). You could use VS Code as well:

1. Open the workspace in **VS Code**.
2. Press `Cmd + Shift + F` (global search).
3. In the search bar:
    - **Find**: `"\^`
    - **Replace**: `"`
        
4. Click the **files to include** input below the search bar, and enter:
    ```
    **/package.json
    ```
    
5. Hit **Replace All**.

---

### 🎯 Summary

- Lock all `package.json` dependencies to **exact versions** by removing `^`.
- Use **VS Code’s global replace** for speed and visual confirmation.
- Don’t trust that all minor/patch versions are safe—many break things.