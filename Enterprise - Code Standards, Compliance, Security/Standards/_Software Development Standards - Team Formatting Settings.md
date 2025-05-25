# 👨‍💻 Team Code Formatting & VS Code Configuration Guide

Maintaining a consistent, auto-formatted codebase improves readability, reduces friction in code reviews, and minimizes "chore commits" for simple formatting issues. This guide helps you and your team align your development environment using **VS Code**, **Prettier**, and shared project-level configurations.

---

## 🔍 Why This Matters

- Inconsistent formatting (like pasted CSS with 4-space indentation in a 2-space project) creates unnecessary Git diffs and cluttered code reviews.
    
- It’s a waste of time to fix style issues manually or call them out in reviews.
    
- By automating formatting and aligning settings, every teammate writes clean code **automatically**—without thinking about it.
    

---

## 🧰 Tools We’ll Use

|File / Tool|Purpose|
|---|---|
|`.editorconfig`|Cross-editor formatting rules|
|`.prettierrc`|Project-wide Prettier configuration|
|`.prettierignore`|Files/folders to exclude from formatting|
|`.vscode/settings.json`|VS Code project settings (e.g., format on save)|
|`.vscode/extensions.json`|Extension recommendations (not enforced)|
|`npm run format`|Manual formatting via terminal|
|`Husky + lint-staged`|Optional: Format files before Git commits|
|`launch.json` / `tasks.json`|Optional: Configure debugging and task automation in VS Code|

---

## ⚙️ Step-by-Step Setup

### 1. Install Prettier Locally

```bash
npm install --save-dev prettier
```

This installs Prettier as a local dev dependency, ensuring the same version is used across all environments (CLI, CI, and editor plugins).

---

### 2. Install Prettier Extension in VS Code

Prettier **does not work automatically** in VS Code. Developers must install this extension:

- **Name:** Prettier – Code formatter
    
- **ID:** `esbenp.prettier-vscode`
    

> Without this, VS Code will not auto-format based on your `.prettierrc`.

---

### 3. Enable Format on Save

Create `.vscode/settings.json`:

```json
{
  "editor.formatOnSave": true,
  "editor.defaultFormatter": "esbenp.prettier-vscode",
  "files.eol": "\n",
  "editor.tabSize": 2,
  "editor.insertSpaces": true,
  "editor.trimAutoWhitespace": true
}
```

✅ These settings apply automatically when the project is opened in VS Code.

❌ They do not force extension installation or override the user’s personal settings.

---

### 4. Recommend Extensions to Your Team

Create `.vscode/extensions.json`:

```json
{
  "recommendations": [
    "esbenp.prettier-vscode",
    "dbaeumer.vscode-eslint"
  ]
}
```

🔔 VS Code will prompt team members to install these when they open the project folder.

---

### 5. Add a Format Script to `package.json`

```json
"scripts": {
  "format": "prettier --write ."
}
```

This allows manual formatting via:

```bash
npm run format
```

> Helpful in CI pipelines or for batch formatting.

---

### 6. (Optional) Enforce Formatting Before Git Commits

```bash
npm install --save-dev husky lint-staged
```

In `package.json`:

```json
"lint-staged": {
  "*.{js,ts,jsx,tsx,json,css,md}": "prettier --write"
}
```

This auto-formats staged files during `git commit`.

---

## 📁 Suggested Config Files

### 🔧 `.editorconfig`

```ini
root = true

[*]
charset = utf-8
indent_style = space
indent_size = 2
end_of_line = lf
insert_final_newline = true
trim_trailing_whitespace = true
```

---

### 🎯 `.prettierrc`

```json
{
  "semi": true,
  "singleQuote": true,
  "tabWidth": 2,
  "trailingComma": "es5",
  "printWidth": 80,
  "endOfLine": "lf"
}
```

---

### 🚫 `.prettierignore`

```
node_modules
dist
build
coverage
*.min.js
*.bundle.js
```

---

### 💼 `.vscode/settings.json`

```json
{
  "editor.formatOnSave": true,
  "editor.defaultFormatter": "esbenp.prettier-vscode",
  "files.eol": "\n",
  "editor.tabSize": 2,
  "editor.insertSpaces": true,
  "editor.trimAutoWhitespace": true
}
```

---

### 🧩 `.vscode/extensions.json`

```json
{
  "recommendations": [
    "esbenp.prettier-vscode",
    "dbaeumer.vscode-eslint"
  ]
}
```

---

## 🚀 Optional: Advanced VS Code Workspace Setup

If your team is using **VS Code’s built-in debugger** or wants to automate common scripts, these files can help:

---

### 🧨 `.vscode/launch.json` – Debug Configuration

```json
{
  "version": "0.2.0",
  "configurations": [
    {
      "type": "node",
      "request": "launch",
      "name": "Launch App",
      "program": "${workspaceFolder}/src/index.js",
      "env": {
        "NODE_ENV": "development"
      }
    }
  ]
}
```

> Trigger from the **Run & Debug** sidebar. Great for Node.js, TypeScript, or frontend frameworks.

---

### 🛠 `.vscode/tasks.json` – Custom Task Automation

```json
{
  "version": "2.0.0",
  "tasks": [
    {
      "label": "Start Dev Server",
      "type": "shell",
      "command": "npm run start:dev",
      "group": "build",
      "problemMatcher": []
    }
  ]
}
```

> Trigger via `Terminal → Run Task...`. Useful for npm scripts, builds, or test runners.

---

## ✅ Final Summary

|Item|Required|Description|
|---|---|---|
|Install Prettier (`npm`)|✅|Ensures consistent version across tools|
|Prettier extension for VS Code|✅|Enables actual formatting in editor|
|`.vscode/settings.json`|✅|Enables format on save and unified style|
|`.editorconfig`|✅|Editor-agnostic baseline formatting|
|`.prettierrc` / `.prettierignore`|✅|Define and enforce formatting rules|
|`.vscode/extensions.json`|🚫|Helps teammates install the right tools|
|Format script (`npm run format`)|🚫|Helpful for CI and batch formatting|
|Husky + lint-staged|🚫|Optional Git hook automation|
|`launch.json` / `tasks.json`|🚫|Optional: enhance debugging & workflow|

---

Let me know if you'd like this exported to Markdown, PDF, or bundled into a starter repo scaffold.