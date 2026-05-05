To create a new user **with `sudo` privileges** or modify an existing one to grant `sudo` access, follow these steps (for Debian/Ubuntu-based systems):

---

### ✅ **1. Create a New User (optional if user already exists)**

```bash
sudo adduser yourusername
```

Follow the prompts to set a password and fill in user info.

---

### ✅ **2. Add User to the `sudo` Group**

```bash
sudo usermod -aG sudo yourusername
```

> On **Debian/Ubuntu**, members of the `sudo` group can use `sudo` by default.

To verify:

```bash
groups yourusername
```

It should show `sudo` in the list.

---

### ✅ **3. (Optional) Test the New User**

Switch to the new user:

```bash
su - yourusername
```

Run a command with sudo to test:

```bash
sudo whoami
```

If set up correctly, it should return `root`.

---

### ✅ **Alternative (Manual Config)**

If you're using a distro where `sudo` group isn't used (e.g., some CentOS/RHEL systems), you can manually add sudo rights:

```bash
sudo visudo
```

Then add this line at the end:

```bash
yourusername ALL=(ALL) NOPASSWD:ALL
```

> Remove `NOPASSWD:` if you want the user to enter a password when using sudo.
