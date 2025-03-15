Renamed folder or file from lower case to upper case or uppercase to lower case, but when commiting, it says nothing to commit, or when pushed up, the new character cases are not showing.

This is because of case insensitivity. 

Two possible solutions:

---

METHOD 1 Switch and bait names
1. Rename by adding a character to the folder or file (Maybe add ellipsis at the end of the name). Make commit. Push up
2. Rename removing the extra character(s) and making sure to have the new casing. Make commit. Push up

---


OR METHOD 2 Removing from Git cache (**BEST**)
Remove the folder from Git cache by `cd`  into that folder on your terminal then running:
```
git rm -r --cached .
```

Don’t worry - this command does not remove the folder from your local system

Then cd out of the current folder and `git add -A` .

Now make a commit then push up. The case characters should show now.

---

**DO NOT** set git to not ignore case with `git config core.ignorecase false`  because it’ll commit the new case but keep the old case, creating duplicates.