

**I. FTP**

FTP comes with Ubutun 22 Cloudpanel! As Proftpd

CHECK FOR PORTS 21 and 22
If no firewall on:
sudo lsof -i TCP:21 -i TCP:22

If you’re using uwf as firewall:
sudo ufw status


CHECK FOR PRO FTP DAEMON:
proftpd --version

CHECK FOR vsftpd
vsftpd --version
Is a more secured ftp daemon than proftpd.

CHECK FOR SERVICE:
sudo systemctl status proftpd
^Or similar command based on your OS’ service manager

If you have proftpd you also have FTP with TLS. There are two flavors:
Explicit FTPS: The client requests encryption by sending an AUTH TLS command before logging in. This is the most common mode and uses the same port (21) as FTP.
Implicit FTPS: Encryption is immediately applied when the connection is established, typically using port 990.
Which might require you to open port if you are on firewall

II. SFTP

If you have SSH, you have SFTP.  FTP with TLS is like upgraded security, but it aint quite SFTP.

Since SFTP is a subsystem of SSH, it runs over the same port.
SSH (Secure Shell): Port 22
SFTP (SSH File Transfer Protocol): Port 22


If do not have FTP, look up instructions how to install proftpd, eg. Google: Ubuntu 22 install proftpd




Dev FTP Figuring out important filepaths etc

Figure out how to add FTP users. If Cloudpanel, you go into the site, select ftp, then add a user (the user must have a unique name. I recommend having the same site username but appending _ftp to the name, for ease of remembering)

FTP Logs:
tail /var/log/proftpd/proftpd.log

FTP configurations:
vi /etc/proftpd/proftpd.conf
vi /etc/proftpd/tls.conf (If use FTP with TLS)

Figure out your equivalent paths on your system. Save to web host details document

FTP Configuration if you need more detailer errors in the log:
DebugLevel 10



Dev Setup proftpd

1. **Configure ProFTPD**:
   Edit the ProFTPD configuration file to allow the test user to access the FTP server. Open the configuration file with a text editor:

   ```bash
   sudo nano /etc/proftpd/proftpd.conf
   ```

   Ensure the following settings are correctly configured (you might need to add or modify these lines):

   ```bash
   DefaultRoot ~
   RequireValidShell off
   ```

See no user is limited unless you intend to. REMOVE ANY OF THIS:
<Limit LOGIN>
  DenyUser USERNAME
</Limit>

See if group limitations. UNDERSTAND THIS IS OK:
<Limit LOGIN>
    DenyGroup !ftp-user
</Limit>

That’s saying if the ftp user does not belong to the group “ftp-user” then we deny login

Whenever you create a new ftp account from Cloudpanel, it must be a unique user name from site name, so recommended: a100pullups_ftp 
And if you had ran id a100pullups_ftp , you’d see that’s not a problem because it belongs to two groups, one of which is ftp-user:
uid=1004(a100pullups_ftp) gid=1003(a100pullups) groups=1003(a100pullups),1002(ftp-user) 

   Save and close the file.

2. **Restart ProFTPD if changes made**:
   After making changes to the configuration, restart the ProFTPD service to apply the changes:

   ```bash
   sudo systemctl restart proftpd
   ```


1. **Test FTP Access locally**:
   Use the command line to test access for the test user (Not Filezilla yet).

   **Using Command Line**:
   
   ```
   ftp localhost
   ```

Test you have file accesses

If ftp user created in CloudPanel, it’ll be tie to your website files. Run ls  and see if the files look familiar

Otherwise, if you created the ftp user outside of Cloudpanel like sudo adduser testuser (the DefaultRoot directive in the main config would place it in ~ or that new user’s folder), then play around with adding and getting files:
   ```
   ftp> ls
   ftp> put localfile.txt
   ftp> get remotefile.txt
   ```

If you encounter any issues during testing, you can check the ProFTPD logs for more details:

That could possibly be:
```
sudo tail -f /var/log/proftpd/proftpd.log
```

This proves plain FTP works, at least locally on the server.


**RECOMMEND SKIPPING: Enable FTP Access remotely**:

It is strongly suggested that you setup plain ftp so it can be used online if you need it for whatever reason. However ftp should be abandoned for SFTP. You may skip this section.

If you have firewall ufw enabled, and you still want to enable FTP, then run:
sudo ufw allow 21/tcp
sudo ufw reload

To test remotely, Google has disabled ftp in Chrome (except on enterprise versions). Web browser in the past you could just run `ftp://208.76.249.74` however they’ve disabled it. Google has also removed enabling ftp from chrome://flags

Filezilla theoretically you could try:
Protocol: FTP. 
Host: Public IP
Port: 21
Encryption: Only use plain FTP
Then supply the username and password

This is just in case you need to use plain FTP for whatever reason

