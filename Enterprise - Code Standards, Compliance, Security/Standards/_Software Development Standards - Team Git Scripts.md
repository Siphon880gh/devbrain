Keeping your Git history clean and consistent isn’t just about discipline—it’s about automation. You can enforce standards for commit messages and branch names using Git hooks or CI/CD pipelines. Here’s how to do both.

---

## ✅ Enforce Commit Message Format

Git doesn’t natively enforce commit message formatting, but you can use a `commit-msg` hook to validate messages before they’re committed.

These will pass:
- `feat: add login button`
- `fix(api): handle null response`
- `chore(deps): update dependencies`
- `docs(readme): add usage section`

These will be rejected:
- `added stuff`
- `bug fix`
- `update file`

### 🧪 OPTION 1 - Local Hook: `commit-msg`

1. Create the `commit-msg` hook:

```bash
touch .git/hooks/commit-msg
chmod +x .git/hooks/commit-msg
```

2. Edit `.git/hooks/commit-msg`:
- You can edit with `vi .git/hooks/commit-msg`:
```bash
#!/bin/sh

# Regex for Conventional Commit (e.g., feat: message, fix: message)
commit_regex="(?i)^(feat|fix|docs|style|refactor|test|chore)(\([a-z0-9\-]+\))?: .+"

commit_msg=$(cat "$1")

if ! echo "$commit_msg" | grep -Eq "$commit_regex"; then
  echo "⛔️ Commit message must follow Conventional Commits format:"
  echo ""
  echo "'''"
  echo "(?i)^(feat|fix|docs|style|refactor|test|chore)(\([a-z0-9\-]+\))?: .+"
  echo "'''"
  echo "Example: feat: add login button"
  echo "Example: feat(auth): add login button"
  exit 1
fi
```


### 🧪  OPTION 2 - Husky with CommitLint

For JavaScript/TypeScript projects, use `husky` + `commitlint` to **automatically reject invalid commit messages**.

**🧰 Tools**

- `husky` – Manages Git hooks.
	- Mnemonic: Think husky the dog species. Think git fetch command. Think dog fetches a stick. Therefore, Husky is a tool that manages git hooks.
- `commitlint` – Checks commit messages (e.g., `feat: add auth`)

**⚙️ Quick Setup**

1. **Install dependencies**:
```bash
npm install --save-dev husky @commitlint/cli @commitlint/config-conventional
```

2. **Create config** (`commitlint.config.js`):
```js
module.exports = {
  extends: ['@commitlint/config-conventional']
};
```

3. **Initialize husky**:
```bash
npx husky install
```

In `package.json`:
```json
"scripts": {
  "prepare": "husky install"
}
```

4. **Add hook**:
```bash
npx husky add .husky/commit-msg 'npx --no commitlint --edit $1'
```
^ Explanation: `--edit $1` will validate against the `commitlint.config.js` rule(s) whenever the developer is making a commit message. That `--no` ensures `npx` doesn't auto-install if `commitlint` missing.

Now every `git commit` is validated automatically.

---
---

## ✅ Enforce Branch Name Format

Branch names should be readable and sortable. You can enforce a format like:

```
YYYY.MM.DD-description-with-hyphens
```

**Example:**

```
2025.05.22-Weng-Dockerfile
```

Git does **not natively support hooks** for actions like `git checkout -b`, so you can’t directly enforce branch naming at the moment of creation. However, there are workarounds—though they rely on developers using **custom commands** instead of the standard Git flow:
- **Shell function wrapper**: Add a function to your `~/.bash_profile`, `~/.zprofile`, or similar shell config that wraps `git checkout -b` with validation logic.
- **Local shell script**: Place a `create-branch.sh` script in the project folder. Developers run this script with the new branch name as an argument to create branches with enforced naming.
- **Git alias (user-level only)**: Define a `git new-branch` alias in your `~/.gitconfig` that includes validation logic. Note: aliases with shell commands only work in the global or system Git config—not in the repo’s `.git/config`.

A more proper solution is to validate the branch name when the developer is pushing the branch to the remote github.com repo.

### 🧪 OPTION 1 - Local Hook: `pre-push`

1. Create the `pre-push` hook:

```bash
touch .git/hooks/pre-push
chmod +x .git/hooks/pre-push
```

2. Edit `.git/hooks/pre-push`:
- You can edit with `vi .git/hooks/pre-push`:
```bash
#!/bin/sh
branch_name=$(git symbolic-ref --short HEAD)
pattern='^[0-9]{4}\.[0-9]{2}\.[0-9]{2}-[A-Za-z0-9\-]+$'

if ! echo "$branch_name" | grep -Eq "$pattern"; then
  echo "⛔️ Branch name '$branch_name' is invalid."
  echo ""
  echo "Format must be: YYYY.MM.DD-description-with-hyphens"
  echo "Example: 2025.05.22-Weng-Dockerfile"
  exit 1
fi
```

---

### 🧪 OPTION 2 - Enforce via GitHub Actions (CI/CD)

For team-wide enforcement, use GitHub Actions:

Edit/create `.github/workflows/branch-name-check.yml`

```yaml
name: Branch Name Check

on: [push, pull_request]

jobs:
  check-branch-name:
    runs-on: ubuntu-latest
    steps:
      - name: Check branch name
        run: |
          BRANCH_NAME="${GITHUB_REF#refs/heads/}"
          echo "Branch: $BRANCH_NAME"
          if ! echo "$BRANCH_NAME" | grep -Eq '^[0-9]{4}\.[0-9]{2}\.[0-9]{2}-[A-Za-z0-9\-]+$'; then
            echo "⛔️ Invalid branch name format: $BRANCH_NAME"
            echo "Expected format: YYYY.MM.DD-description-with-hyphens"
            exit 1
          fi
```

### 🧪🧪 Bonus: Helper Script to Create Branches

Make it easy to follow the convention:

Edit/create `scripts/create-branch.sh`:
```bash
#!/bin/bash

read -p "Short description (use hyphens): " desc
today=$(date +"%Y.%m.%d")
branch="${today}-${desc}"
git checkout -b "$branch"
echo "✅ Created and switched to: $branch"
```

Make sure to:
```
chmod +x scripts/create-branch.sh
```

Then you probably want to add the execution of that sh script into a npm script that you can run when you intend to create a new branch.