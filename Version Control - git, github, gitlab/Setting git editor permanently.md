When running commands like `git rebase -i HEAD~10`, it'll open an editor so you can tell git what you're doing more specifically.

---

Setting VS Code permanently
```
git config --global core.editor "code --wait"  
```

---


Unsetting VS Code:
```
git config --global core.editor "vim"  
```

Or make core.editor blank
If it returned blank, then it’ll use the default, likely vim (console editor)

---

Can check current one with:
```
git config --global --get core.editor  
```


