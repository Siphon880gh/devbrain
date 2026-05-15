  

Sometimes you rename a file or folder by changing only the letter casing, such as:

```
components/header.js
```

to:

```
components/Header.js
```
  
You stage then commited, but the filename change doesn’t get reflected at [github.com](https://github.com "https://github.com") repo. It’s going to be a problem when a team member pulls in your files and your code references the new uppercased filename.
## Why this happens

Git may still have the old filename or folder name cached in its index. So even though you changed the casing locally, Git may still think the old version exists.

To fix this, you can remove Git’s cached tracking information and then re-add the files.

## The fix

Run this from the root of your repo:
```
git rm -r --cached .
git add --all .

git commit -a -m "Fixing file name casing"
git push origin main
```

You can replace `.` with a specific folder name if you only want to fix part of the repo:
```
git rm -r --cached path/to/folder
git add --all path/to/folder
```

## What the command actually does

This command:
```
git rm -r --cached .
```

removes files from Git’s index, meaning Git “forgets” the cached version of the filenames and folder names it was tracking.

Important: it does **not** delete your local files.

Your files stay in the current folder exactly as they are. Git simply clears its cached view of them.

Then this command:
```
git add --all .
```

adds everything back using the current filenames and folder names from your local file system.

After that, Git can detect that the old wrong-case files or folders no longer exist, so `git status` may show them as deleted and re-added with the corrected casing.

Once you commit and push, GitHub should update the repo and remove the old incorrectly cased files or folders.

## What not to do

You might think this is a permanent fix:

```
git config core.ignorecase false
```

But this is usually **not recommended** on a case-insensitive file system, such as the default setup on macOS or Windows.

Setting `core.ignorecase` to `false` can cause strange Git behavior, including:

```
spurious conflicts
duplicate files
confusing rename behavior
```

For example, renaming a file by changing only the letter casing may cause Git to think there are two different files, even though your operating system treats them as the same file.
## Safer takeaway

For casing-only filename or folder changes, the safer fix is usually:

```
git rm -r --cached .
git add --all .
git commit -a -m "Fixing file name casing"
git push origin main
```