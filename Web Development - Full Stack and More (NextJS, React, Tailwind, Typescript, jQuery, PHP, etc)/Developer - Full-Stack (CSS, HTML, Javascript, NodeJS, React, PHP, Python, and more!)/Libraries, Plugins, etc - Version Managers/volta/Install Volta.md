
🚀 Installing Volta  

Volta is a simple, cross-platform tool. One command installs it:

### 🖥 macOS / Linux

```
curl https://get.volta.sh | bash  
```

Then restart your terminal or run `source ~/.bashrc` or `~/.zshrc` depending on your shell .

### 🪟 Windows

- Use the [official MSI installer](https://volta.sh/)
- Works seamlessly in PowerShell and CMD
    

---

## ✅ Verifying Installation


```
volta --version  
```

You should also now have managed versions for Node, npm, and Yarn. For example:

```
volta install node@18  
volta install yarn@1  
```

These pin the versions globally for your user account.

---

## 📦 Pinning Node per Project

Add this to your `package.json` in any folder:
```
"volta": {  
  "node": "16.20.0",  
  "yarn": "1.22.19"  
}  
```


Volta will:
- Use this version automatically when you `cd` into the folder
- Enforce the version when running any tool (like `yarn`, `npm`, `node`, etc.)

---

## 🧠 Switching Node Versions _Mid-Build_ in a Yarn Workspaces Monorepo

Yarn workspaces run all scripts with the current shell’s Node version — but you can override that **per command** using `volta run`.

---

### 📁 Structure Example

project/  
├── package.json                 # root, with "workspaces"  
├── packages/  
│   ├── webchat/                 # requires Node 18  
│   │   ├── package.json         # volta.node = 18  
│   └── messaging/               # requires Node 16  
│       ├── package.json         # volta.node = 16  

---

### 🧩 Script to Build with Different Node Versions

You can write a npm script like:
```
"scripts": {  
  "build": "volta run --node 16 yarn workspace @botpress/messaging build && volta run --node 18 yarn workspace @botpress/webchat build"  
}  
```

✅ Volta ensures each command runs with the correct Node version — no shell reloading, no context switching, no `.nvmrc`.

---

### 🔥 Why This Is Powerful

- Seamlessly mix different Node versions per package
- Run everything from the root (CI pipelines, dev scripts, etc.)
- No more "nvm: command not found" or shell sourcing bugs

---

## ✅ Summary

| Feature                         | Volta                    |
| ------------------------------- | ------------------------ |
| Cross-platform                  | ✅ Yes                    |
| No shell setup                  | ✅ Yes                    |
| Mid-script Node switching       | ✅ Yes (with `volta run`) |
| Yarn workspace compatible       | ✅ Yes                    |
| Replaces `.nvmrc` + shell hooks | ✅ 100%                   |
