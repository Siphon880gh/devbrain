You **can install both `firewalld` and `ufw`**, but you usually **should not run both as active firewall managers at the same time**. The terminal won't give you a warning that you're using two firewalls (on top of iptables/nftables)

They are both frontends/controllers for Linux firewall rules. On modern Debian/Ubuntu systems, both may ultimately create rules through **nftables** or compatibility layers.

## What takes precedence?

There is no clean “UFW wins” or “firewalld wins” rule.

The real firewall decision happens in the kernel through the final loaded ruleset, usually in **nftables** on modern Linux systems.

So precedence depends on:

- which service starts first
- which service starts later
- which one flushes or replaces rules
- which nftables hooks/chains they use
- rule priority
- whether one tool overwrites rules from the other

In practice, this means:

> The firewall rule that actually exists in the active kernel ruleset is what matters, not which tool you typed it into.

## Why running both is confusing

If both are enabled, you can get confusing behavior like:

```bash
sudo ufw allow 22
```

but then `firewalld` reloads and changes the active rules.

Or:

```bash
sudo firewall-cmd --add-service=http
```

but then `ufw reload` changes what is active.

So one tool may appear to “undo” or bypass the other.

## Better rule

Use **one firewall manager**:

- Use **UFW** if you want a simple firewall CLI.
    
- Use **firewalld** if you want zones, runtime/permanent rules, and more dynamic management.
    
- Use **raw nftables** if you want direct low-level control.
    

For most simple servers, especially Debian/Ubuntu VPS setups, **UFW is usually easier**.

## Check if both are installed/running

```bash
systemctl status ufw
systemctl status firewalld
```

Check enabled-on-boot status:

```bash
systemctl is-enabled ufw
systemctl is-enabled firewalld
```

Check the actual active firewall rules:

```bash
sudo nft list ruleset
```

That last command matters most because it shows what the kernel is actually using.

## Recommended setup

Pick one.

For UFW:

```bash
sudo systemctl disable --now firewalld
sudo systemctl enable --now ufw
sudo ufw status verbose
```

For firewalld:

```bash
sudo systemctl disable --now ufw
sudo systemctl enable --now firewalld
sudo firewall-cmd --state
```

Simple way to remember it:

> `ufw` and `firewalld` are managers.  
> `nftables` is the actual rule engine underneath.  
> If two managers try to manage the same engine, the result can become confusing.