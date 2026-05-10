Typical commands for system management include:
```bash
sudo systemctl status fail2ban
sudo systemctl start fail2ban
sudo systemctl restart fail2ban
sudo fail2ban-client status
sudo fail2ban-client status sshd
sudo fail2ban-client set sshd unbanip 1.2.3.4
```

You usually manage:
- editing config files such as `jail.local`
- controlling the service with `systemctl`
- checking and changing bans with `fail2ban-client`