
## Determine the Underlying Firewall Framework: IPTables of NFTables

UFW relies on either **iptables** or **nftables** to enforce firewall rules. To find out which one your system is using, run the following commands:

### Check for iptables

```bash
sudo iptables -L
```

- **If you see a list of chains and rules**, your system is using **iptables**.
- **If the chains are empty or the command is not found**, iptables may not be in use.
- Namesake: Stands for Internet Protocol Tables

### Check for nftables

```bash
sudo nft list ruleset
```

- **If you see a ruleset with tables and chains**, your system is using **nftables**.
- **If the output is empty or an error occurs**, nftables may not be active.
- Namesake: Stands for Net Filter Tables

---

## Determine Firewall Wrapper that Makes It Easier to Manage Firewall

**firewalld** (Firewall daemon) and **UFW** (Uncomplicated Firewall) are firewall management tools that provide an easier command syntax to configure the underlying **iptables** or **netfilter** framework in the Linux kernel. If you don't have them installed, it's recommended you do.

Find out if your Firewall management is made easier. Refer to [[Check if server firewall is made easier with ufw or firewalld]]