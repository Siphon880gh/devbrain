
## SETUP/TEST SFTP

Newbie questions: Proftpd? vsFTPD? SFTP does not need them. 

By having SSH, you already have SFTP, and they run on the same port! And you can have multiple connections with the same SSH user.

You can use two types of SSH accounts - Root and non-root's.

1. Collect your SSH credentials
2. Setup in Filezilla according to the type of SSH user that will act as SFTP. Recommend createing both root and non-root in Filezilla. Non-root makes sure pages can be viewed and that web browser visited scripts can modify/create files as intended.

### Root SFTP Account
On Filezilla test logging into your root SSH account
- Protocol: SFTP. 
- Host: Public IP
- Port: Blank
Then supply the username and password
Once successfully logged in, recommend you set the remote directory default
### SFTP Non-root account
You want to login to non-root account so a webpage that’s not owned by root can modify another file or directory that you avoided creating as root owned when logged in as root on filezilla (PHP etc).
- Protocol: SFTP. 
- Host: Public IP
- Port: Blank
Then supply the site user username and site user password from CloudPanel. You do not need to add SSH Users under “SSH/FTP” tab. The site user is automatically a SSH user.
Once successfully logged in, recommend you set the remote directory default
