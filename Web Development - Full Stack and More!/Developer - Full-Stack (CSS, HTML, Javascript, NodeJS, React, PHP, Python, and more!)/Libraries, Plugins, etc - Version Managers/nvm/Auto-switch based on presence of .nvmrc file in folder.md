
✅ 1. Load `nvm` first  

Add this at the top of your `~/.zshrc` or `~/.bashrc`:
```
export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"  
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"  # This loads nvm
```

---

### ✅ 2. Then add the `.nvmrc` auto-switch code

After loading NVM, add this:

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


Whats nice (or can be annoying, but sometimes necessary) is wherever there is .nvmrc and its recursive functions, running cd successfully will output the version:
```
% cd legacy  
Now using node v12.18.1 (npm v6.14.5)
```