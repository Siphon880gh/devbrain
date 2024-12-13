Compare two commits for their differences
```
git diff <COMMIT-OLDER> <COMMIT-NEWER>
```

Compare any older commit to current commit
```
git diff <COMMIT-OLDER> HEAD
```

Compare the prevous commit to current commit
```
git diff HEAD^ HEAD
```

If you don't like eyeballing the text in cli, you can always add+ ` > diff.txt` after the command then open the new `diff.txt` file.

---

If you don't want the details of what lines are changed, but want a glance of the files modified/deleted/added, refer to: [[Git Common Need - Show files that are modified, deleted, and created from previous commit]]