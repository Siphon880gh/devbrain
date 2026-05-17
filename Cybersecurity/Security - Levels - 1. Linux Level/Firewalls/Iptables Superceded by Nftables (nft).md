
**nftables is the modern Linux firewall system that took over from iptables.** nftables is part of the broader **Linux Netfilter** firewall stack, so you will see it across many modern Linux distributions, including Debian, Ubuntu, Fedora, Arch, Rocky, AlmaLinux, and others.

That said, this guide focuses on **Debian**, especially modern Debian versions such as **Debian 12**, where nftables is the preferred firewall framework.

In simple terms:
- nf = Netfilter
- nft = Netfilter tables
- nftables = Netfilter tables framework

**Netfilter** is the Linux kernel networking/firewall framework that inspects packets and decides what to do with them.

A simple mental model:

```text
Netfilter = kernel firewall framework
nftables = modern rule system built on Netfilter
nft = command-line tool used to manage nftables
```

So when people say “use nftables,” they usually mean using the `nft` command to view, add, delete, or load firewall rules.

---

# Does nftables Come with Debian?

On modern Debian versions, including Debian 12, **nftables is the default firewall framework**. However, that does not always mean your firewall is already configured and actively blocking traffic.

There are two separate ideas:

```text
nftables support exists on the system
```

versus:

```text
active firewall rules are loaded and protecting the server
```

A Debian server may have nftables available, but still have no meaningful firewall rules configured yet.

You can check if the command exists with:

```bash
which nft
```

You can check the version with:

```bash
nft --version
```

You can check the active ruleset with:

```bash
sudo nft list ruleset
```

If the output is empty or very small, it may mean no serious firewall rules are currently loaded.

---

# What Is nftables Used For?

nftables controls what network traffic is allowed or blocked.

It can manage:

```text
incoming connections
outgoing connections
forwarded/routed traffic
TCP ports
UDP ports
IP addresses
rate limiting
blocking suspicious traffic
allowing only trusted sources
```

For a typical server, the most common use is controlling incoming traffic.

For example, you might allow only:

```text
SSH       port 22
HTTP      port 80
HTTPS     port 443
```

And block everything else.

---

# The Most Important nft Command

The main command to remember is:

```bash
sudo nft list ruleset
```

This shows the actual firewall rules currently loaded into the kernel.

This is important because tools like UFW or Fail2Ban may create firewall rules underneath the surface. Even if you did not manually write nftables rules, nftables may still be involved.

---

# Basic nftables Structure

nftables has a few core parts:

```text
table  →  chain  →  rule
```

A **table** is a container for firewall rules.

A **chain** is where rules are attached to a traffic path, such as incoming traffic.

A **rule** is the actual instruction, such as “allow port 22” or “drop this IP.”

Example idea:

```text
table: inet filter
  chain: input
    allow SSH
    allow HTTP
    allow HTTPS
    drop everything else
```

---

# Example: Simple nftables Firewall

Here is a basic example that allows SSH, HTTP, and HTTPS, then blocks other incoming traffic.

Create a table:

```bash
sudo nft add table inet filter
```

Create an input chain:

```bash
sudo nft add chain inet filter input '{ type filter hook input priority 0; policy drop; }'
```

Allow already-established connections:

```bash
sudo nft add rule inet filter input ct state established,related accept
```

Allow local loopback traffic:

```bash
sudo nft add rule inet filter input iif lo accept
```

Allow SSH:

```bash
sudo nft add rule inet filter input tcp dport 22 accept
```

Allow HTTP:

```bash
sudo nft add rule inet filter input tcp dport 80 accept
```

Allow HTTPS:

```bash
sudo nft add rule inet filter input tcp dport 443 accept
```

Now check the rules:

```bash
sudo nft list ruleset
```

This gives you a basic server firewall.

---

# Be Careful with SSH

When working over SSH, be very careful not to lock yourself out.

Before setting a default drop policy, make sure SSH is allowed:

```bash
sudo nft add rule inet filter input tcp dport 22 accept
```

If your SSH server uses a custom port, use that port instead.

For example:

```bash
sudo nft add rule inet filter input tcp dport 2222 accept
```

---

# Temporary vs Permanent nftables Rules

Rules added directly with commands like this:

```bash
sudo nft add rule ...
```

may not survive a reboot unless they are saved into a config file.

The main nftables config file is commonly:

```text
/etc/nftables.conf
```

You can edit it with:

```bash
sudo nano /etc/nftables.conf
```

Then enable nftables to load on boot:

```bash
sudo systemctl enable nftables
```

Restart nftables:

```bash
sudo systemctl restart nftables
```

Check status:

```bash
sudo systemctl status nftables
```

---

# Example `/etc/nftables.conf`

A simple server config could look like this:

```bash
#!/usr/sbin/nft -f

flush ruleset

table inet filter {
    chain input {
        type filter hook input priority 0;
        policy drop;

        ct state established,related accept
        iif lo accept

        tcp dport 22 accept
        tcp dport 80 accept
        tcp dport 443 accept
    }

    chain forward {
        type filter hook forward priority 0;
        policy drop;
    }

    chain output {
        type filter hook output priority 0;
        policy accept;
    }
}
```

This means:

```text
incoming traffic: blocked by default
forwarded traffic: blocked by default
outgoing traffic: allowed by default
SSH/HTTP/HTTPS: allowed
```

After editing the file, run:

```bash
sudo systemctl restart nftables
```

Then verify:

```bash
sudo nft list ruleset
```

---

# Easier Tools That Wrap Around nftables

nftables is powerful, but the syntax can feel confusing at first.

Because of that, many people use an easier command-line tool that manages firewall rules for them.

The most common example is:

```text
ufw
```

UFW stands for **Uncomplicated Firewall**.

It gives you easier commands like:

```bash
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
sudo ufw status verbose
```

On modern Debian/Ubuntu systems, UFW may use nftables as the backend.

So the relationship is roughly:

```text
UFW = easier firewall CLI
nftables = lower-level firewall system
kernel = enforces the actual rules
```

That means you may use UFW commands, but nftables may still be the real firewall framework underneath.

---

# Why Use UFW Instead of nftables Directly?

Use UFW when you want simple server rules like:

```text
allow SSH
allow HTTP
allow HTTPS
deny everything else
```

UFW is easier to remember and harder to mess up.

Example:

```bash
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
```

Then check:

```bash
sudo ufw status verbose
```

This is usually enough for many basic VPS setups.

---

# Why Use nftables Directly?

Use nftables directly when you need more control.

For example:

```text
custom chains
advanced rate limiting
IP sets
Cloudflare-only origin protection
complex routing/firewall rules
manual Fail2Ban integration
fine-grained packet filtering
```

nftables is more powerful, but it also requires more care.

---

# Do Not Casually Mix UFW and Manual nftables Rules

This is where people get confused.

You can technically have both:

```bash
sudo systemctl status ufw
sudo systemctl status nftables
```

But it can become hard to understand which rules are responsible for allowing or blocking traffic.

The safest practice is to choose one main firewall manager.

Use either:

```text
UFW as your main firewall manager
```

or:

```text
nftables directly as your main firewall manager
```

If you use UFW, manage most firewall rules through UFW.

If you use nftables directly, avoid adding random UFW rules on top unless you know exactly how they interact.

---

# Practical Commands to Remember

Check active nftables rules:

```bash
sudo nft list ruleset
```

Check nftables service:

```bash
sudo systemctl status nftables
```

Edit nftables config:

```bash
sudo nano /etc/nftables.conf
```

Restart nftables:

```bash
sudo systemctl restart nftables
```

Enable nftables at boot:

```bash
sudo systemctl enable nftables
```

Check UFW rules:

```bash
sudo ufw status verbose
```

---

# Simple Mental Model

Think of it like this:

```text
Netfilter is the kernel firewall framework.
nftables is the modern rule system built on Netfilter.
nft is the command used to control nftables.
UFW is an easier command-line wrapper that can create firewall rules for you.
```

For most beginners or basic servers, UFW is easier.

For advanced server security, nftables gives you more control.

The most important thing is not to assume a firewall is protecting you just because nftables exists on Debian. Always check the actual active rules with:

```bash
sudo nft list ruleset
```