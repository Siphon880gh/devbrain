
`nvm` doesn't auto-switch to the desired node version that you defined in the folder's `.nvmrc` **by default**, but you can enable it using your shell’s configuration.

Add these to the top of your `~/.zshrc` or `~/.bashrc`:

✅ 1. Load `nvm` first  

```
export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"  
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
```

---

✅ 2. Then add the `.nvmrc` auto-switch code

After where it loaded NVM, add this:

```
autoload -U add-zsh-hook  
  
load-nvmrc() {  
  local nvmrc_path  
  nvmrc_path="$(nvm_find_nvmrc)"  
  
  if [ -n "$nvmrc_path" ]; then  
    local nvmrc_node_version  
    nvmrc_node_version=$(cat "$nvmrc_path")  
  
    if [ "$nvmrc_node_version" = "system" ]; then  
      nvm use system  
    elif [ "$(nvm version)" != "$nvmrc_node_version" ]; then  
      nvm use "$nvmrc_node_version"  
    fi  
  fi  
}  
  
add-zsh-hook chpwd load-nvmrc  
load-nvmrc  
```

---

**💡 What This Does**

Any time you `cd` into a folder with an `.nvmrc`, your shell will auto-switch to the specified Node.js version. You’ll see a message like:

```
% cd legacy
Now using node v12.18.1 (npm v6.14.5)
```

This behavior can be helpful (or a bit noisy), but it ensures you're using the right Node version per project. The noisy part is switching to deeper folders from the one root folder that has .nvmrc, it still displays the message every time you cd.

---

**NPM script limitation and workaround**

`nvm` does **not** automatically switch Node versions when an `npm` script internally runs a `cd` command.

Here’s why:
- The `.nvmrc` auto-switch logic works in **interactive shells** (like when you manually use `cd` in your terminal).
- But `npm run` scripts typically run in **non-interactive** subshells, and they don’t trigger `zsh` or `bash` hooks like `chpwd`. Unfortunately, adding the nvm init code into .bashrc or .zshrc doesn't reliably work for npm run scripts either.
- So even if your script does something like `cd subdir && npm start`, the Node version **will not change** automatically based on a `.nvmrc` in that `subdir`.
- Workaround below.

🔧 **Workaround**

Let's say your file tree is (`tree -a`):
```
.
├── nvm-run.sh
├── package-lock.json
├── package.json
└── test
    ├── .nvmrc
    └── package.json
```

Your root package.json:
```json
"scripts": {
   "start": "cd test && ../nvm-run.sh && npm run serve"
}
```

Your subdirectory package.json:
```
  "scripts": {
    "serve": "echo \"Serving!\""
  },
```

Let's say our subdirectory "test/" has a .nvm file:
```
12.18.1
```

You must place a `nvm-run.sh` at root:
```
#!/bin/bash
export NVM_DIR="$HOME/.nvm"
. "$NVM_DIR/nvm.sh"
nvm use
exec "$@"
```
^ [ ] Make sure to chmod the `nvm-run.sh` file to allow execution
^ You can't rely on .bashrc or .zshrc to work with npm one-liner scripts. But this .sh file works around that.

Now when you run at the root directory:
```
npm run start
```

^ Output: That should cd into the subdirectory, switch node version, and run serve as expected:
```
% npm run start       

> nvm@1.0.0 start /Users/wengffung/dev/nvm
> cd test && ../nvm-run.sh && npm run serve

Found '/Users/wengffung/dev/nvm/test/.nvmrc' with version <12.18.1>
Now using node v12.18.1 (npm v6.14.5)

> test@1.0.0 serve /Users/wengffung/dev/nvm/test
> echo "Serving!"

Serving!
```