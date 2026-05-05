
**Where's the Cloudpanel site-specific user?**
What's it used for: SFTP/FTP into your website's files. All Cloud site-specific username are automatically SFTP/FTP accounts too.
> At CloudPanel clicked a site or site's Manage button -> Stay on Settings tab
> ![[Pasted image 20250706132614.png]]
> 


**Where's the CloudPanel admin login:**
What it's used for: To login at Cloudpanel https://XX.XX.XXX.XX:8443/login
![[Pasted image 20250706152729.png]]

Change admin password? Look at admin username? Go to top-right Avatar -> Settings
![[Pasted image 20250706152622.png]]

![[Pasted image 20250706152712.png]]

**Additional SFTP/SSH users**
Under your site's dashboard, at the tab "SSH/FTP", you can add FTP, SFTP/SSH users. The practice is usually to add the users here with limited scope. The root and Cloud-specific site users already are SFTP and SSH users.
![[Pasted image 20250706153500.png]]

**Where's the root user**
What it's used for: SSH root login or SFTP/FTP login as root (Have access to all websites' files)

Root user is not tied to CloudPanel. For example, on Hostinger VPS, you'll see it at the Overview at the bottom left that has your "VPS details". You usually manage the root user through terminal. Hostinger when you buy a VPS by default creates a root user, enables SSH root password login, and makes a SFTP/FTP account from the root user too.