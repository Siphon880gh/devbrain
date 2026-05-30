
Just like you have strict coding standards that makes sure all developers on your team creates quality code that's less likely to have errors, you can create such strict coding standards in the form of config files (like linters, etc) and Cursor AI will be augmented with them.

Prompt:
```
Please generate a comprehensive development standards guide that focuses on **error mitigation**, code consistency, and best practices for a TypeScript project. Specifically, I need:

1. A strict ESLint configuration (`.eslintrc`) with recommended rules to catch common pitfalls.
2. A robust TypeScript configuration (`tsconfig.json`) that enables strict type-checking and helpful compiler options.
3. A Prettier configuration (`.prettierrc`) to maintain a uniform code style.
4. **Directory structure** recommendations for organizing code (e.g., components, services, tests).
5. **Naming conventions** for files, classes, interfaces, variables, and functions.
6. **Commit message guidelines** (e.g., Conventional Commits) and any relevant CI/CD integration.
7. Details on **Git hooks** using Husky and lint-staged to automate formatting and lint checks before commits.
8. A **testing strategy** (e.g., Jest) with recommended coverage thresholds and test folder structure.
9. **Documentation standards** with TSDoc/JSDoc for TypeScript.
10. **Error handling and logging** best practices.
11. Any recommended **security** guidelines for handling secrets, environment variables, etc.
12. Suggested **VS Code settings** or other editor configurations to ensure consistency.
```