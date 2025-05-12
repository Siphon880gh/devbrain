So you've launched a new dedicated server or VPS for website or web app. Here's a checklist of items at the server level you should hardened security with.

## Basic Checklist

Absolutely must
 
- **DNS via Cloudflare**: Great for DDoS protection, proxying, and DNS control.
	- Cloudflare has free version. You add them into your DNS.

- **Ports - Firewall Configuration**: 
	- Block unneeded ports. Only allow needed ports to the internet.
	- You can use firewall cli tools to quickly view and manage rules. Refer to [[UFW - Enable specific ports]] or [[IPTables - Enable specific ports]] or [[firewalld - Enable specific ports]], whichever applicable to your server's setup.

- **Ports - Reverse Proxying**: Using NGINX vhost or Apache `htaccess` to have a regular url for api access. Meanwhile, the API's true ports like 3XXX (NodeJS usually Express) or 5XXX (Python usually Flask) are blocked from internet traffic per firewall cli rules. For Nginx, refer to [[Reverse proxy to app ports]] and [[Nginx Vhost - Reverse proxy internal ports]].

- **SSH Hardening**: Passwordless login (via SSH keys).

- **SSL (HTTPS)**: Good for all public-facing services.

- **Tunneling Web Portals**: Good for cPanel, phpMyAdmin, etc.
    
- **User Hardening**: Renaming default users like `root` because hackers expect this user and they will brute force it with bots.

- **VM Isolation**: Partitioning and bridging for VPS-like control.
	- Reworded: Create vm through partition and bridge to it as a VPS with dedicated ip exposed to internet. That way I can restart the VM or VPS from my root shell.
