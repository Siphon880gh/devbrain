
Just like you can override the remote branch with `git push origin main --force`, you can forcefully override the local repo

NOT CORRECT: `git pull origin main --force`

Correct command is:
```
git fetch origin; git reset --hard refs/remotes/origin/main;
```