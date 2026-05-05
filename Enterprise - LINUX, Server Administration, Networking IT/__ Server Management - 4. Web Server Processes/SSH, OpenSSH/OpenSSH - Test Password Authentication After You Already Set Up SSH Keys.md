
After you pair SSH keys with a server, SSH often keeps using that key automatically. That is normal. The key is stored on your machine and tied to your login session or host, so you usually don’t need to specify the key path every time.

Sometimes you still want to test password authentication afterward. For example, maybe other engineers on your team will SSH in using passwords, or you want to verify your SSH hardening setup (since you can allow password login, disable it entirely, or disable it just for root).

---

## Why SSH Still Logs In Without You Typing the Key Path

Once key-based login is set up, SSH may automatically use the key because:

- it checks common key files in `~/.ssh/`
    
- it may use a key already available in your login session
    
- it may already associate a key with that host
    

That’s why it feels like SSH “just works” without extra flags.

---

## Why Test Password Authentication If SSH Keys Already Work?

Even after SSH keys are working, testing password authentication is still important.

### 1. Other Engineers May Use Password Login

Not everyone on your team may be set up with SSH keys yet. You may want to confirm that password login:

- still works for onboarding teammates
    
- or is intentionally disabled
    

---

### 2. Validate Your SSH Hardening

SSH security has multiple levels, not just keys vs password. You may want to confirm things like:

- password login is allowed for all users
    
- password login is completely disabled
    
- root cannot log in with a password
    
- only key-based authentication is allowed
    

Testing confirms your setup matches your intent.

---

### 3. Prevent Accidental Lockouts

When tightening SSH security, testing ensures:

- you didn’t accidentally block certain users
    
- fallback login methods behave as expected
    

---

### 4. Confirm Real Behavior (Not Just Config)

Even if your config looks correct, real behavior can differ based on:

- user restrictions
    
- SSH daemon settings
    
- authentication order
    

A real login test is the fastest way to verify.

---

## How to Test Password Authentication (Key Disabled)

Force SSH to ignore keys and try password login:

```bash
ssh -o PubkeyAuthentication=no -o PreferredAuthentications=password root@your-server-ip
```

### What this does:

- `PubkeyAuthentication=no` → disables key-based login
    
- `PreferredAuthentications=password` → forces password attempt
    

---

## What the Result Means

### ✅ If password login is enabled:

You’ll see:

```bash
root@your-server-ip's password:
```

---

### ❌ If password login is disabled or restricted:

You may see:

```bash
Permission denied (publickey).
```

or:

```bash
Permission denied (publickey,password).
```

---

## Test with SFTP Too (Optional)

If you want to confirm behavior with SFTP:

```bash
sftp -o PubkeyAuthentication=no -o PreferredAuthentications=password root@your-server-ip
```

👉 SFTP uses SSH under the hood, so it follows the same authentication rules.

---

## Important SSH Hardening Note

Password authentication can behave differently depending on your configuration.

For example:

- `PasswordAuthentication yes` → allows password login
    
- `PasswordAuthentication no` → disables it entirely
    
- `PermitRootLogin prohibit-password` → blocks **root password login only**
    

So you might have a situation where:

- normal users can log in with passwords
    
- but `root` cannot
    

---

## Quick Summary

After setting up SSH keys, your system will usually keep using them automatically because they are already associated with your login or host.

To test password authentication anyway, run:

```bash
ssh -o PubkeyAuthentication=no -o PreferredAuthentications=password user@host
```

- If you get a password prompt → password auth works
    
- If you get denied → password auth is disabled or restricted
    

This gives you a clean way to verify password login even after key-based authentication is already working.