Keeping your Git history clean and consistent isn’t just about discipline—it’s about automation. You can enforce standards for commit messages and branch names using Git hooks or CI/CD pipelines. Here’s how to do both.

---

## ✅ Enforce Commit Message Format

Git doesn’t natively enforce commit message formatting, but you can use a `commit-msg` hook to validate messages before they’re committed.

### 🧪 Local Hook: `commit-msg`

1. Create the `commit-msg` hook:

```bash
touch .git/hooks/commit-msg
chmod +x .git/hooks/commit-msg
```

2. Add this script to `.git/hooks/commit-msg`:

```bash
#!/bin/sh

# Regex for Conventional Commit (e.g., feat: message, fix: message)
commit_regex="^(feat|fix|docs|style|refactor|test|chore)(\([a-z0-9\-]+\))?: .+"

commit_msg=$(cat "$1")

if ! echo "$commit_msg" | grep -Eq "$commit_regex"; then
  echo "⛔️ Commit message must follow Conventional Commits format:"
  echo "Example: feat(auth): add login button"
  exit 1
fi
```


---


## 📦 Optional: Use `commitlint` + `husky` (JS/TS Projects)

If you’re working on a JavaScript or TypeScript project—especially with teams—it's better to **automate commit validation** using tools built for the JS ecosystem:

### 🔧 What These Tools Do

|Tool|Purpose|
|---|---|
|`husky`|Manages Git hooks (like `commit-msg`) using config files inside your repo.|
|`commitlint`|Validates commit messages using rules (e.g., [Conventional Commits](https://www.conventionalcommits.org/)).|

Together, they help you reject invalid commit messages automatically.

---

### 🛠 Step-by-Step Setup

1. Install Dev Dependencies

```bash
npm install --save-dev @commitlint/config-conventional @commitlint/cli husky
```

- `@commitlint/cli`: The core CLI to run checks
- `@commitlint/config-conventional`: Ruleset that enforces standard formats like `feat: ...` or `fix(auth): ...`
- `husky`: Makes it easy to hook commitlint into Git

2. Configure Commitlint

Create a file called `commitlint.config.js` in your root directory:

```js
// commitlint.config.js
module.exports = {
  extends: ['@commitlint/config-conventional']
};
```

This tells `commitlint` to use the conventional commit rules.

3. Initialize Husky and Add a Hook

```bash
npx husky install
```

Add to your `package.json`:

```json
{
  "scripts": {
    "prepare": "husky install"
  }
}
```

Then create the hook that triggers `commitlint`:

```bash
npx husky add .husky/commit-msg 'npx --no commitlint --edit $1'
```

Now, whenever someone runs `git commit`, this hook will validate the message and block the commit if it doesn't follow the rules.

---

### ✅ Example of Allowed Commit Messages

These will pass:
- `feat: add login button`
- `fix(api): handle null response`
- `chore(deps): update dependencies`
- `docs(readme): add usage section`

These will be rejected:
- `added stuff`
- `bug fix`
- `update file`

---

### 🧠 Why This Is Better for Teams

- **Repeatable**: Everyone gets the same checks, no matter their OS or IDE.
- **Extendable**: You can define custom rules (e.g., max length, allowed scopes).
- **Team-Ready**: Git hooks live in the repo, so they’re version-controlled and shared.

---

Let me know if you'd like to:

- Add **custom scopes** (e.g. only allow `auth`, `ui`, `api`)
- Generate a `.commitlintrc` instead of `commitlint.config.js`
- Use **commitizen** to guide commit formatting interactively

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

### 🧪 Local Hook: `pre-push`

1. Create the `pre-push` hook:

```bash
touch .git/hooks/pre-push
chmod +x .git/hooks/pre-push
```

2. Add this script to `.git/hooks/pre-push`:

```bash
#!/bin/sh

branch_name=$(git symbolic-ref --short HEAD)
pattern='^[0-9]{4}\.[0-9]{2}\.[0-9]{2}-[A-Za-z0-9\-]+$'

if ! echo "$branch_name" | grep -Eq "$pattern"; then
  echo "⛔️ Branch name '$branch_name' is invalid."
  echo "Format must be: YYYY.MM.DD-description-with-hyphens"
  echo "Example: 2025.05.22-Weng-Dockerfile"
  exit 1
fi
```

---

### 🛠 Enforce via GitHub Actions (CI/CD)

For team-wide enforcement, use GitHub Actions:

#### `.github/workflows/branch-name-check.yml`

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

---

## 🧠 Bonus: Helper Script to Create Branches

Make it easy to follow the convention:

#### `scripts/create-branch.sh`

```bash
#!/bin/bash

read -p "Short description (use hyphens): " desc
today=$(date +"%Y.%m.%d")
branch="${today}-${desc}"
git checkout -b "$branch"
echo "✅ Created and switched to: $branch"
```

---

## ✅ Summary

|Aspect|Enforced With|Example Format|
|---|---|---|
|Commit Messages|`commit-msg` hook / `commitlint`|`feat(auth): add login button`|
|Branch Names|`pre-push` hook / GitHub Actions|`2025.05.22-Weng-Dockerfile`|
