
SETUP/TEST SFTP

This does not need proftpd, or vsFTPD. By having SSH, you already have SFTP, and they run on the same port

Root SFTP Account
On Filezilla test logging into your root SSH account
Protocol: SFTP. 
Host: Public IP
Port: Blank
Then supply the username and password

SFTP Non-root account
You want to login to non-root account so a webpage that’s not owned by root can modify another file or directory that you avoided creating as root owned when logged in as root on filezilla (PHP etc).
Protocol: SFTP. 
Host: Public IP
Port: Blank
Then supply the site user username and site user password from CloudPanel. You do not need to add SSH Users under “SSH/FTP” tab. The site user is automatically a SSH user.

