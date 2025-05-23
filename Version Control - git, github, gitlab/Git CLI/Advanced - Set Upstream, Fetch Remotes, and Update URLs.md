## Git Default Remote and Upstream Configuration

When you clone a Git repository, a default remote named `origin` is automatically created. This remote typically points to the original repository URL.

### Fetching from a Remote

By default, running `git fetch` pulls updates from the tracked upstream remote of your current branch. However, you can explicitly fetch from a specific remote like `origin`:

```bash
git fetch origin
```

This is helpful if you want to fetch changes from a specific remote, regardless of your current branch’s upstream setting.

---

### Setting the Default Remote and Branch for a Local Branch

To associate a local branch with a remote branch (i.e., set its upstream), use the following command:

```bash
git branch --set-upstream-to=<remote>/<remote-branch> <local-branch>
```

**Example:**  
To track `origin/feature` with your local `feature` branch:

```bash
git branch --set-upstream-to=origin/feature feature
```

This allows `git pull` and `git push` to automatically target the correct remote branch.

---

### Changing the Remote URL

If the URL of your `origin` remote has changed (e.g., due to a repo rename or migration), you can update it using:

```bash
git remote set-url origin <new-url>
```

This updates the reference to point to the new repository location while keeping the remote name (`origin`) the same.