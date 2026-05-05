`nvm` doesn't auto-switch to the desired node version that you defined in the folder's `.nvmrc` **by default**, but you can enable it using your shell’s configuration.

---

To switch Node versions automatically when you change folders, add a small shell hook to your profile file. This checks for a `.nvmrc` file whenever you use `cd`.

## 1) Open your shell profile

Edit the right file for your shell:

- **Zsh** (default on macOS): `~/.zshrc`
- **Bash**: `~/.bashrc` or `~/.bash_profile`

## 2) Add the auto-switch script

Paste one of these at the very bottom of the file.

**For Zsh:**

```bash
# Auto-switch Node version using .nvmrc
autoload -U add-zsh-hook

load-nvmrc() {
  local node_version="$(nvm version)"
  local nvmrc_path="$(nvm_find_nvmrc)"

  if [ -n "$nvmrc_path" ]; then
    local nvmrc_node_version
    nvmrc_node_version=$(nvm version "$(cat "${nvmrc_path}")")

    if [ "$nvmrc_node_version" = "N/A" ]; then
      nvm install
    elif [ "$nvmrc_node_version" != "$node_version" ]; then
      nvm use
    fi
  elif [ "$node_version" != "$(nvm version default)" ]; then
    echo "Reverting to nvm default version"
    nvm use default
  fi
}

add-zsh-hook chpwd load-nvmrc
load-nvmrc
```

**For Bash:**

```bash
# Auto-switch Node version using .nvmrc
cdnvm() {
  command cd "$@" || return
  [[ -f .nvmrc ]] && nvm use
}

alias cd='cdnvm'
```

## 3) Reload your shell

Run the command for your shell:

- **Zsh:** `source ~/.zshrc`
    
- **Bash:** `source ~/.bashrc`
    

## Notes

- The **Zsh** version is more complete. It can switch automatically when entering a project and switch back to your default version when leaving it.
    
- If the version in `.nvmrc` is not installed yet, the Zsh script can run `nvm install` for you.
    
- Some developers prefer switching manually, but this is a common local development setup.
    

If you get an `nvm: command not found` error after adding this, your NVM init script may be missing from your profile.