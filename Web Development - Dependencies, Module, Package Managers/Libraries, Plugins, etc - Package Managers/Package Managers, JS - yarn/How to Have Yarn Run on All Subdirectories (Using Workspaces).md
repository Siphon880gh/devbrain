You want to when running `yarn` (or `yarn install`) at the root of a project, it automatically  runs `yarn install` across multiple subdirectories as well as the root folder. This is possible using **Yarn Workspaces**, a feature designed to manage monorepos with multiple packages.

### ✅ How It Works

If your root `package.json` includes the following:

```json
{
  "private": true,
  "workspaces": [
    "packages/*"
  ]
}
```

Then Yarn treats each folder under `packages/` as a workspace. Running `yarn` at the root will:

- Install dependencies for all sub-packages
    
- Run lifecycle scripts across all workspace packages (e.g. `postinstall`, if defined)
    

You may also find scripts like this in the root `package.json`:

```json
"scripts": {
  "build": "yarn workspace @org/some-package build"
}
```

These explicitly tell Yarn to run commands within a specific workspace folder.

---

### ⚠️ Limitation with Different Node Versions

If some workspace folders require a **different Node.js version** (e.g. they declare `engines.node` in their `package.json`), you'll run into issues—even if you're using `nvm`. That’s because:

- `nvm` doesn’t auto-switch versions inside nested folders when running a root-level command like `yarn install`.
    
- This can break builds or installs in sub-packages that expect a different Node version.
    

### ✅ Workaround: Use Volta

[Volta](https://volta.sh/) allows you to specify Node.js versions per command, making it a better fit for monorepos with mixed Node versions.

For example:

```bash
volta run --node 14.21.3 -- yarn workspace @org/some-package build
```

This runs the command using Node `14.21.3` only for that specific script execution—no manual switching or `.nvmrc` handling needed.