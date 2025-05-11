Security practices:
- Firewall like iptables or ufw (but dont accidentally block out ssh)
- Certificates for all your web portal ports (like webmin, cpanel, etc) so a hacker doesnt imitate the page and you accidentally give them the credentials
- Disallow root login via ssh so you’re forced to login with any user, then elevate with su into root when you’re already in. Outsiders wouldn’t know because logging in with root access will always say incorrect password.
  PermitRootLogin no  in `/etc/ssh/sshd_config`
- Make SSH login passwordless SSH authentication
- Create sh scripts that toggle web portal ports on and off. You run the sh script while logged into SSH shell. 
- Tunnel a web portal to your local host, aka SSH tunneling or port forwarding. It allows you to securely access a remote service like a web portal over an encrypted SSH connection by forwarding the traffic through the SSH tunnel.