
Titled: Remove private key from a previous commit and propagate it to the head

Problem statement: You received an email from Github, Google, AWS, etc that you exposed an API key in your github repo. They might threaten to disable your API if you don't take care of it. Your company's secrets may be being exposed. And to top it off, the exposed key or secrets is in a previous commit that can be browsed to on the online github repo. You have to remove the key in the past commits all the way up to the present commit.

Solution is to checkout a few commits until you can narrow down the commit where you first exposed the private key. Then you rebase-edit from that point on, removing the private key from that commit all the way to the head. In addition, you want to preserve the commit times, author names, and author contacts. These are the instructions.

---

Open the offending folder locally in VS Code. You will perform rebase in interactive mode, performing an edit command, and possibly performing merge conflicts inside VS Code. If you need a review of git merging, refer to [[Git Merging Basics (VS Code)]].

Git log one line for 100 commits back or further, with dates, and save to an a.txt outside the local repo
```
git log --pretty=format:"%h %ad %s" --date=short -n 100 > ../a.txt
```

Open a.txt to see commits
```
code ../a.txt
```

Looking at the commit list (`a.text`), take a guess which commit hash ID is the commit that may be the first time the private key was exposed:
```
git checkout <commitHashID>
```

Then perform a grep to see if the private key is exposed. For example, here our keyword is SECRET - note we are excluding node_modules etc:
```
grep -nriI ./ --exclude={.git,\*.sql,package-lock.json,webpack.config.js,composer.lock,\*.chunk.css,\*.chunk.js,\*.css.map,\*.js.map} --exclude-dir={.git,.git/index,bower_components,node_modules,.sass-cache,vendor\*,\*backup\*,\*cached\*} -e "SECRET"
```

You'll want to continue checking out multiple commit Ids until you can narrow the 1st commit that the key has been exposed. For example, if a commit checkout doesn't grep for the keyword, then checkout a more recent commit. If a commit checkout does grep for the keyword, then checkout an earlier commit. Once you find one commit that has the key exposed but the commit before it is missing the key, then that's exactly the commit you need (the one where it first exposes the key).

Once you have the correct commit:
- Note down the commit hash ID AND the commit message title (because the hash ID will change once you rebase later, and you might need to reference back to this point).
- Make sure to exit the detached head, eg. `git checkout master` or `git checkout main`. This is absolutely must because we will be rebasing soon.

Now we rebase in such a way that the rebase list goes up to approximately where the interested commit is, and we want to preserve the commit times instead of them overriding to the present time:
```
git rebase -i COMMIT_ID~1 --committer-date-is-author-date
```
^ Do not skip the `~1` or it'd be the next commit forward.

In the rebase list, often times your interested commit will be at the top. If it's in vi/vim editor, type `/` then search for the interested commit's message title. If not found, then exit without saving (and you can run `git rebase --abort` to be sure). Then adjust the `~1` to a larger number.

If you find the interested commit in the rebase list, change the "pick" command to "edit" (If vi/vim editor, go into insertion mode pressing 'a', then go back into command mode by pressing Escape, then spell out the commands `:wq`)

After the rebase list is saved with an edit command, you are officially at the point in time at the interested commit. Make the appropriate changes to remove the private key, perhaps introducing environmental variables that are gitignored.

Once your file changes are done, then apply the changes to the edit commit and propagate the changes to the present time:
```
git add -A;
git commit --amend;
git rebase --continue;
```

Solve any merge conflicts as it reconciles all the commits from the interested commit to the present time commit
- You can review how to merge in VS Code: [[Git Merging Basics (VS Code)]].
- Checkpoint: If there are too many commits to review merge conflicts (eg. 100 commits with merge conflicts), you may want to discuss with your team about "fudging" the history. You can automatically accept all current changes up to the present time, then copy over a accurate backup, and commit those changes as the true merge conflicts in the present - refer to: [[Rebase after edit has many commits with merge conflicts - Shortcut the merge conflicts into one commit]]

When successfully done, the private key is nuked from your commit history. Push up to the repo but as with all rebase-edited commits, you'll have to push it up forcefully to rewrite the browsable commit contents:
```
git push origin main --force
```

When you go back to your email warning, you can click their link (if available) and still visit the commit and file with the private key still exposed, however Github will eventually purge this page. This page CANNOT be visited from your repo's main webpage commit history anymore, which is the intention. If you want certainty, copy the commit hash ID from this detached commit page, then visit your repo's main webpage, and see if you can search for that commit hash ID - you shouldn't be able to.