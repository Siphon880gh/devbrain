Covered only if configured.
FTP uses separate daemons like:
- vsftpd
- proftpd
- pure-ftpd

You must enable the correct jail manually:
```
[vsftpd]
enabled = true
```