You can rewrite the git commits that show up with `git log` or when you push to the git repository. After you rewrite, you'd have to push to the repository in forced mode if you have the permissions: `git push master origin --force`. But that is considered disruptive if you have other contributors on your repository. In addition to changing git commit messages, you can merge two commits, you can edit the code back in any commit and it'll resolve conflicts back to the head.

## Show commits you can change
git rebase interactively from first commit
```
git rebase -i --root
```

Note: "--root" rebases from the first commit ever. Not from the first commit in the branch. For that, the command may be at:
https://stackoverflow.com/questions/363908/how-do-i-use-git-rebase-i-to-rebase-all-changes-in-a-branch


If too many commits appearing on the screen, you can limit to number of commits back. Use as many ^ as you want to go back. It'll error if you try to show more commits than there is in history:
```
git rebase -i HEAD^^^
```

Or equivalent of (Github must have realized that having to type many ^ is a poor developer experience):
```
git rebase -i HEAD~3
```

If you need how many commits are at the current branch for the above command:
```
git rev-list --count HEAD
```

## Git then lists the commits in a temporarily opened text file for you to rewrite in vi cli text editor. Read lesson on vi text editor.

## Simple commit history changes
Merge up: Let's say you have commit A and B in consecutive order. You can merge up commit B onto commit A by replacing "pick" on commit B:
```
fixup
```

Merge down: Let's say you have commit A and B in consecutive order. You can merge down commit A onto commit B by replacing "pick" on commit A:
```
squash
```

You can change a commit message by replacing "pick" with "reword" on the commit:
```
reword
```

For the fixup, squash, reword, you have to :wq to save that text on the terminal so git can process your wanted changes. You can :q! if you want to cancel it all.

## Edit a commit's codebase
The more complicated one is going back to a commit and rewriting the code. You can do this by replacing "pick" with "edit":
```
edit
```

Now you can call `git log` to confirm you are on that commit in the past. Now you can go into the code and change what you wanted to be from that commit onwards to the HEAD. I recommend doing code changes on Visual Code and you'll see why later because it makes managing current and incoming changes on merge conflicts easier.

After making the code changes, you can decide to make an extra commit after the curret commit or you can override the current commit.

Override the current commit, making sure you run this in the Visual Code terminal:
```
git add -A
git commit -amend
git rebase --continue
```

If you want to insert a commit after the current commit, making sure you run this in the Visual Code terminal:
```
git add -A; 
git commit "Below the commit you ran edit on"
git rebase --continue
```

Visual Code might complain about merge conflicts, and you'll see which commit this merge conflict is at. Open up the Source Control tab on the left. Then you can see any files that have conflicts, and right click to accept current changes or incoming changes. You can undo with CMD+Z afterwards if you change your mind.

Visual Code might complain about the merge conflicts multiple times as it tries to force your code on the commit you wrote "edit" on up to and including all the commits along the way to Head. So make sure to look at the Visual Code terminal on what commit name has that merge conflict, then resolve the conflict at the Source Control tab.

If you want to abort all of the code and commit changes before it rebases to the HEAD successfully, you can run:
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
