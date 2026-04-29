To unban an IP in Fail2Ban, use:

```bash
sudo fail2ban-client set JAIL_NAME unbanip IP_ADDRESS
```
^ What is jail name? Read up at [[Fail2Ban - What is Jail Name]]

For SSH, the jail is usually `sshd`:

```bash
sudo fail2ban-client set sshd unbanip 1.2.3.4
```

Example:

```bash
sudo fail2ban-client set sshd unbanip 203.0.113.10
```

To find the jail name first:

```bash
sudo fail2ban-client status
```

Then check a specific jail:

```bash
sudo fail2ban-client status sshd
```

That will show banned IPs for that jail.

A practical flow:

```bash
sudo fail2ban-client status
sudo fail2ban-client status sshd
sudo fail2ban-client set sshd unbanip 203.0.113.10
sudo fail2ban-client status sshd
```

If you use a different jail, such as `nginx-http-auth`, `apache-auth`, or a custom jail, replace `sshd` with that jail name:

```bash
sudo fail2ban-client set nginx-http-auth unbanip 203.0.113.10
```