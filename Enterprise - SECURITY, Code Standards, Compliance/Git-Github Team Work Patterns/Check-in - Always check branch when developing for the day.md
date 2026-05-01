
Always make sure you are on the correct Git branch before starting work.

At the beginning of the day, run:

```bash
git branch
```

This helps confirm you did not get switched to the wrong branch earlier and forget to switch back. Also, certain git tasks will knock you out into a detached head state (Branch is not one that you or anyone created) without you knowing. Then you start making changes in the wrong place, make a few commits, and then realize you have to rebuild the history on the correct branch (hopefully switching to that branch then merging would work).

---

**Intervention when too late:**
- Then you start making changes in the wrong place, make a few commits, and then realize you have to rebuild the history on the correct branch (hopefully switching to that branch then merging would work)....

If a detached HEAD:
1. Create a new branch name like `git checkout -B temp`
2. Switch to desired branch `git checkout OUR_BRANCH_NAME`
3. Merge into the current desired branch: `git merge temp`
4. Resolve any merge conflicts with the other branch's commits merged in

If just on the wrong branch:
2. Switch to desired branch `git checkout OUR_BRANCH_NAME`
3. Merge into the current desired branch: `git merge OTHER_BRANCH`
4. Resolve any merge conflicts with the other branch's commits merged in