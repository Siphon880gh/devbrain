
This guide outlines essential team practices for Git workflows and branching, and configuration management across environments. These standards promote consistency, collaboration, and safer production deployments.

---

## 🔀 Git Workflow & Branching

### **Understanding Roll Forward Branches**

In many workflows, a developer (e.g., John) may:

- Add multiple **feature branches over time**
- Branch off each new feature from the latest one, creating a **linear history** rather than divergent versions
- End up with a **final branch** that already includes all prior work (from older branches)— this is called a **roll forward**
    

> A **roll forward** is the latest branch that has already precluded earlier feature branches because all their commits are already included.

#### ✅ Merging Strategy

1. **Create a working branch** to combine John’s roll forward with Jane’s branch:
    
    ```bash
    git checkout -b merge-branch
    git merge feature-john
    git merge feature-jane
    ```
    
2. **Check if Jane’s branch is already included** in John’s:
    
    ```bash
    git log feature-jane ^feature-john
    ```
    
    - No output = Jane’s changes are already present in John's branch.
        
3. If no merge conflicts:
    
    - Merge the working branch into `main`:
        
        ```bash
        git checkout main
        git merge merge-branch
        ```
        
4. If there **are merge conflicts**:
    - Schedule a **merge conflict review meeting** to resolve collaboratively.

---

### 📛 Branch Naming Convention

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

## ⚙️ Config Management

Use a single config file like `app.config.json` to manage environment-specific settings:

```json
{
  "development": { "apiUrl": "http://localhost:3000" },
  "staging": { "apiUrl": "https://staging.example.com" },
  "production": { "apiUrl": "https://example.com" }
}
```

This approach keeps settings clean and environment-specific.

This applies to settings like log paths, whether it's allow to console log, environmental variables at different environments, etc