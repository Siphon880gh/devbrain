To check what users have been created on an Ubuntu system, you can use several commands depending on how much detail you want:

### 🔹 **1. List All Users (System + Human)**

```bash
cut -d: -f1 /etc/passwd
```

This shows all users on the system (including system users like `daemon`, `syslog`, etc.).

---

### 🔹 **2. Show Only Human Users**

Human users typically have UIDs ≥ 1000. Use this:

```bash
awk -F: '$3 >= 1000 && $3 < 65534 {print $1}' /etc/passwd
```

---

### 🔹 **3. See User Creation Logs (if available)**

Ubuntu logs user creation events in `/var/log/auth.log` (if logging was enabled when the user was created).

Example:

```bash
grep 'useradd' /var/log/auth.log*
```

---

### 🔹 **4. View Home Directories**

You can list home directories to guess which users are active:

```bash
ls /home
```

---

### 🔹 **5. Get Detailed Info About a User**

```bash
id username
```

Example:

```bash
id weng
```

