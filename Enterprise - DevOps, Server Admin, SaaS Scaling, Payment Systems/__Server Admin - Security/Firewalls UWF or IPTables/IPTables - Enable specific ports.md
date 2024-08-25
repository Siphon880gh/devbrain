
Check if iptables is managing firewall by running `sudo iptables -L -v -n` to see if there are any port rules which implies that iptables is enabled. Note that there doesn't need to be a iptables service for this firewall to work because iptables works at the kernel level. 

If it's enabled, you can open a port by running, like:
```
sudo iptables -A INPUT -p tcp --dport 5001 -j ACCEPT
```

No need to reboot; Rules are hot applied right way. Check ports allowed by running `sudo iptables -L -n`.

Check ports allowed by running `sudo iptables -L -n`. You can check for a specific port like this: `sudo iptables -L -n | grep 27017`

---

## Reworded

### Using `iptables`

1. **Allow port 9001**:

   ```bash
   sudo iptables -A INPUT -p tcp --dport 9001 -j ACCEPT
   ```

2. **Save the rules** so they persist after a reboot. This varies based on your system. For example, on Debian-based systems:

   ```bash
   sudo sh -c "iptables-save > /etc/iptables/rules.v4"
   ```
