## Quick Explanation

Can run scripts such as changing the name of the commit message, at certain events such as when committing a message

**How:**
At your local repo, open `.git/hooks`. You'll see sample files:
```
applypatch-msg.sample
pre-applypatch.sample
pre-rebase.sample
update.sample
commit-msg.sample
pre-commit.sample
pre-receive.sample
fsmonitor-watchman.sample
pre-merge-commit.sample
prepare-commit-msg.sample
post-update.sample
pre-push.sample
push-to-checkout.sample
```

You can read about a sample by opening it in a code editor or text editor. To make one of the hooks active, you could rename it so that it doesn't end with the extension .sample. For instance, to make commit-msg hook active, rename `commit-msg.sample` -> `commit-msg` OR create a file `commit-msg`.

For an example commit-msg, hook refer to: [[Git Hooks - Commit Message]]

---

## All Hooks

Git hooks are scripts that Git executes automatically at specific points in the Git workflow. They allow you to automate tasks, enforce policies, and integrate external tools during the development process.

There are two types of Git hooks:

1. **Client-side Hooks** – Triggered on developer machines before and after commits, merges, and checkouts.
2. **Server-side Hooks** – Executed on the server during push operations to enforce repository policies.

---

## **1. Client-side Hooks**

These hooks run on the local machine and are typically used for enforcing rules before code is committed or pushed.

### **a) Pre-commit Hook (`pre-commit`)**

- Runs before `git commit` is executed.
- Used to check for syntax errors, linting, formatting, or running tests.
- If it fails (exits with a non-zero status), the commit is aborted.

_Example use case:_ Prevent committing if there are linting errors.

---

### **b) Prepare-commit-msg Hook (`prepare-commit-msg`)**

- Runs before the commit message editor is displayed.
- Allows modifying the default commit message (e.g., appending ticket numbers or including branch names).
- Skipped when using `git commit -m "message"`.

_Example use case:_ Automatically insert issue numbers in commit messages.

---

### **c) Commit-msg Hook (`commit-msg`)**

- Runs after the commit message is entered but before the commit is finalized.
- Used to validate commit messages (e.g., enforcing message conventions).
- If it fails, the commit is rejected.

_Example use case:_ Enforce commit message format (e.g., requiring a specific prefix like `feat:`, `fix:`, etc.).

---

### **d) Post-commit Hook (`post-commit`)**

- Runs after a commit is made.
- Cannot stop the commit.
- Typically used for logging or notifications.

_Example use case:_ Send a notification after each commit.

---

### **e) Pre-rebase Hook (`pre-rebase`)**

- Runs before `git rebase` starts.
- Can prevent rebasing certain branches (e.g., `main` or `develop`).

_Example use case:_ Restrict rebasing protected branches.

---

### **f) Post-rewrite Hook (`post-rewrite`)**

- Runs after commands like `git commit --amend` or `git rebase` that rewrite commit history.
- Used for logging or triggering external actions.

_Example use case:_ Log rebase operations.

---

### **g) Pre-push Hook (`pre-push`)**

- Runs before `git push` sends commits to a remote repository.
- Can be used to run tests or ensure that certain criteria are met before pushing.

_Example use case:_ Prevent pushing code if tests fail.

---

### **h) Pre-applypatch Hook (`pre-applypatch`)**

- Runs before applying a patch with `git am`.
- Can be used to inspect or modify the patch.

_Example use case:_ Prevent applying patches that modify protected files.

---

### **i) Post-applypatch Hook (`post-applypatch`)**

- Runs after `git am` applies a patch.
- Cannot stop the patch application.
- Used for logging or notifications.

_Example use case:_ Send a notification after a patch is applied.

---

## **2. Server-side Hooks**

These hooks run on the remote repository and help enforce policies when receiving pushed commits.

### **a) Pre-receive Hook (`pre-receive`)**

- Runs on the remote server before accepting pushed changes.
- Can be used to enforce commit message formats, restrict branches, or run security checks.
- If it exits with a non-zero status, the push is rejected.

_Example use case:_ Prevent pushes to the `main` branch unless reviewed.

---

### **b) Update Hook (`update`)**

- Runs after `pre-receive` but before changes are written to the repository.
- Used to validate updates to individual branches or tags.
- Can reject certain ref updates.

_Example use case:_ Restrict force pushes.

---

### **c) Post-receive Hook (`post-receive`)**

- Runs after changes are received and written to the repository.
- Cannot stop the push.
- Used for notifications, deployment automation, or CI/CD triggers.

_Example use case:_ Trigger a deployment after a successful push.

---

## **How to Use Git Hooks**

1. Navigate to your repository’s hooks directory:
    
    ```sh
    cd .git/hooks
    ```
    
2. Enable a hook by renaming it (from `.sample` if necessary) and making it executable:
    
    ```sh
    mv pre-commit.sample pre-commit
    chmod +x pre-commit
    ```
    
3. Edit the hook file and add your script.

---

## **Example: Pre-commit Hook to Prevent Committing Debug Statements**

Create `.git/hooks/pre-commit` and add:

```sh
#!/bin/sh
if grep -r 'console.log' .; then
  echo "Error: Debugging console.log statements found. Remove them before committing."
  exit 1
fi
```

Make it executable:

```sh
chmod +x .git/hooks/pre-commit
```

Now, the commit will fail if any `console.log` is found.

---

## **Conclusion**

Git hooks are powerful tools for automating and enforcing rules in your development workflow. They help maintain code quality, security, and consistency across teams.

Would you like assistance with setting up a specific Git hook for your workflow? 🚀