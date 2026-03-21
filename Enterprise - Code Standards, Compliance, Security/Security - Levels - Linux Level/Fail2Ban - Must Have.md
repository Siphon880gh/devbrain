Fail2Ban is an open-source intrusion prevention tool for Linux servers that helps block brute-force attacks. It monitors logs such as SSH, Apache, or Nginx for repeated failed attempts, then automatically updates firewall rules to temporarily or permanently ban offending IP addresses. It is typically managed through the command line using config files, systemctl, and fail2ban-client.

Fail2Ban is commonly managed from the CLI.

Typical commands include:
```
sudo systemctl status fail2ban
sudo systemctl start fail2ban
sudo systemctl restart fail2ban
sudo fail2ban-client status
sudo fail2ban-client status sshd
sudo fail2ban-client set sshd unbanip 1.2.3.4
```

So you usually manage it by:

- editing config files such as `jail.local`
- controlling the service with `systemctl`
- checking and changing bans with `fail2ban-client`