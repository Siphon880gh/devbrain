### ✅ `git commit -a...` (git commit -am MESSAGE)

- **Meaning**: Automatically stages **modifications and deletions** of _tracked_ files before committing.
- **Does NOT stage**: New, untracked files (you still need to use `git add` for those).
- **Common usage**:
    
    ```bash
    git commit -am "Your commit message"
    ```
    
    The `-m` flag lets you include the commit message inline.
    

---

### ⚠️ Caveat

If you have new files, you have to stage them first with `git add -A`, before running `git commit -am MESSAGE`