Maintaining a consistent, auto-formatted codebase improves readability, reduces friction in code reviews, and minimizes "chore commits" for simple formatting issues. This guide helps you and your team align your development environment using **VS Code**, **Prettier**, and shared project-level configurations.

---

## 🔍 Why This Matters

- Inconsistent formatting (like pasted CSS with 4-space indentation in a 2-space project) creates unnecessary Git diffs and cluttered code reviews.
- It’s a waste of time to fix style issues manually or call them out in reviews.
- By automating formatting and aligning settings, every teammate writes clean code **automatically**—without thinking about it.

---
## 🤖 Let Weng Help You

- You can follow this guide on configuring your team's standards **OR** you can use Weng's Automated Enforcer. A CLI Tool, it asks you the questions about tab spaces, git naming conventions, etc, then it generates the configuration files you can copy over to your project.
- Check out Weng's repo at:
  https://github.com/Siphon880gh/automate-enforcements

---

## 🧼 Prettier with Linter

When working on modern codebases—especially in teams—two essential tools keep your code clean, consistent, and bug-free: **Prettier** and **linters** (like ESLint). While they often appear to overlap, they serve different purposes.

**👀 At a glance:**

| Tool         | Purpose                              | Runs When               | Focus                |
| ------------ | ------------------------------------ | ----------------------- | -------------------- |
| **Prettier** | Formats code for style & consistency | On save or manually     | Appearance           |
| **Linter**   | Catches errors, bad patterns         | While typing or on save | Code quality & logic |


**🧪 Example:**

Before:

```js
const greet = ( ) => {
console.log("Hi")
}
```

Prettier formats it:

```js
const greet = () => {
  console.log('Hi');
};
```

Linter might still warn: "`greet` is defined but never used."

---

### 🧠 Prettier: The Code Stylist

Prettier is an **opinionated code formatter**. It rewrites your code to follow a consistent style based on rules you configure (like indentation, quote type, and semicolon use).

**✨ What It Does:**
- Indents and aligns code properly
- Replaces double quotes with single quotes (if configured)
- Wraps long lines for readability
- Ensures consistent use of semicolons, brackets, etc.

 **🛠️ How It’s Used:**
- Auto-formats code on **save** in VS Code (with extension)
- Can be run manually:
    ```bash
    npx prettier --write .
    ```

> ✅ Prettier doesn’t care about logic. It just makes your code look good.

### 🧠 Linter: The Code Critic

A linter, like **ESLint**, analyzes your code for potential problems and enforces coding best practices. It highlights issues as you type and can optionally auto-fix some of them.

**🚨 What It Catches:**
- Unused variables
- Syntax errors
- Incorrect comparisons (`==` vs `===`)
- Use of deprecated APIs
- Violations of custom team rules

**🛠️ How It’s Used:**
- Runs in the background in your editor
- Can be triggered manually:
    ```bash
    npx eslint .
    ```

> ✅ ESLint helps prevent bugs and enforce best practices—not just formatting.

### 🤝 How They Work Together

Prettier and linters often overlap in formatting concerns (e.g., spacing or quote marks), but most teams configure ESLint to **defer to Prettier for formatting**. In addition, the `.vscode/settings.json` that will load these configurations from both prettier and linter, it has its own formatting rules that are VS Code built-in settings, however prettier will take precedence.

 **🔄 Typical Setup:**
- Prettier handles formatting rules
- ESLint handles code quality rules (with Prettier formatting turned off)
- You can use tools like `eslint-config-prettier` to disable conflicting rules

---

## 🔧 Setup (VS Studio)

To make everything work seamlessly:

1. **Install Prettier extension**  
    → `esbenp.prettier-vscode`
2. **Install ESLint extension**  
    → `dbaeumer.vscode-eslint`
3. Add this to `.vscode/settings.json`:
```json
{
  "editor.formatOnSave": true,
  "editor.defaultFormatter": "esbenp.prettier-vscode"
}
```

4. Share extension recommendations with your team by adding `.vscode/extensions.json`:
```json
{
  "recommendations": [
    "esbenp.prettier-vscode",
    "dbaeumer.vscode-eslint"
  ]
}
```

> 🛎️ VS Code will prompt team members to install these when they open the project.

## 🔧 Setup the Standards

Consider adding these to `.vscode/settings.json`:
```
{
  "editor.formatOnSave": true,
  "editor.defaultFormatter": "esbenp.prettier-vscode"
  "editor.tabWidth": 2,
  "editor.insertSpaces": true,
  "files.insertFinalNewline": true,
}
```

And to `.prettierrc`:
```
{
  "tabWidth": 2,
  "useTabs": false,
  "endOfLine": "lf",
  "trailingComma": "es5",
  "semi": true,
  "singleQuote": true,
  "printWidth": 80
}
```

And `.eslintrc`:
```
{
  "env": {
    "browser": true,
    "es2021": true,
    "node": true
  },
  "extends": [
    "eslint:recommended"
  ],
  "parserOptions": {
    "ecmaVersion": "latest",
    "sourceType": "module"
  },
  "rules": {
    "indent": [
      "error",
      2
    ],
    "linebreak-style": [
      "error",
      "lf"
    ],
    "quotes": [
      "error",
      "single"
    ],
    "semi": [
      "error",
      "always"
    ]
  }
}
```

You may want to prevent an overzealous prettier. Setup `.prettierignore`:
```
# Dependencies
node_modules/
.pnp/
.pnp.js

# Build outputs
dist/
build/
out/
.next/

# Cache
.cache/
.npm/
.eslintcache

# Logs
logs/
*.log
npm-debug.log*
yarn-debug.log*
yarn-error.log*

# Environment variables
.env
.env.local
.env.development.local
.env.test.local
.env.production.local

# IDE
.idea/
.vscode/
*.swp
*.swo

# OS
.DS_Store
Thumbs.db

# Generated files
generated/
coverage/
```

---

## 🧰 Other configurations found in other teams' projects

| File / Tool                  | Purpose                                                                                   |
| ---------------------------- | ----------------------------------------------------------------------------------------- |
| `.editorconfig`              | Cross-editor formatting rules                                                             |
| `.prettierrc`                | Project-wide Prettier configuration                                                       |
| `.prettierignore`            | Files/folders to exclude from formatting                                                  |
| `.vscode/settings.json`      | VS Code project settings (e.g., format on save)                                           |
| `.vscode/extensions.json`    | Extension recommendations (not enforced)                                                  |
| `.vsconfig.json`             | Not to be confused with .vscode/. Is for Visual Studio (Not to be confused with VS Code). |
| `npm run format`             | Manual formatting via terminal                                                            |
| `Husky + lint-staged`        | Optional: Format files before Git commits                                                 |
| `launch.json` / `tasks.json` | Optional: Configure debugging and task automation in VS Code                              |

You may find a `.vscode/settings.json` that has formatting rules too (VS Code formatting settings) while referring to Prettier to take over formatting rules:
```
{
  "editor.formatOnSave": true,
  "editor.defaultFormatter": "esbenp.prettier-vscode",
  "files.eol": "\n",
  "editor.tabSize": 2,
  "editor.insertSpaces": true,
  "editor.trimAutoWhitespace": true
}
```

^ The prettier takes precedence over conflicting rules. However, there are some rules that prettier lack, so it won't override settings.json's:
- editor.tabSize
- editor.insertSpaces
- files.insertFinalNewline