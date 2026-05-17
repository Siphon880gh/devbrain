### SSH - Passwordless Key-Based Authentication

Instead of typing a password every time you SSH into a server, you authenticate with a key pair: a private key that stays on your local machine and a public key that lives on the server. The server verifies your identity by matching them — no password ever travels over the network.

This is more secure than password login because:
- No password can be brute-forced over the network
- Even if someone intercepts the connection, there is no password to steal
- Combined with `PasswordAuthentication no` in `sshd_config`, password-based login is eliminated entirely

> **Note:** Key-based auth and disabling password login are two separate steps. Setting up keys does not automatically disable password login. You must explicitly set `PasswordAuthentication no` if you want to block password attempts. Refer to [[_ Security Checklists - Dedicated Server or VPS (SSH Root access, etc)]] for how those two settings interact.

---

### Setup

**On your local machine:**

1. **Generate an SSH key pair** (if you do not already have one):

   ```sh
   ssh-keygen -t ed25519 -C "your_label_or_email"
   ```

   - `ed25519` is the modern recommended algorithm. Use `rsa -b 4096` if the server is older and does not support ed25519.
   - `-C` adds a comment to help you identify the key later — it does not affect function.
   - You will be prompted to choose a file path. The default is `~/.ssh/id_ed25519`. Press Enter to accept.
   - You will be prompted for a passphrase. This is optional but recommended — it encrypts the private key file so it cannot be used even if someone steals it.

   This creates two files:
   ```
   ~/.ssh/id_ed25519        ← private key (never share this)
   ~/.ssh/id_ed25519.pub    ← public key (this goes on the server)
   ```

2. **Copy your public key to the server:**

   ```sh
   ssh-copy-id username@server_ip
   ```

   This appends your public key to `~/.ssh/authorized_keys` on the server under that user's home directory. You will be prompted for the user's password one last time.

   If `ssh-copy-id` is not available (e.g. on macOS without it installed), do it manually:

   ```sh
   cat ~/.ssh/id_ed25519.pub | ssh username@server_ip "mkdir -p ~/.ssh && cat >> ~/.ssh/authorized_keys"
   ```

3. **Test that key-based login works** before disabling password login:

   ```sh
   ssh username@server_ip
   ```

   You should be logged in without being prompted for a password (or only prompted for your local key passphrase if you set one).

---

**On the server (optional but recommended — disable password login):**

4. **Edit the SSH configuration file:**

   ```sh
   sudo vi /etc/ssh/sshd_config
   ```

5. **Disable password authentication:**

   ```
   PasswordAuthentication no
   ```

   Also ensure this line is set (it usually is by default):

   ```
   PubkeyAuthentication yes
   ```

6. **Restart the SSH service:**

   ```sh
   sudo systemctl restart sshd
   ```

> **Warning:** Do not close your current SSH session until you have confirmed a second session can connect successfully using the key. If something is misconfigured and you close your only session, you may lock yourself out. Have an escape hatch ready — refer to [[Emergency Escape Hatch - Recover Access If You Lock Yourself Out]].

---

### Multiple Machines or Users

If you need to grant SSH access to multiple people or from multiple machines, append each person's public key as a separate line in `~/.ssh/authorized_keys` on the server. Each line is one public key.

To revoke access for one key, delete that specific line from `authorized_keys`.

---

### File Permissions (if things are not working)

SSH is strict about permissions on key-related files. If key-based login silently falls back to password or fails:

```sh
chmod 700 ~/.ssh
chmod 600 ~/.ssh/authorized_keys
chmod 600 ~/.ssh/id_ed25519       # private key, on local machine
chmod 644 ~/.ssh/id_ed25519.pub   # public key, on local machine
```

The `~/.ssh` directory and `authorized_keys` must not be writable by anyone other than the owner, or SSH will refuse to use them.

---

### Developer Experience

Once set up, you can shorten repeated SSH commands with an alias or an SSH config entry. In `~/.ssh/config` on your local machine:

```
Host myserver
    HostName XXX.XX.XXX.XX
    User username
    IdentityFile ~/.ssh/id_ed25519
```

Then connect with just:

```sh
ssh myserver
```
