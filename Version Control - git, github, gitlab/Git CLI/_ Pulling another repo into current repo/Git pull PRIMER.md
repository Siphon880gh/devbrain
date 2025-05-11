
Run
```
git pull origin main
```

Then the current folder will receive the repo designated by `origin`, in particular, the commits of the branch `main` up to the tip or head.

---

Quick Reviews

You may be advised to resolve merge conflicts if the pulling has some difficulties. You can refer to [[Git Merging Basics (VS Code)]]

You can change the assignment or origin with:
```
git remote set-url origin NEW_URI_OR_SSH
```

But if origin was never a "bookmark" in your current local repo:
```
git remote add origin NEW_URI_OR_SSH
```