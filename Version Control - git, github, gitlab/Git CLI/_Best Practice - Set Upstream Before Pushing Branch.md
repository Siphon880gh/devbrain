
You're pushing the current branch on the local computer to the remote repo of the same current branch.

---

But if you're tired of running `git push origin LOCAL_BRANCH_NAME` every time you push a new branch, you're not alone. You may just know the best practice.

When pushing a new local branch with `git push` or `git push origin`, Git often shows this message:

> The current branch has no upstream branch.  
> To push the current branch and set the remote as upstream, use:  
> `git push --set-upstream origin LOCAL_BRANCH_NAME`  

Either commands will work:
1:
```
git push --set-upstream origin LOCAL_BRANCH_NAME
```

Or 2:
```
git push -u origin LOCAL_BRANCH_NAME
```

Both commands do the same thing: they push the branch and set up tracking so that next time, you can just run:

```bash
git push
```

---

**Optional:** You can make this automatic for all new branches by setting:

```bash
git config --global push.autoSetupRemote true
```

That way, Git will auto-link new branches to the remote when you push them for the first time.

---

**QUICKER WAY / SOP for Handling New Branches Locally and Pushing Them Remotely**

You may want to adopt this habit when it's in your workflow to create new branches for new features on the local machine then later pushing to the remote repo. You will purposely trigger the error to make it easy for you to setup upstream so later pushes are simple.

1. You push the current branch to remote for the first time (the branch was never pushed before):
```
git push
```

2. So you see this message:
![[Pasted image 20250526072241.png]]

3. Just copy and paste the command it recommends:
![[Pasted image 20250526072255.png]]

4. Now you're setup to just run `git push`.