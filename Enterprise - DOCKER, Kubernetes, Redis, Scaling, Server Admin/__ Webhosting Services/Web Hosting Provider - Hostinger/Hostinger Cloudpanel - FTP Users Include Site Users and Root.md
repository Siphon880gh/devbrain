On Hostinger VPS with CloudPanel, the default SFTP/FTP user is usually the “site user” tied to a specific website. The “root” user can also connect via SFTP/FTP, as an account is automatically enabled for it.

You can create additional users in CloudPanel, but this is typically done to provide limited FTP access to others, such as developers or collaborators. In most cases, the admin logs in using the site user or root.

For improved security in hardened setups, which is recommended, the root account is often disabled entirely to eliminate predictable login targets and reduce the risk of brute-force attacks.

---

Where's the Cloudpanel site-specific user?
> CloudPanel -> Settings tab -> Site User Settings
> ![[Pasted image 20250706132614.png]]
> 


