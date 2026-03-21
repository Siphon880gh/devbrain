
Only applies if you have system-wide Firewall enabled (ufw):

```
sudo ufw status
```

If ufw not active, then this tutorial doesn't apply to you. And if port still can't be visited, it's another problem you have to inspect.

---


Eg. To allow port 9001 through the firewall for NGINX, you will need to perform a couple of steps depending on the firewall software you are using (e.g., `ufw`, `iptables`, `firewalld`). Below are instructions for common firewalls:

### Using `ufw` (Uncomplicated Firewall)

1. **Enable the firewall** (if not already enabled):

   ```bash
   sudo ufw enable
   ```

2. **Allow port 9001**:

   ```bash
   sudo ufw allow 9001
   ```

3. **Check the status** to ensure the rule is added:

   ```bash
   sudo ufw status
   ```


## Conventional Names
You could've also allow ports by their conventional name which you could list with `sudo ufw app list`, so like `sudo ufw allow "Nginx HTTP"` substituted for `sudo ufw 80`

`sudo ufw app list`:
```
Available applications:
  Nginx Full
  Nginx HTTP
  Nginx HTTPS
  OpenSS
```
