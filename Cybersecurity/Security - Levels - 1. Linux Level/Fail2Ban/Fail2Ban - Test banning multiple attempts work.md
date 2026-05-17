You can force a real ban test by first connecting through a VPN so your public IP address changes. Then, from that VPN IP, intentionally fail SSH authentication several times until you hit the `maxretry` limit set in your Fail2Ban config.

You can see maxretry at:
/etc/fail2ban/jail.local

If maxretry not defined there, see the defaults at
/etc/fail2ban/jail.conf

From your local computer, force a failed SSH login:

```bash
ssh -o PreferredAuthentications=password -o PubkeyAuthentication=no foobar@SERVER_IP
```

Enter a random password like:

```text
1234
```

Repeat the failed login up to maxretry. You should get banned.

You can unban using [[Fail2Ban - Unban IP]]

If you were not paying attention and didn't go on a VPN, now you have to have an escape hatch to unban yourself. Usually that involves logging into your web host and hopefully they provide a SSH terminal that you can access on their web dashboard.

This lets you confirm that Fail2Ban is actually detecting repeated failed SSH attempts and banning the source IP.

See: [[Fail2Ban - Test banning multiple attempts work]]