Errors as:
![[Pasted image 20260523055434.png]]

Note what files you have modified since the last update. Use the Last modified column in Finder (Mac) for help. Make backups. You certainly will restore those files. Unfortunately some folders look like they last updated based on when Google Drive, for example, synced. But if you go into the folder, you'll see if that's the case, the other files and folders are older.

Delete the folder containing the bugged file:
![[Pasted image 20260523055312.png]]

Then clone your repo in a separate folder. Copy it's .git over your current .git where it's bugged

Then run:
```
git stash
```

Restore all other files from your backup that hasn't made it to git push.

Now add and commit and push up.