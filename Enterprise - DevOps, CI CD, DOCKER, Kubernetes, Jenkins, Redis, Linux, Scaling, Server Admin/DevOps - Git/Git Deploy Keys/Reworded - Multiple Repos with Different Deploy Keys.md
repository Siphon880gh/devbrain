## **Overview**

If you have multiple repositories on one machine, each with its own deploy key, you will run into this problem:

❌ Git uses the wrong SSH key → results in 404 / permission denied

This happens because:

- SSH defaults to a single identity (`~/.ssh/id_rsa`, etc.)

---

## **✅ Solution: Use**

## **`~/.ssh/config`**

**(Recommended)**

Instead of modifying `.git/config`, use SSH config for portability and clarity.

---

## **🛠 Step 1: Generate Keys Per Repo**

```
ssh-keygen -t ed25519 -f ~/.ssh/repo1_key
ssh-keygen -t ed25519 -f ~/.ssh/repo2_key
```

You can’t use the same SSH key for multiple repos’ deploy key because it’d complain:  
![[Pasted image 20260421025715.png]]

---

## **🛠 Step 2: Configure SSH Host Aliases**

Edit:

~/.ssh/config

Example:

Host github-repo1
  HostName github.com
  User git
  IdentityFile ~/.ssh/repo1_key

Host github-repo2
  HostName github.com
  User git
  IdentityFile ~/.ssh/repo2_key

---

## **🛠 Step 3: Update Git Remote URLs**

Inside each repo:

### **Repo 1**

git remote set-url origin git@github-repo1:org/repo1.git

### **Repo 2**

git remote set-url origin git@github-repo2:org/repo2.git

  

Notice that normally, the origin is `git remote set-url origin git@github.com:org/repo1.git`   
  

So in place of `github.com` , we inserted the host alias.  
  

---

## **🔄 What This Does**

- Each repo uses a **different hostname alias**
- SSH maps that alias → correct key
- No key conflicts when switching repos

---

## **❌ What NOT to Do**

### **Avoid**

### **`.git/config`**

**key overrides**

- Not portable
- Hard to maintain across machines

---

### **Avoid reusing keys**

- GitHub blocks duplicate deploy keys

---

## **🐳 Docker Considerations**

- Do NOT generate SSH keys inside Docker
- Do NOT rely on containers for Git auth

👉 Instead:

- Clone repos on host machine
- Build Docker AFTER code is pulled

---

## **👥 If Sharing This Setup**

Add a helper script or README section:

### **Example Setup Script**

npm run setup:ssh

Script should:

- Generate SSH key
- Print public key
- Instruct user to add it to repo

---

## **🧠 Mental Model**

Think of it like this:

- Each repo = its own identity
- Each key = access badge
- SSH config = routing system

---

## **✅ Summary**

- One key per repo
- Use `~/.ssh/config` to map keys
- Use custom hostnames (namespacing)
- Update git remote URLs accordingly
- Keep SSH on host, not Docker