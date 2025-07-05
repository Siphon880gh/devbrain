So you've launched a new dedicated server or VPS for website or web app. Here's a checklist of items at the server level you should hardened security with.

## Basic Checklist

Absolutely must
 
- **DNS via Cloudflare**: Great for DDoS protection, proxying, and DNS control.
	- Cloudflare has free version. You add them into your DNS.

- **IP**:
	  - Use tools like Fail2Ban or SSHGuard to block repeated login attempts.
	  - Connecting the public facing website to Cloudflare adds an automatic layer of protection by detecting suspicious or repeated bot activity from an IP address. It can trigger a CAPTCHA challenge, temporarily throttle the IP for exceeding request limits (per minute, hour, etc.), or block access from known malicious.

- **Ports - Firewall Configuration**: 
	- Block unneeded ports. Only allow needed ports to the internet.
	- You can use firewall cli tools to quickly view and manage rules. Refer to [[UFW - Enable specific ports]] or [[IPTables - Enable specific ports]] or [[firewalld - Enable specific ports]], whichever applicable to your server's setup.

- **Ports - Reverse Proxying**: Using NGINX vhost or Apache `htaccess` to have a regular url for api access. Meanwhile, the API's true ports like 3XXX (NodeJS usually Express) or 5XXX (Python usually Flask) are blocked from internet traffic per firewall cli rules. For Nginx, refer to [[Reverse proxy to app ports]] and [[Nginx Vhost - Reverse proxy internal ports]].

- **SSH Hardening**
	- Use key-based authentication instead of passwords (PasswordAuthentication no).
	- Disable SSH password login. 
		- NOT the same as using key-based authentication. Using key-based authentication does not automatically disable SSH password login from working.
		- Disabling SSH password login has a nice additional security feature: All password attempts including the correct password says incorrect password. This misleads brute-force attackers, making it appear like their credentials are just wrong, not that password login is entirely disabled.
	- Disable root login via SSH by setting PermitRootLogin no or PermitRootLogin prohibit-password in /etc/ssh/sshd_config. This prevents direct root access and forces users to log in as a regular user (like `adminuser`) and escalate privileges via sudo. This could mean updating your SSH login command if you had been using root to SSH login.
	- Limit SSH access by IP or IP range via firewall rules or AllowUsers/AllowGroups in sshd_config.
	- Change the default SSH port from 22 to a non-standard port to reduce brute-force attempts.

- **SSH / User Hardening**: 
	- Avoid using easily guessed usernames like root or admin. While you can't truly "rename" the root user (UID 0), you can create a new user with sudo privileges (How to? Refer to [[User Management - Grant sudo privileges to new or existing user]]) and disable remote root login entirely (Discussed at previous point).
  
- **SSL (HTTPS)**: Good for all public-facing services.

- **Tunneling Web Portals**: Good for cPanel, phpMyAdmin, etc.
    
- **VM Isolation**: Partitioning and bridging for VPS-like control.
	- Reworded: Create vm through partition and bridge to it as a VPS with dedicated ip exposed to internet. That way I can restart the VM or VPS from my root shell.


---

## Appendix - Key Points on SSH and Root Access

1. **Using SSH key (passwordless) to root**  
    ➤ _Does not_ mean SSH password login is disabled.  
    ✅ You can still log in with a password if allowed.
    
2. **Disabling SSH password login**  
    ➤ _Does not_ block SSH key (passwordless) login to root.  
    ✅ SSH key access continues to work.
    ✅ Misleads hackers because it still asks interactively for password - just all attempts correct or wrong will say invalid password.
    
3. **Disabling root SSH login**  
    ➤ _Blocks_ all SSH logins as root — **both password and key-based**.  
    ➤ Usual practice is to log in as a regular user (like `adminuser`) and escalate privileges via sudo. 
    ❌ You can’t SSH directly as root anymore.