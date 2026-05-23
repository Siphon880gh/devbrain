See if removing a git index lock helps:
```
rm -f./.git/index.lock
```

Is your repo under a cloud syncing folder (Apple iCloud, Google Drive, Microsoft OneDrive)? Then refer to [[Git commands frozen (Git Locally on Cloud Syncing Folders)]]

Otherwise, try this (adapt your git command) to see where it gets stuck:
```
GIT_TRACE=1 git commit -m "testing"
```
And if that fails, try GIT_TRACE2=1
```
GIT_TRACE2=1 git commit -m "testing"
```
