## When You Might Use Pull Requests (As an external contributor)

If you want to contribute to a project that you **don’t own** or where you are **not an approved contributor**, you still use pull requests — but the workflow is a little different:

- ✅ **Fork the repository**: You copy the original repo into your own GitHub account. This gives you your own “sandbox” version.    
- ✅ **Work in a branch**: Just like approved contributors, you should make your fixes or features in a new branch inside your fork.
- ✅ **Push branch to your fork**: Your changes live in your fork, not the original repository.
- ✅ **Create a pull request back to the upstream repository**: This is your request to the maintainers of the original repo, asking them to review and merge your contributions.

### Typical Conditions

- **You don’t have write access** to the repo, so you cannot push branches directly.
- The project welcomes community contributions, so the maintainers review outside PRs.
- PRs in this context are a way of **asking**: _“Will you consider merging my changes into your project?”_
- Whether your PR gets merged depends on:
    - Code review feedback.
    - Whether it aligns with the project’s goals.
    - Whether it passes any required automated tests.

### Why This Matters

Pull requests let anyone contribute to open-source projects, even without direct access. They act as:
- A way to propose changes.    
- A way to have a documented discussion.
- A way to ensure only maintainers control what reaches the main branch.

---

## How to Contribute to a GitHub Repository (Step-by-Step Guide)

Contributing to open source (or any shared GitHub repo) usually follows the **Fork → Clone → Branch → Commit → Push → Pull Request** workflow. Here’s how it works:

---

### 1. Fork the Repository

- Go to the original repo on GitHub.
- Click the **Fork** button (top right).
- This creates a copy of the repo under your GitHub account.

---

### 2. Clone Your Fork

Bring the forked repo onto your local machine:

```bash
git clone https://github.com/YOUR-USERNAME/REPO-NAME.git
cd REPO-NAME
```

---

### 3. Add the Original Repo as Upstream (Optional but Recommended)

This allows you to pull in updates later:

```bash
git remote add upstream https://github.com/ORIGINAL-OWNER/REPO-NAME.git
git remote -v   # verify remotes
```

---

### 4. Create a New Branch

Work on a feature or fix in its own branch:

```bash
git checkout -b feature/my-fix
```

---

### 5. Make Your Changes

Edit the code, docs, or configuration as needed.  
Test locally to make sure everything works.

---

### 6. Commit Your Changes

Stage and commit them:

```bash
git add .
git commit -m "Fix: corrected typo in README"
```

---

### 7. Push to Your Fork (Avoiding Permission Errors)

Here’s where many get stuck. If you see:

```
ERROR: Permission to ORIGINAL-OWNER/REPO.git denied
fatal: Could not read from remote repository.
```

…it means you’re trying to push to the **original repo**, which you don’t have write access to.

#### Fix:

Point `origin` to your fork instead of the original:

```bash
git remote set-url origin https://github.com/YOUR-USERNAME/REPO-NAME.git
```

Now push your branch:

```bash
git push origin feature/my-fix
```

---

### 8. Open a Pull Request

- Go to your fork on GitHub (`https://github.com/YOUR-USERNAME/REPO-NAME`).
- You’ll see a **Contribute** button.
  
  Eg. Let's say you are `Siphon880gh`:
  ![[Pasted image 20250907042235.png]]
  
  ![[Pasted image 20250907041935.png]]

- Click it, choose the branch, and submit your PR against the original repo’s `main` branch.
- Add a clear title and description explaining your change.


Alternate path:
- If you had visited the maintainer/author's repo instead, you will see a **Compare & Pull Request** banner
  
  Eg. Let's say the maintainer/author is `cacoos`:
  
  ![[Pasted image 20250907042729.png]]

---

### 9. Keep Your Fork Updated

If the original repo updates, sync your fork:

```bash
git checkout main
git fetch upstream
git merge upstream/main
git push origin main
```

---

### ✅ Summary

1. Fork the repo
2. Clone your fork
3. Add upstream remote
4. Create a branch
5. Make changes
6. Commit
7. Push to **your fork**, not the original repo
8. Open a Pull Request
9. Keep your fork in sync
