## When a rebase is in progress and not finalized yet

You can cancel the rebase with:
```
git rebase --abort
```

## Already rebased to the HEAD and I want to reverse all the rebasing
If it already rebased to the HEAD successfully, you can still undo all the rebasing:
```
git reflog
```

Then pay attention to the ref logs carefully. It can indicate when you made commits and when you "edit" a commit. Copy the hash so you can checkout. Try to find the commit you were on before you did any rebases. Then use `git checkout <HASH>`. If you are satisfied, then do a hard reset back to that hash:
```
git reset --hard <HASH>
```
