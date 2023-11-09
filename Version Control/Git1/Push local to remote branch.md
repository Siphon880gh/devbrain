You can specify different local branch to different remote branch when pushing.

Eg. If you want to push a branch named "slash" to the remote repository's "main" branch, you can use the following command:

```shell
git push origin slash:main
```

This command pushes the local branch "slash" to the remote repository's "main" branch. The "origin" is the name of the remote repository.

Caveat:
But it's a better flow to push your own branch `git push origin slash` then perform a pull request online, then have another person review the pull request PR and merge them into main at github.com.
