To remove a particular user on Ubuntu, use the `userdel` command. Here's how:

---

### 🔹 **Basic Command**

```bash
sudo userdel username
```

This removes the user account **but not their home directory or files**.

---

### 🔹 **Remove User and Their Home Directory**

```bash
sudo userdel -r username
```

- The `-r` flag removes:
    
    - User's home directory (`/home/username`)
        
    - Mail spool (`/var/mail/username`)
        
    - Sometimes, custom user-owned files in `/home`
        

---

### 🔹 **Check if User Exists First**

```bash
getent passwd username
```

---

### 🔹 **Verify Removal**

```bash
getent passwd username
```

If it returns nothing, the user is deleted.

---

### ⚠️ Notes:

- Don’t remove system or service users (like `mysql`, `www-data`) unless you're sure.
    
- You must be a **sudoer** to run these commands.
    
- If the user is currently logged in or running a process, you might need to kill those processes first:
    
    ```bash
    pkill -u username
    ```
    

Let me know if you're managing users via a GUI or in a container (e.g., Docker) – the process may differ.