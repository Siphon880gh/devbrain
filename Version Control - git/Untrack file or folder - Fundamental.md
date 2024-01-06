Untrack file or folder

## Not tracked yet
Before making your first commit, untrack the file by adding it to .gitignore:
```
echo "FILENAME" >> .gitignore
```

## Already tracked
If the file was already tracked by git, then remove the tracking from cache, add it to .gitignore, and then commit again.
```
git rm -r --cached FILENAME
echo "FILENAME" >> .gitignore
git add -A
git commit -m "YOUR_MESSAGE"
```

The file may still be in multiiple older commits.

Show all commits:
```
git log --online
```

Go between checking out an old commit and going back to current commit:
```
git checkout OLD_COMMIT_HASH
git checkout master
```

Find out the first commit that started tracking the file. Then following the lesson on rewrite commit history, rebase from that commit onwards. Then the file will be removed from all commits. Note that instead of git add -A:
```
git rm -r cached FILE_NAME
git commit --amend
git rebase --continue
```

You may have to delete the file, then run the above commands.
