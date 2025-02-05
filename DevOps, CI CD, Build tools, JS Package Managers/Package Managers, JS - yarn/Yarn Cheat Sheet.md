# 📌 Yarn Cheat Sheet

## 🔹 **Basic Commands**
- Initialize a new project:
  ```sh
  yarn init -y
  ```
- Install all dependencies:
  ```sh
  yarn install
  ```
- Add a package:
  ```sh
  yarn add <package>
  ```
- Add a package with a specific version:
  ```sh
  yarn add <package>@<version>
  ```
- Remove a package:
  ```sh
  yarn remove <package>
  ```
- Upgrade all dependencies:
  ```sh
  yarn upgrade
  ```
- Upgrade a specific package:
  ```sh
  yarn upgrade <package>
  ```

## 🔹 **Global Commands**
- Add a global package:
  ```sh
  yarn global add <package>
  ```
- Remove a global package:
  ```sh
  yarn global remove <package>
  ```
- List globally installed packages:
  ```sh
  yarn global list
  ```

## 🔹 **Dependency Management**
- Check outdated dependencies:
  ```sh
  yarn outdated
  ```
- Check why a package is installed:
  ```sh
  yarn why <package>
  ```
- Clean cache:
  ```sh
  yarn cache clean
  ```

## 🔹 **Workspaces (Monorepo Support)**
- Enable workspaces in `package.json`:
  ```json
  {
    "workspaces": ["packages/*"]
  }
  ```
- Install dependencies across workspaces:
  ```sh
  yarn install
  ```
- Add a package to a specific workspace:
  ```sh
  yarn workspace <workspace-name> add <package>
  ```
- Run a script in a workspace:
  ```sh
  yarn workspace <workspace-name> run <script>
  ```

## 🔹 **Running Scripts**
- Run a script defined in `package.json`:
  ```sh
  yarn run <script>
  ```
- Shorter alternative:
  ```sh
  yarn <script>
  ```
- Run scripts concurrently:
  ```sh
  yarn run <script1> & yarn run <script2>
  ```

## 🔹 **Security & Audit**
- Run security audit:
  ```sh
  yarn audit
  ```
- Fix vulnerabilities automatically:
  ```sh
  yarn audit --fix
  ```

## 🔹 **Common Fixes**
- Delete `node_modules` and reinstall dependencies:
  ```sh
  rm -rf node_modules && yarn install
  ```
- Rebuild the lockfile:
  ```sh
  yarn install --force
  ```
- Verify package integrity:
  ```sh
  yarn check --integrity
  ```

