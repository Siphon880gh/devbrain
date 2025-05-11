## Proper Fix

Depending on the OS, you may find that changing a case on a filename (eg. lowercase to uppercase) will be ignored when trying to commit:


You renamed README.md to Readme.md then try to commit:
```
git add -A
git commit -m "A commit"
```

But you get this message:
```
On branch main
nothing to commit, working tree clean
```

You have to also rename the casing in git's local copy since by default the git is ignoring case on modifications (Here we run this to match what's already on file storage - Readme.md):
```
git mv README.md Readme.md
```


Some OS may require --force
```
git mv README.md Readme.md --force
```

Now you can commit successfully.

---


## Quick and dirty fix

You can rename the file by adding a 1 or some variation to the filename: 
README.md -> README1.md

Make a commit

Then you can rename it to the desired casing:
README1.md -> Readme.md

---

## Default

In order to have the git NOT ignore case on modifications, change the default for git:
```
git config --global core.ignorecase false
```

But if your local repo itself already has that setting, you have to run it locally too, otherwise the repo will override the global setting:
```
git config --local core.ignorecase false
```

---


Learned from:
https://stackoverflow.com/questions/10523849/how-do-you-change-the-capitalization-of-filenames-in-git