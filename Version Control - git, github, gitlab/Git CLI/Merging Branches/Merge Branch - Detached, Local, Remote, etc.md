
If on a detached HEAD:
1. Create a new branch name like `git checkout -B temp`
2. Switch to desired branch `git checkout OUR_BRANCH_NAME`
3. Merge into the current desired branch: `git merge temp`
4. Resolve any merge conflicts with the other branch's commits merged in

If on the wrong branch:
1. Switch to desired branch `git checkout OUR_BRANCH_NAME`
2. Merge into the current desired branch: `git merge OTHER_BRANCH`
3. Resolve any merge conflicts with the other branch's commits merged in

If remote branch:
- If you're on a local branch that's the same name as the remote branch
	- OPTION A: `git pull origin BRANCH_NAME`
	- OPTION B: `git fetch`... then `git merge`
- If you're on a different local branch from the remote branch
	- If you want to merge remote branch into current local branch: `git pull origin REMOTE_BRANCH_NAME`
	- If you want to keep separate local branch that's named the same as the remote branch:
		- 1. `git checkout -B REMOTE_BRANCH`
		- 2. `git pull origin REMOTE_BRANCH`