### ✂️ Cleaning Up: Pruning Old Branches After Merges

After successfully merging branches into `main`, your repository can start to fill up with old, unused branches. **Pruning** is the cleanup step to remove these stale branches—both locally and remotely—to keep your workspace tidy and reduce confusion.

#### 🔍 Find Merged Local Branches

To identify which local branches are safe to delete, use:

```bash
git branch --merged main
```

This lists all **local branches whose commits have already been merged into `main`**. These branches are safe to delete _if you no longer need them for ongoing work_.

#### 🗑️ Delete Local Merged Branches

Once identified, you can delete them with:

```bash
git branch -d branch-name
```

#### ☁️ Delete Remote Branches

If the branch was pushed to a remote, clean it up there too:

```bash
git push origin --delete branch-name
```

#### 🧹 Prune Deleted Remote References

Even after a remote branch is deleted, your local Git may still show it. To clean up these remote-tracking references:

```bash
git fetch --prune
```

---

### ✅ Why Prune?

- Keeps your branch list clean and easy to navigate
- Prevents confusion or accidental rebasing onto outdated branches
- Reduces noise in tools like GitHub/GitLab
- Encouraged after merge rounds or at the end of a sprint
    

> 🔁 Tip: Regular pruning is a simple habit that keeps your Git workflow efficient and your team organized.