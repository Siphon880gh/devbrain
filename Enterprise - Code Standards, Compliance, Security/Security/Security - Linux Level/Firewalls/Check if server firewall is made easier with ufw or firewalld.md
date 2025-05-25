**firewalld** (Firewall daemon) and **UFW** (Uncomplicated Firewall) are firewall management tools that provide an easier command syntax to configure the underlying **iptables** or **netfilter** framework in the Linux kernel

The choice is often influenced by the specific Linux distribution you're using. 

**firewalld:**
- **Commonly Used In:** Red Hat-based distributions such as **Fedora**, **CentOS**, and **Red Hat Enterprise Linux (RHEL)**.
  
**UFW (Uncomplicated Firewall):**
- **Commonly Used In:** **Ubuntu**, **Debian**.

---

To see if UFW (Uncomplicated Firewall) is installed and check its status:

```bash
sudo ufw status
```

- **If UFW is active**, it will display the status and any active rules.
- **If UFW is not installed**, you can install it using your package manager (e.g., `sudo apt install ufw`).

**Note:** UFW simplifies firewall management by providing an easy interface to control the underlying firewall.

---

To see if **firewalld** is installed and check its status:
```bash
sudo firewall-cmd --state
```

- **If firewalld is running**, it will display:

  ```
  running
  ```

- **If firewalld is not installed**, you can install it using your package manager (e.g., `sudo apt install firewalld`).

**Note:** Firewalld simplifies firewall management by providing an easy interface to control the underlying firewall using zones and services.