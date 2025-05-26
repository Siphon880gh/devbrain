This guide outlines essential team practices for Git workflows, naming, and branching and standards. This promote consistency, collaboration, and more streamlined deployments.

---

## 📥 Commit Message Naming

A consistent commit message format improves readability, helps with automation (like changelogs), and makes collaboration easier across the team.

### ✅ Option 1: Conventional Commit Format

This widely-used convention prefixes your commit with a keyword that explains **what kind of change** it is. Optionally, you can include a scope in parentheses to clarify what part of the codebase was affected.

**Format:**

```
<type>(<optional-scope>): <description>
```

**Examples:**

```
feat(auth): add login with magic link
fix(api): correct typo in error response
docs(readme): update usage instructions
```

**Common Types:**

|Type|Purpose|
|---|---|
|`feat`|A new feature|
|`fix`|A bug fix|
|`docs`|Documentation changes|
|`style`|Code style (formatting, missing semis)|
|`refactor`|Refactoring without behavior changes|
|`test`|Adding or fixing tests|
|`chore`|Other changes like build tools or CI|

This style is great for teams using semantic versioning or tools that auto-generate changelogs.

### ✅ Option 2: Action-Based Summary

If your team prefers a more casual but still clear approach, you can follow a simpler “action + subject” format. This emphasizes **what changed** in plain language.

**Examples:**

```
Add signup form
Update navbar layout
Fix crash on upload
Remove unused settings
Refactor calendar logic
```

**Tips:**
- Start with an action verb (`Add`, `Fix`, `Refactor`, `Update`, etc.)
- Write in the imperative mood (“Add” instead of “Added”)
- Keep it short and focused on **what changed**

---
---

## 🌿 Branching Strategies

Branching defines how your team organizes work-in-progress. It influences collaboration, code stability, and how features get delivered. The right branching model depends on team size, release cadence, and codebase complexity.

Here are common branching patterns:

### 1. **Stacked Branches**

Each new branch builds directly on top of the last, forming a linear sequence. By the time the final branch is complete, it already includes the commits from all previous branches.

> “Just merge the roll forward” means only the last branch needs to be merged—earlier ones are already included.

Useful for feature stacks, experiments, or iterative development that’s logically chained.

### 2. **Feature Branching**

Every new feature or bug fix lives in its own branch, branched off from `main` or `develop`. Once complete, the branch is merged back—often through a pull request.

Pros:
- Isolated development
- Easier code review    

Cons:
- Merge conflicts if branches diverge too long

### 3. **Trunk-Based Development**

Everyone works directly on `main` (aka `trunk`), pushing small, frequent commits. Long-lived branches are discouraged, and feature flags are used to hide incomplete work.

Pros:
- Rapid integration
- Low merge overhead

Cons:
- Requires strong CI/CD pipelines and discipline
### 4. **Release Branches**

When a release is near, a dedicated branch is cut to stabilize the code. Final fixes and testing happen here, while new features continue on `main`. Once the release is ready, it's merged back.

Good for:
- Versioned software
- Teams with parallel development and QA

---
### 🏷️ Branch Naming Convention

Use a format that keeps branch names readable and sortable at Github.com:

Format:
```
YYYY.MM.DD-author-description-with-hyphens
```

Example:
```
2025.05.22-Weng-Dockerfile
```

Let's say instead you have all hyphens or periods, then it becomes a huge blur of lines at where the Branches would be:

![[Pasted image 20250523054104.png]]

---

## 🔀 Merging Strategies

Once your team chooses a branching model, your **merging strategy** defines how those branches get integrated.

### 1. **Roll Forward Merge**

Use when one branch already includes the work from others. Instead of merging each branch separately, just merge the final one.

```bash
# Check if another branch is already included
git log feature-jane ^feature-john
```

- No output? Jane’s work is already in John’s—merge only John's.
    

### 2. **Standard Merge (Multiple Branches)**

Create a temporary merge branch to combine work before merging into `main`:

```bash
git checkout -b merge-branch
git merge feature-john
git merge feature-jane
git checkout main
git merge merge-branch
```

Use this when different team members worked in parallel.

### 3. **Rebase (Optional Strategy)**

Some teams rebase to create a cleaner, linear history before merging:

```bash
git checkout feature-x
git rebase main
```

Rebase rewrites commit history. It’s useful before PRs, but avoid rebasing shared branches.

---

## ✂️ Pruning: A Common Post-Merge Discussion

After merges, it’s common for teams to **discuss pruning** old feature branches—especially in collaborative tools like GitHub or GitLab where long branch lists can become cluttered.

Pruning doesn’t affect history; it just removes references to completed work:

- **Delete local branches**:
    ```bash
    git branch --merged main
    git branch -d feature-old
    ```
    
- **Delete remote branches**:
    ```bash
    git push origin --delete feature-old
    ```
    
- **Prune stale remote refs**:
    ```bash
    git fetch --prune
    ```

Pruning is good hygiene—just ensure the branch was fully merged and is no longer needed before deleting.

For more in-depth guide on pruning, refer to [[_Fundamental - Pruning]]

---
## 🤖 Let Weng Help You

- You can follow this guide on configuring your team's Git standards **OR** you can use Weng's Automated Enforcer. A CLI Tool, it asks you the questions about tab spaces, git naming conventions, etc, then it generates the configuration files you can copy over to your project.
- Check out Weng's repo at:
  https://github.com/Siphon880gh/automate-enforcements