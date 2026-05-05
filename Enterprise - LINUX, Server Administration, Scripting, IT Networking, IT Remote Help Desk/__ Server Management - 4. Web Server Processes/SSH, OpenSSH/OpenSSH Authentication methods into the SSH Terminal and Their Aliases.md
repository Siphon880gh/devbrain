# SSH Login Methods and Alias Shortcuts

When you connect to a server over SSH often, the login command can start to feel repetitive. You may find yourself copying the server IP, remembering the username, entering the same password, or typing the path to your private key every time.

One easy way to make this smoother is to first understand the normal SSH command, then create an alias so you do not have to retype it.

The best alias strategy depends on how you log in. Alias may be named after your domain name (you can abbreviate) or the webhost name, to make it easy to remember.

## Choose Your Alias Strategy Based on How You Log In

### 1) SSH with Interactive Password

**Not recommended**

First, here is the normal unaliased command:

```bash
ssh root@XXX.XX.XXX.XX
```

This connects to the server as `root` at the server’s public IP address. SSH will then prompt you to type the password interactively.

Once you understand that command, you can shorten it with an alias:

```bash
alias coloa='ssh root@XXX.XX.XXX.XX'
```

Now instead of typing the full SSH command, you can just type:

```bash
coloa
```

**Why people do this:**

- You do not have to copy and paste the public IP
    
- You do not have to memorize the full command
    

**Downside:**

- You still have to type the password every time
    
- It is slower and less convenient for frequent work
    

---

### 2) SSHPass

**Workaround to interactive password**  
**Also not recommended**

Normally, SSH with a password looks like this:

```bash
ssh root@XXX.XX.XXX.XX
```

But because `ssh` is designed to ask for the password interactively, some people use `sshpass` to supply the password automatically.

The unaliased version would look like this:

```bash
echo -e "Local: /Users/wengffung/dev/web/weng/apps/\nRemote: /home/.."
sshpass -p "YOUR_PASSWORD" ssh root@XXX.XX.XXX.XX
```

That can then be turned into an alias like this:

```bash
alias coloa='echo -e "Local: /Users/wengffung/dev/web/weng/apps/\nRemote: /home/.."; sshpass -p "YOUR_PASSWORD" ssh root@XXX.XX.XXX.XX'
```

Now you can just type:

```bash
coloa
```

This can be convenient because it can both:

- Show you your local and remote working paths
    
- Log in without asking you to manually type the password
    

**Why people do this:**

- You do not have to memorize or paste the public IP
    
- You do not have to manually type the password
    
- You can include reminders about your local and remote folders
    

**Downside:**

- You have to install `sshpass`
    
- Your password is stored in plain text, which is a security risk
    

For example, on macOS, people often install it with:

```bash
brew install sshpass
```

This method is more streamlined than typing the password every time, but it is still not recommended for long-term use.


**⚠️ Caveat about SSHPass**

You may get a fingerprint mismatch error some time in the future. When you reinstall the server or it gets reinstalled for server updates, this could cause SSH to deny the connection due to a mismatch with the fingerprint stored in the fingerprint file `~/.ssh/known_hosts` file. You would remove the old SSH fingerprint from that file (has the webhost domain name or webhost public IP), then re-attempt to connect with SSH, then you'll be asked if you want to accept the new fingerprint.

If using sshpass, it won't ask you interactively to accept new fingerprint, and therefore you can't connect to the reinstalled server even with old outdated fingerprints removed. Either **run normal ssh command** when the server is reinstalled, or come up with an alias for normal ssh for your webhost (eg. if your webhost company is called coloa).

```
alias coloa-ssh='ssh root@XXX.XX.XXX.XX'
```

## 2.b) Using `expect` Scripts (Advanced / Rare Use)

**Not recommended for most setups**

Another workaround for password-based SSH is using the `expect` tool. This lets you script interactions with programs that normally require manual input, such as entering a password when SSH prompts with `"Password:"`.

### Unaliased Example (Script)

```bash
#!/usr/bin/expect -f

set timeout 10
spawn ssh root@XXX.XX.XXX.XX
expect "Password:"
send "YOUR_PASSWORD\r"
interact
```

You would save this as a script (e.g., `login.exp`), make it executable, and run it:

```bash
chmod +x login.exp
./login.exp
```

### Optional Alias

```bash
alias coloa='./login.exp'
```

### Why people use this
- Automates password entry without needing `sshpass`
- Can handle more complex interactive flows than `sshpass`
- Useful in legacy systems or constrained environmen

---

### 3) Passwordless Authentication with SSH Keys

**Recommended**

This is the preferred method.

With SSH key authentication, you place your **public key** on the server and keep your **private key** on your local machine. Then SSH can authenticate you without asking for the server password every time.

The normal unaliased command looks like this:

```bash
ssh -i ~/.ssh/PRIVATE_KEY -p 22 root@XX.XX.XXX.XX
```

That command tells SSH:

- use this private key: `~/.ssh/PRIVATE_KEY`
    
- connect on port `22`
    
- log in as `root`
    
- connect to the server at `XX.XX.XXX.XX`
    

You can also add a helpful reminder before the command:

```bash
echo -e "Local: /Users/wengffung/dev/web/weng/apps/\nRemote: /home/XX/htdocs/YY.com/"
ssh -i ~/.ssh/PRIVATE_KEY -p 22 root@XX.XX.XXX.XX
```

Then you can turn that into an alias:

```bash
alias hostinger='echo -e "Local: /Users/wengffung/dev/web/weng/apps/\nRemote: /home/XX/htdocs/YY.com/"; ssh -i ~/.ssh/PRIVATE_KEY -p 22 root@XX.XX.XXX.XX'
```

Now you can just type:

```bash
hostinger
```

**Why this is recommended:**

- You do not have to memorize or paste the server IP
    
- You do not have to type the password every time
    
- It is more secure than password-based login
    
- It works better for automation and scripts
    
- You can still print reminders about your local and remote folders before connecting
    

This is usually the best developer experience.

---

## Why Aliases Help

Aliases are useful because they let you learn the real command first, then replace it with a short word that is easier to remember.

That means:

- first you understand what the SSH command is doing
    
- then you save time by shortening it
    
- and later you can reuse the same shortcut every day
    

They are especially helpful when you frequently reconnect to the same server and want a reminder of where your files live locally and remotely.

## Best Practice

If you only SSH occasionally, a basic alias around the normal SSH command may be enough.

If you log in often, the best setup is usually **SSH keys plus an alias**. That gives you:

- a shorter command
    
- no repeated password entry
    
- better security
    
- easier automation
    

Avoid putting raw passwords directly into aliases unless you understand the security tradeoff and are only doing it as a temporary workaround.

## Summary

### Interactive password SSH

Unaliased command:

```bash
ssh root@XXX.XX.XXX.XX
```

Aliased version:

```bash
alias coloa='ssh root@XXX.XX.XXX.XX'
```

### SSHPass

Unaliased command:

```bash
echo -e "Local: /Users/wengffung/dev/web/weng/apps/\nRemote: /home/.."
sshpass -p "YOUR_PASSWORD" ssh root@XXX.XX.XXX.XX
```

Aliased version:

```bash
alias coloa='echo -e "Local: /Users/wengffung/dev/web/weng/apps/\nRemote: /home/.."; sshpass -p "YOUR_PASSWORD" ssh root@XXX.XX.XXX.XX'
```

### SSH keys

Unaliased command:

```bash
echo -e "Local: /Users/wengffung/dev/web/weng/apps/\nRemote: /home/XX/htdocs/YY.com/"
ssh -i ~/.ssh/PRIVATE_KEY -p 22 root@XX.XX.XXX.XX
```

Aliased version:

```bash
alias hostinger='echo -e "Local: /Users/wengffung/dev/web/weng/apps/\nRemote: /home/XX/htdocs/YY.com/"; ssh -i ~/.ssh/PRIVATE_KEY -p 22 root@XX.XX.XXX.XX'
```

For most developers, **SSH keys with an alias is the best long-term setup**.

I can also make this read more like a polished tutorial blog post with headings like “Step 1,” “Step 2,” and “Step 3.”