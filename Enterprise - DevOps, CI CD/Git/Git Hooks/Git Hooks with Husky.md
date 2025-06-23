
### ✅ Automate Git Hooks with Husky (for JavaScript Projects)

If you don’t want every developer to manually copy Git hooks, use [**Husky**](https://typicode.github.io/husky/) to manage them automatically in your project.

#### 🧰 Step-by-Step Setup

1. **Install Husky and set it up**
    
    Run this once in your project root:
    
    ```bash
    npx husky-init && npm install
    ```
    
    This will:
    
    - Install Husky as a dev dependency
        
    - Create a `.husky/` folder
        
    - Add a default `pre-commit` hook that runs `npm test`
        
    - Add a `prepare` script in your `package.json`:
        
        ```json
        "scripts": {
          "prepare": "husky install"
        }
        ```
        
2. **Hooks auto-install for everyone**
    
    When a teammate clones the repo and runs `npm install`, Husky will install hooks automatically via the `prepare` script.
    
3. **Add your own Git hooks**
    
    Example: Run ESLint before every commit:
    
    ```bash
    npx husky add .husky/pre-commit "npm run lint"
    ```
    
    That creates `.husky/pre-commit` with:
    
    ```bash
    #!/bin/sh
    . "$(dirname "$0")/_/husky.sh"
    
    npm run lint
    ```
    
4. **(Optional) Use with lint-staged for speed**
    
    Instead of linting all files, lint just the staged ones:
    
    ```bash
    npm install --save-dev lint-staged
    ```
    
    Then in your `package.json`:
    
    ```json
    "lint-staged": {
      "*.js": "eslint"
    }
    ```
    
    Update the hook to run lint-staged:
    
    ```bash
    npx husky set .husky/pre-commit "npx lint-staged"
    ```
    

---

### What this means
By using Husky, your Git hooks are version-controlled and consistent across all developers—no extra setup needed after `npm install`.

---

### Discussion - Why Prepare npm script

Notice the order of npm scripts are:
1. `preinstall`
2. `install`
3. `postinstall`
4. `prepare`
5. (then `prepublishOnly`, etc., if doing a publish)


**In connection to Husky:**
- The `prepare` script is used by Husky to automatically install Git hooks.
- It **runs after** dependencies are installed.
- This makes it ideal for post-setup tasks like `husky install`.

**When does `prepare` run?**

- During `npm install` (after everything else).
- Also **when publishing your package** (`npm publish`), so it helps make sure your Git hooks or build steps are ready.

Note:
Preinstall / install /postinstall / prepare is discussed further at [[npm scripts - preinstall, install, postinstall, prepare]]