
Check if iptables is managing firewall by running `sudo service iptables status`. 

If it's enabled, you should open the Mongo port by running `sudo iptables -A INPUT -p tcp --dport 27017 -j ACCEPT` . 

Check ports allowed by running `sudo iptables -L -n`

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
