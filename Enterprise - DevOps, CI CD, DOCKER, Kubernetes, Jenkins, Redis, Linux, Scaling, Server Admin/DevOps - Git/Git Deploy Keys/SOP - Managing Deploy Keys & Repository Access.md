## **Overview**

When working with multiple repositories and multiple team members, access control must be:

- Secure
- Predictable
- Easy to onboard

This SOP defines how to manage **deploy keys**, **SSH access**, and **team setup**.

---

## **🔐 Core Rules**

### **1. One Deploy Key Per Repository**

- Each repository has its **own unique deploy key**
- Deploy keys **cannot be reused across repos**
- **Cannot be the same public key as the personal SSH public key (associated with the Github account)**
- GitHub will reject duplicate keys

![[Pasted image 20260421025715.png]]
How a successfully uploaded public key to your respective repo looks like:
![[Pasted image 20260421041150.png]]

---

### **2. Prefer Personal SSH Access for Developers**

Instead of using deploy keys for humans:

- Each developer should:

- Generate their own SSH key
- Add it to their GitHub account

- Grant access via:

- Repo permissions
- Teams in an org

👉 Deploy keys are best for:

- Servers
- CI/CD systems
- Automation

---

### **3. When to Use Deploy Keys**

Use deploy keys when:

- A server needs access to **only one repo**
- You want **limited scope access**
- You do NOT want to expose a personal account