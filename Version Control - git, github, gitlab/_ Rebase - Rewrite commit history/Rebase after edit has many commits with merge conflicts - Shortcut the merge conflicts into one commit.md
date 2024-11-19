If you have too many merge conflicts between many commits when you rebase, you can forcefully rebase...

You would make a copy of the folder (like cp -r folder folder1) because at the end of the rebase, you will copy over the files, then make a commit message “Retrospectively fixed merge conflicts”.

Perform this in VS Code which gives a friendly interface to handle merge conflicts.

Firstly you may want to rebase by preserving the commit dates (so your rebased commits dont all say now):
```
git rebase -i ... --committer-date-is-author-date
```

Where the ... is up to you, could be `HEAD~100` for example. Preserving author name and contact is by default so no option for it needed.

Then when it complains of merge conflicts, open the Source Control tab:
![](https://i.imgur.com/qAE9hH0.png)

Select all files marked to have merge conflicts (exclamation mark). Here it’s all selected and we right click to:

1. Accept All Current  
2. Then Stage Changes

OR automate steps 1 and 2 by running this command in the VS Code terminal:
```
git checkout --ours . && git add . && git commit --no-edit
```
^ That accepts all current (--ours), then stages the files, then commits without opening any editor! This could skip steps 1 and 2 of right-clicking, clicking the option, etc etc.

3. Then we click “Continue” (You may have to do this step even entering the command, so press up on your terminal to spam the command, and click the mouse that’s been hovered over the Continue button)

At the next merge conflicts, we do the same.

At the end of the rebase, erase all contents inside the folder except .git folder. Then copy over the contents of folder1 except for .git and node_modules into your folder. Then make a commit message “Retrospectively fixed merge conflicts”.

Your historic commits may be incorrect to some extent, so this is done when you have NO time to handle merge conflicts from hundreds of commits. This could happen when you had to rebase-edit an old commit to remove a secret key that Github or Google detected (and therefore emailed you), and that caused the conflicts