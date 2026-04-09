Answers the question: Why `git fetch` when working local repo that team members contribute to via github?

## What `git fetch` does

`git fetch` downloads the latest commits, files, and branch updates from a remote repository **without changing your local files**.

Think of it as:  
👉 _“Get me the latest changes, but don’t touch my work yet.”_

### Why this matters

- **Safe** → No risk of overwriting your work
- **No conflicts** → Doesn’t trigger merges automatically
- **Visibility first** → Lets you review changes before applying them

When you run:

git fetch

Git updates your **remote-tracking branches** (like `origin/main`) so you can see what’s new.

---

## Why not just use `git pull`?

|   |   |   |
|---|---|---|
|Command|What it does|Risk level|
|`git fetch`|Download changes only|Safe|
|`git pull`|Fetch + merge automatically|Risky|

👉 `git pull` is basically:

git fetch + git merge

So with `git pull`, you’re merging **blindly**.

With `git fetch`, you stay in control.

---

## Step-by-step workflow after `git fetch`

### 1. Check if you're behind

git status

You might see something like:

Your branch is behind 'origin/main' by 3 commits

---

### 2. Review incoming commits

```
git log HEAD..origin/main
```

Or:

```
git log main..origin/main
```

👉 Shows commits you don’t have yet.

---

### 3. See actual code changes

git diff main origin/main

👉 Shows file-by-file differences.

---

### 4. (Optional) Visual tools

```
gitk --all
```

Or use GUI tools like GitKraken.

---

## Now choose how to apply the changes

### Option 1 — Merge (most common)

git merge origin/main

- Keeps full history
- Creates a merge commit if needed

If there are conflicts:

1. Fix files
2. `git add .`
3. `git commit`

---

### Option 2 — Rebase (clean history)

git rebase origin/main

- Moves your commits on top of latest changes
- Cleaner timeline
- ⚠️ Don’t use if your commits are already shared

---

### Option 3 — Cherry-pick (specific commits)

git cherry-pick <commit-hash>

- Pull in only what you need

---

### Option 4 — Skip all this and use pull

git pull

- Fast, but no review step
- Less control

---

## Common variations of `git fetch`

Fetch a specific branch:
```
git fetch origin main
```

Fetch all remotes:
```
git fetch --all
```

---

## Simple mental model

- `git fetch` → _Download updates safely_
- `git review` → _Check what changed_
- `git merge/rebase` → _Apply changes intentionally_

---

## Recommended habit (best practice)

Use this flow instead of `git pull`:
```
git fetch
git status
git log HEAD..origin/main
git diff main origin/main
git merge origin/main
```

This prevents surprises and keeps you in control of your codebase.

---

## Bottom line

Use `git fetch` when you want to:

- Avoid breaking your current work
- Understand changes before applying them
- Reduce unexpected merge conflicts

👉 It’s the safer, more professional workflow—especially on teams.