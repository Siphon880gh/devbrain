## **👥 Team Onboarding Guide (README)**

Include this in every repo:

### **Step 1: Generate SSH Key**

ssh-keygen -t ed25519 -C "your_email@example.com"

---

### **Step 2: Add Key to GitHub Repo**

⛔️ NOT ONLY your personal Github *(This is for development/changing the code)*:
- Go to: GitHub
- Settings → SSH and GPG Keys
- Add your **public key**

✅ Yes the Github Repo for Deploy Key (*What we are trying to do is give the server permission to deploy for us*):
- Go to repo
- Settings -> Deploy Keys
- Add your **public key**
![[Pasted image 20260421041150.png]]
-  If there are multiple team members, there will be multiple public keys on that page, and that’s fine.

---

### **Step 3: Test Connection**

ssh -T git@github.com

---

## **🐳 Docker & Deployment**

- SSH keys live on:

- Developer machines
- Servers

- Docker containers:

- ❌ Do NOT store SSH keys
- ❌ Do NOT handle Git auth directly
- ✅ Only run the app

👉 Git operations happen:

- **Before container build**
- Or via CI/CD pipelines