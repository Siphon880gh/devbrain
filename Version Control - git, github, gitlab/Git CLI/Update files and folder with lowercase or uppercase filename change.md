Renamed folder or file from lower case to upper case or uppercase to lower case, but when commiting, it says nothing to commit, or when pushed up, the new character cases are not showing.

This is because of case insensitivity. 

Two possible solutions:

---

METHOD 1 Switch and bait names
1. Rename by adding a character to the folder or file (Maybe add ellipsis at the end of the name). Make commit. Push up
2. Rename removing the extra character(s) and making sure to have the new casing. Make commit. Push up

---


OR METHOD 2 Removing from Git cache (**BEST**)

*Sneak peak: First `cd`ing  into that folder on your terminal then removing the "current folder" from the git cache:*

1. Cd into that folder you're renaming or the folder that contains the file you're renaming:
```
cd <the folder you're renaming>
```

2. Then remove from cache using the current folder (`.`):
```
git rm -r --cached .
```

*Don’t worry - this command does not remove the folder from your local system*

Now what you're doing is going to depend on if you renamed a folder (also when you renamed a folder) or file:
- If you're renaming file, you're fine. Just run `git add -A`.
- If you've already renamed the folder to the new uppercasing or lowercasing before you cd into that folder, then you can run: `git add -A` .
- But if you intend to rename the folder after you've cd out into it, make sure to cd out of the folder before your rename, then run `git add -A` (If too late, you may end up at "trash" directory" or your git adding will silently fail).

Now make a commit then push up. The case characters should show now (See at the remote repo webpage).

---

**DO NOT** set git to not ignore case with `git config core.ignorecase false`  because it’ll commit the new case on top of keeping the old case, creating duplicates of one that has the original casing and one with the new casing (Doubling your folder of files).