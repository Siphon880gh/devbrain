So you've launched a new dedicated server or VPS for website or web app. Here's a checklist of items at the server level you should hardened security with.

## Basic Checklist

Absolutely must

- **VM Isolation**: Partitioning and bridging for VPS-like control.
	- Reworded: Create vm through partition and bridge to it as a VPS with dedicated ip exposed to internet. That way I can restart the VM or VPS from my root shell
	
- **Firewall Configuration**: Blocking unneeded ports.
	- You can use firewall cli tools to quickly view and manage rules. Refer to [[UFW - Enable specific ports]] or [[IPTables - Enable specific ports]] or [[firewalld - Enable specific ports]], whichever applicable to your server's setup.
    
- **Tunneling Web Portals**: Good for cPanel, phpMyAdmin, etc.
    
- **User Hardening**: Renaming default users like `root` because hackers expect this user and they will brute force it with bots.
    
- **SSH Hardening**: Passwordless login (via SSH keys).
    
- **Reverse Proxying**: Using NGINX vhost or Apache `htaccess` to have a regular url for api access. Meanwhile, the API's true ports like 3XXX (NodeJS usually Express) or 5XXX (Python usually Flask) are blocked from internet traffic per firewall cli rules.
    
- **SSL (HTTPS)**: Good for all public-facing services.
    
- **DNS via Cloudflare**: Great for DDoS protection, proxying, and DNS control.
	- Cloudflare has free version. You add them into your DNS.

