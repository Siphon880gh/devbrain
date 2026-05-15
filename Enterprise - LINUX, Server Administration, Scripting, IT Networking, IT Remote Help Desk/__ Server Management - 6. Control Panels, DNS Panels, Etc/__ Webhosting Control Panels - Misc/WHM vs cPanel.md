
WHM and cPanel are both control panels that allow users to manage websites and domains. 
- WHM is used by resellers to manage hosting accounts for their plans, while cPanel is used by end users to manage their own hosting accounts. 
- WHM offers more control and configuration options than cPanel, and can be considered the backend to cPanel

---

WHM is a Web Hosting Management Platform
cPanel is Web Hosting Control Panel, specifically a Sever Control Panel

----

cPanel allows the end-users to easily manage files, giving access to configurations and files only available for their domain. This is primarily used for domain/website management. Some examples of what the cPanel side of things can do are: 

- Create Email Addresses
- Edit websites files through File Manager
- Can create FTP and sub-accounts for each cPanel account
- Create Addon and subdomains

You can view settings and configurations from WHM (Web Host Manager) that only root can access and change the server. This helps keep the server secure and adds an additional filter, so end-users using a standard cPanel do not restart your server or make other significant changes to the server, negatively impacting it. WHM is used for server-level management that you can generally do in SSH as root.  

Some more examples of what you can do in WHM are as follows: 

- Upgrade MySQL/MariaDB service 
- Install and Manage SSL certificates easily for all users
- Restart or Shut Down the server
- Turn on and off services