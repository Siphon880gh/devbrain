
You can check whether your server is using `ufw` or `iptables` by running the following commands:

1. **Check if UFW (Uncomplicated Firewall) is active:**
   ```bash
   sudo ufw status
   ```

   If `ufw` is active, you will see a list of rules, or it will display a message saying "Status: active." If `ufw` is not active or installed, you'll see something like "Status: inactive" or "Command not found."

2. **Check if iptables is being used:**
   ```bash
   sudo iptables -L
   ```

   This will list the rules currently configured in `iptables`. If there are no rules, or if the command returns an error, `iptables` might not be actively managing the firewall.

After running these commands, you'll know which one your server is using. Let me know if you need help interpreting the output!