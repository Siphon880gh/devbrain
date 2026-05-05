
Which shell you're using?

At the top titlebar:
![[Pasted image 20250517060638.png]]

---

### For macOS:

- **`.zprofile`** runs **first** (login shell)
- **`.zshrc`** runs **after** (interactive shell)

### ✅ Recommendation:

Edit **both**:

- Put **env vars / PATH** changes, if based on user, in `.zprofile`
- Put **aliases / UI tweaks**, because they're system wide regardless of its based on user, in `.zshrc`   
- Obviously exceptions where to put where applies. Just remember zprofile is for user shells and zshrc is for anyone's shell
  

They often both load when opening Terminal, so use them for their intended roles.

---

**Best Practice for Shell Config Files on macOS (Zshell)**

For clarity, add echo statements at the top of each shell config file to confirm which ones are being loaded when a terminal session starts. For example:

```
echo "Loaded .zshrc"  
```

If your terminal uses Zsh (the default on modern macOS) but you also have `.bash_profile` or `.bashrc` in your home directory, it’s a good idea to ensure continuity by having Zsh source them:

In `.zprofile`, add at the very bottom:
```
[ -f ~/.bash_profile ] && source ~/.bash_profile  
```
  

In `.zshrc`, add at the very bottom:
```
[ -f ~/.bashrc ] && source ~/.bashrc  
```

This ensures any legacy settings from Bash are still applied when using Zsh.

When opening terminal, because it's a zshell terminal that's automatically logged in as the Mac user, you'll see on a new terminal sesion:
```
Loaded .z_profile  
Loaded .zshrc  
```

Optionally there may be bash settings that load:
```
Loaded .z_profile  
Loaded .bash_profile  
Loaded .zshrc  
Loaded .bashrc
```