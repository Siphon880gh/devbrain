
> **Important:** Fail2Ban only works if the service you want to protect is writing useful logs. For SSH protection, Fail2Ban must be able to see failed SSH login attempts in either `/var/log/auth.log` or the systemd journal.

Fail2Ban is an intrusion prevention tool for Linux servers. It watches logs for repeated failed login attempts, then bans the offending IP address through firewall rules.

It is commonly used for SSH, but it can also protect Apache, Nginx, mail servers, FTP, control panels, and web app login pages if those services write logs in a format Fail2Ban can read.

---

Important facts
- Fail2ban doesn't come installed with any Linux distros. Regardless, find out if you have it install with the command `which fail2ban-client`
- Fail2ban doesn't only just cover SSH. It covers SFTP, mail servers, etc. And you can configure it to work with your apps/api's and other endpoints (eg. `/wp-login.php`). Just make sure logging is enabled because Fail2ban relies on logging to look for failed login attempts. It bans IPs who have multipled failed login attempts
- Make sure you have an escape hatch plan. That could be a web terminal you can access after logging into your web host. You should consider whether your web host supports this or IT services to recover your server in case you accidentally get your own IP banned from repeated failed password attempts. You should document how to access the escape hatch in the same document where you write your web host, ssh, etc login credentials.

---

In one hour of installing fail2ban, already IPs are banned:
![[Pasted image 20260429034741.png]]

---

# 1. Required knowledge: where Fail2Ban config edits go

Fail2Ban config files usually live here:

```bash
/etc/fail2ban/
```

List them:

```bash
ls -l /etc/fail2ban/
```

Common files:

```bash
/etc/fail2ban/jail.conf
/etc/fail2ban/jail.local
/etc/fail2ban/jail.d/
```

The important rule:

```text
Read jail.conf for reference.
Put your live edits in jail.local.
```

Usually, do **not** edit:

```bash
/etc/fail2ban/jail.conf
```

That is the default reference file and may be overwritten during package updates.

Instead, create or edit:

```bash
sudo vi /etc/fail2ban/jail.local
```

That is the main file used in this guide.

Basic `vi` flow:

```text
i      enter insert mode
Esc    leave insert mode
:wq    save and quit
:q!    quit without saving
```

---

# 2. Install Fail2Ban

On Debian or Ubuntu:

```bash
sudo apt update
sudo apt install fail2ban
```

Check the service:

```bash
sudo systemctl status fail2ban
```

Start it if needed:

```bash
sudo systemctl start fail2ban
```

Enable it on boot:

```bash
sudo systemctl enable fail2ban
```

Check if the Fail2Ban client can talk to the Fail2Ban server:

```bash
sudo fail2ban-client ping
```

Expected:

```text
Server replied: pong
```

---

# 3. Common Debian 12 problem: socket error caused by bad log source

You may run:

```bash
sudo fail2ban-client ping
```

And see:

```text
ERROR Failed to access socket path: /var/run/fail2ban/fail2ban.sock. Is fail2ban running?
```

Do **not** manually create this socket file.

The socket is created automatically when the Fail2Ban server starts correctly.

Fail2Ban has two parts:

```text
fail2ban-client  = the command you type
fail2ban-server  = the background service that runs the jails
```

The client talks to the server through this socket:

```bash
/var/run/fail2ban/fail2ban.sock
```

On Debian 12, this error often happens because Fail2Ban failed during startup. A common reason is that the SSH jail is trying to watch:

```bash
/var/log/auth.log
```

But some Debian 12 or minimal VPS installs do not write SSH login failures to `/var/log/auth.log`. They may write them to the **systemd journal** instead.

The real chain may be:

```text
Fail2Ban watches /var/log/auth.log
        ↓
/var/log/auth.log does not exist
        ↓
sshd jail fails
        ↓
Fail2Ban server does not start
        ↓
fail2ban.sock is not created
        ↓
fail2ban-client ping fails
```

So the socket error is often just a symptom.

Check the real error:

```bash
sudo systemctl status fail2ban
sudo journalctl -u fail2ban -n 100 --no-pager
```

You may see:

```text
ERROR Failed during configuration: Have not found any log file for sshd jail
ERROR Async configuration of server failed
```

That means you need to fix the SSH jail’s log source.

---

# 4. First find where SSH failed logins are written

Do not assume `/var/log/auth.log`.

First, check whether the file exists:

```bash
ls -l /var/log/auth.log
```

If it exists, watch it:

```bash
sudo tail -f /var/log/auth.log
```

From your local computer, force a failed SSH login:

```bash
ssh -o PreferredAuthentications=password -o PubkeyAuthentication=no foobar@SERVER_IP
```

Enter a random password like:

```text
1234
```

If you see the failed login appear in `/var/log/auth.log`, then Fail2Ban can use that file.

If `/var/log/auth.log` does not exist, or the failed login does not appear there, check the systemd journal.

On Debian, the SSH service is often named:

```bash
ssh
```

not:

```bash
sshd
```

Check the service name:

```bash
systemctl list-units --type=service | grep -Ei 'ssh|sshd'
```

You may see:

```text
ssh.service loaded active running OpenBSD Secure Shell server
```

Now watch SSH logs in the systemd journal:

```bash
sudo journalctl -u ssh -f
```

If that shows nothing useful, also try:

```bash
sudo journalctl -u sshd -f
```

Then from your local computer, force the failed SSH login again:

```bash
ssh -o PreferredAuthentications=password -o PubkeyAuthentication=no foobar@SERVER_IP
```

Enter:

```text
1234
```

If you see something like this in `journalctl`:

```text
Failed password for invalid user foobar from YOUR_IP
Invalid user foobar from YOUR_IP
```

then SSH authentication failures are available through the systemd journal.

That means your Fail2Ban SSH jail should use:

```ini
backend = systemd
```

not:

```ini
logpath = /var/log/auth.log
```

---

# 5. Debian 12 fix: use the systemd backend

Use this fix when:

- `/var/log/auth.log` does not exist, or
    
- `/var/log/auth.log` exists but does not show SSH failed logins, and
    
- `journalctl -u ssh -f` does show SSH failed logins.
    

Open the Fail2Ban jail config:

```bash
sudo vi /etc/fail2ban/jail.local
```

Add or update the SSH jail, making sure backend is before enabled
```ini
[sshd]
backend = systemd
enabled = true
port = ssh
filter = sshd
maxretry = 3
```

Save and quit:

```text
Esc
:wq
Enter
```

Then install the Python systemd package that Fail2Ban may need for the systemd backend:

```bash
sudo apt install python3-systemd
```

Restart Fail2Ban:

```bash
sudo systemctl restart fail2ban
```

Check the service:

```bash
sudo systemctl status fail2ban
```

Check if the client can talk to the server:

```bash
sudo fail2ban-client ping
```

Expected:

```text
Server replied: pong
```

Check the SSH jail:

```bash
sudo fail2ban-client status sshd
```

If it is working with systemd, the status may mention journal matching instead of a file list.

The important part is this:

```ini
backend = systemd
```

That tells Fail2Ban to read SSH failures from the systemd journal.

For this setup, avoid this line:

```ini
logpath = /var/log/auth.log
```

Use `logpath` only when you already proved failed SSH logins appear in:

```bash
sudo tail -f /var/log/auth.log
```

---

# 6. Config option A: SSH logs are in systemd journal

Use this if the failed SSH login appears here:

```bash
sudo journalctl -u ssh -f
```

Open:

```bash
sudo vi /etc/fail2ban/jail.local
```

Add or update:
- Ban time could be 1s, 1m, 1h... 24h.
- Ban time can be permanent at `bantime = -1` however permanent Fail2Ban bans can eventually slow things down if thousands or tens of thousands of IPs accumulate, especially when the bans are inserted as many individual firewall rule because Fail2Ban is just adding rules to iptables.
```ini
[DEFAULT]
allowipv6 = auto
ignoreip = 127.0.0.1/8 ::1
bantime = 24h
findtime = 10m
maxretry = 5

[sshd]
backend = systemd
enabled = true
port = ssh
filter = sshd
maxretry = 3
```

Save and quit:

```text
Esc
:wq
Enter
```

Install the systemd Python package if not already installed:

```bash
sudo apt install python3-systemd
```

Restart Fail2Ban:

```bash
sudo systemctl restart fail2ban
```

Verify:

```bash
sudo fail2ban-client ping
sudo fail2ban-client status
sudo fail2ban-client status sshd
```

Expected:

```text
Server replied: pong
```

You do **not** need this when using the systemd backend:

```ini
logpath = /var/log/auth.log
```

---

# 7. Config option B: SSH logs are in `/var/log/auth.log`

Use this only if the failed SSH login appears here:

```bash
sudo tail -f /var/log/auth.log
```

Open:

```bash
sudo vi /etc/fail2ban/jail.local
```

Add or update:

```ini
[DEFAULT]
allowipv6 = auto
ignoreip = 127.0.0.1/8 ::1
bantime = 1h
findtime = 10m
maxretry = 5

[sshd]
enabled = true
port = ssh
filter = sshd
logpath = /var/log/auth.log
maxretry = 3
```

Save and quit:

```text
Esc
:wq
Enter
```

Restart:

```bash
sudo systemctl restart fail2ban
```

Verify:

```bash
sudo fail2ban-client ping
sudo fail2ban-client status sshd
```

If `/var/log/auth.log` does not exist, do **not** point Fail2Ban to it.

If `/var/log/auth.log` exists but does not show failed SSH logins, do **not** use it yet.

Fail2Ban must watch the place where the failed login actually appears.

---

# 8. Is `/var/log/auth.log` set in SSH config?

Usually, no.

The SSH server config is usually:

```bash
/etc/ssh/sshd_config
```

You can inspect SSH logging-related settings:

```bash
sudo grep -Ei 'SyslogFacility|LogLevel' /etc/ssh/sshd_config
```

You may see:

```text
SyslogFacility AUTH
LogLevel INFO
```

These settings control the category and detail level of SSH logging.

They usually do **not** directly say:

```text
write logs to /var/log/auth.log
```

The actual destination is usually controlled by the logging system:

```text
sshd
  ↓
systemd-journald and/or rsyslog
  ↓
journalctl and/or /var/log/auth.log
```

So the SSH config controls what SSH reports.

The system logging layer controls where those logs go.

---

# 9. Check whether rsyslog is creating `/var/log/auth.log`

The traditional `/var/log/auth.log` file is commonly created by `rsyslog`.

Check if `rsyslog` is installed:

```bash
dpkg -l | grep rsyslog
```

Check if it is running:

```bash
sudo systemctl status rsyslog
```

Inspect rsyslog auth rules:

```bash
grep -R "auth" /etc/rsyslog.conf /etc/rsyslog.d/ 2>/dev/null
```

A rule like this means auth logs are written to `/var/log/auth.log`:

```text
auth,authpriv.*                 /var/log/auth.log
```

or:

```text
authpriv.*                      /var/log/auth.log
```

If `rsyslog` is not installed or not running, that may explain why `/var/log/auth.log` does not exist.

If you want the traditional file-based setup:

```bash
sudo apt update
sudo apt install rsyslog
sudo systemctl enable --now rsyslog
```

Then force a failed SSH login again and check:

```bash
sudo tail -f /var/log/auth.log
```

From your local computer:

```bash
ssh -o PreferredAuthentications=password -o PubkeyAuthentication=no foobar@SERVER_IP
```

Enter:

```text
1234
```

If the failed login appears in `/var/log/auth.log`, then you can use:

```ini
[sshd]
enabled = true
logpath = /var/log/auth.log
```

inside:

```bash
/etc/fail2ban/jail.local
```

---

# 10. Search `/var/log` if you are not sure

After forcing the failed SSH login, search `/var/log` for your test username:

```bash
sudo grep -R "foobar" /var/log 2>/dev/null
```

Search for common SSH failure text:

```bash
sudo grep -R "Failed password" /var/log 2>/dev/null
```

Search for your local IP address:

```bash
sudo grep -R "YOUR_IP" /var/log 2>/dev/null
```

You can also list recently modified log files:

```bash
sudo find /var/log -type f -mmin -10 -ls 2>/dev/null
```

That command shows log files modified in the last 10 minutes.

If the failed login appears in a file, that file may be a possible Fail2Ban `logpath`.

If the failed login appears only in:

```bash
sudo journalctl -u ssh -f
```

then use:

```ini
backend = systemd
```

---

# 11. Useful live checks

Check active jails:

```bash
sudo fail2ban-client status
```

Check the SSH jail:

```bash
sudo fail2ban-client status sshd
```

Watch Fail2Ban logs:

```bash
sudo journalctl -u fail2ban -f
```

Check recent Fail2Ban startup errors:

```bash
sudo journalctl -u fail2ban -n 100 --no-pager
```

Check if a traditional Fail2Ban log exists:

```bash
ls -l /var/log/fail2ban.log
```

If it exists:

```bash
sudo tail -f /var/log/fail2ban.log
```

When Fail2Ban detects and bans IPs, you may see lines like:

```text
Found 1.2.3.4
Ban 1.2.3.4
Unban 1.2.3.4
```

---

# 12. Test the SSH jail carefully

Keep your current SSH session open so you do not lock yourself out.

In one server terminal, watch SSH logs.

If using systemd:

```bash
sudo journalctl -u ssh -f
```

If using `/var/log/auth.log`:

```bash
sudo tail -f /var/log/auth.log
```

In another server terminal, watch Fail2Ban:

```bash
sudo journalctl -u fail2ban -f
```

From your local computer, force failed logins:

```bash
ssh -o PreferredAuthentications=password -o PubkeyAuthentication=no foobar@SERVER_IP
```

Enter a bad password:

```text
1234
```

After enough failures, check:

```bash
sudo fail2ban-client status sshd
```

Look for:

```text
Currently failed:
Total failed:
Currently banned:
Banned IP list:
```

Be careful. You can ban your own IP while testing.

---

# 13. Whitelist your own IP

To reduce lockout risk, add your IP to `ignoreip`.

Open:

```bash
sudo vi /etc/fail2ban/jail.local
```

Update `[DEFAULT]`:

```ini
[DEFAULT]
allowipv6 = auto
ignoreip = 127.0.0.1/8 ::1 YOUR.IP.ADDRESS.HERE
```

Example:

```ini
[DEFAULT]
allowipv6 = auto
ignoreip = 127.0.0.1/8 ::1 123.123.123.123
```

Save and quit:

```text
Esc
:wq
Enter
```

Restart:

```bash
sudo systemctl restart fail2ban
```

Check:

```bash
sudo fail2ban-client status sshd
```

---

# 14. Ban and unban commands

Show banned IPs:

```bash
sudo fail2ban-client banned
```

Check where one IP is banned:

```bash
sudo fail2ban-client banned 1.2.3.4
```

Check SSH jail status:

```bash
sudo fail2ban-client status sshd
```

Unban one IP globally:

```bash
sudo fail2ban-client unban 1.2.3.4
```

Unban one IP from the SSH jail:

```bash
sudo fail2ban-client set sshd unbanip 1.2.3.4
```

Unban all IPs:

```bash
sudo fail2ban-client unban --all
```

Use `--all` carefully. It releases every Fail2Ban ban.

---

# 15. Reload or restart after edits

After editing:

```bash
sudo vi /etc/fail2ban/jail.local
```

Reload Fail2Ban:

```bash
sudo fail2ban-client reload
```

Or restart it:

```bash
sudo systemctl restart fail2ban
```

If Fail2Ban was already running, reload is often enough.

If Fail2Ban failed to start because of a broken config, restart is clearer:

```bash
sudo systemctl restart fail2ban
```

Then check:

```bash
sudo systemctl status fail2ban
sudo fail2ban-client ping
sudo fail2ban-client status sshd
```

---

# 16. Restart only one jail

If you only changed the SSH jail, you can restart just that jail:

```bash
sudo fail2ban-client restart sshd
```

Or reload that jail:

```bash
sudo fail2ban-client reload sshd
```

You can also reload and restart the affected jail:

```bash
sudo fail2ban-client reload --restart sshd
```

This is useful when you do not want to disturb every Fail2Ban jail on the server.

---

# 17. Common warning: `allowipv6`

You may see:

```text
WARNING 'allowipv6' not defined in 'Definition'. Using default one: 'auto'
```

This is usually only a warning.

It is usually not the reason Fail2Ban failed.

To quiet it, open:

```bash
sudo vi /etc/fail2ban/jail.local
```

Add under `[DEFAULT]`:

```ini
[DEFAULT]
allowipv6 = auto
```

Save and reload:

```bash
sudo fail2ban-client reload
```

If Fail2Ban still fails, look for the real `ERROR` line, such as:

```text
ERROR Failed during configuration: Have not found any log file for sshd jail
```

That error matters more than the IPv6 warning.

---

# 18. Quick diagnosis workflow

Use this when Fail2Ban will not start.

Check Fail2Ban:

```bash
sudo systemctl status fail2ban
sudo journalctl -u fail2ban -n 100 --no-pager
```

If you see:

```text
Have not found any log file for sshd jail
```

check whether `/var/log/auth.log` exists:

```bash
ls -l /var/log/auth.log
```

If it exists, test it:

```bash
sudo tail -f /var/log/auth.log
```

Then from your local computer:

```bash
ssh -o PreferredAuthentications=password -o PubkeyAuthentication=no foobar@SERVER_IP
```

Enter:

```text
1234
```

If the failed login appears in `/var/log/auth.log`, use this in:

```bash
/etc/fail2ban/jail.local
```

```ini
[sshd]
enabled = true
logpath = /var/log/auth.log
```

If the failed login does **not** appear there, check the journal:

```bash
sudo journalctl -u ssh -f
```

Force the failed login again.

If the failed login appears in the journal, use this in:

```bash
/etc/fail2ban/jail.local
```

```ini
[sshd]
backend = systemd
enabled = true
port = ssh
filter = sshd
maxretry = 3
```

Then install:

```bash
sudo apt install python3-systemd
```

Restart:

```bash
sudo systemctl restart fail2ban
```

Verify:

```bash
sudo fail2ban-client ping
sudo fail2ban-client status sshd
```

Expected:

```text
Server replied: pong
```

---

# 19. Useful command list

Service commands:

```bash
sudo systemctl status fail2ban
sudo systemctl start fail2ban
sudo systemctl restart fail2ban
sudo systemctl stop fail2ban
sudo systemctl enable fail2ban
```

Client checks:

```bash
sudo fail2ban-client ping
sudo fail2ban-client status
sudo fail2ban-client status sshd
```

Reload commands:

```bash
sudo fail2ban-client reload
sudo fail2ban-client reload sshd
sudo fail2ban-client restart sshd
sudo fail2ban-client reload --restart sshd
```

Ban checks:

```bash
sudo fail2ban-client banned
sudo fail2ban-client banned 1.2.3.4
sudo fail2ban-client unban 1.2.3.4
sudo fail2ban-client set sshd unbanip 1.2.3.4
sudo fail2ban-client unban --all
```

Log checks:

```bash
sudo journalctl -u fail2ban -n 100 --no-pager
sudo journalctl -u fail2ban -f
sudo journalctl -u ssh -f
sudo tail -f /var/log/auth.log
```

---

# 20. Important live-server cautions

Fail2Ban is helpful, but it is not magic.

It depends on:

- useful logs
    
- the correct log source
    
- correct filters
    
- active jails
    
- working firewall actions
    
- proper service configuration
    

Fail2Ban works best against repeated attacks from the same IP address.

It is less effective against large distributed attacks where each IP only tries once or twice.

For SSH, Fail2Ban is a good layer, but you should still use stronger basics:

- SSH keys instead of passwords
    
- disable root SSH login
    
- use a firewall
    
- restrict access by IP when possible
    
- keep packages updated
    
- keep another active SSH session open when testing security changes
    

---

# 21. Mental model

Think of Fail2Ban like this:

```text
SSH writes failed login logs
        ↓
logs go to journalctl or /var/log/auth.log
        ↓
Fail2Ban watches that same source
        ↓
sshd filter detects bad attempts
        ↓
sshd jail bans the IP
```

The key lesson:

```text
Do not assume /var/log/auth.log.
First prove where failed SSH logins appear.
Then edit /etc/fail2ban/jail.local to match that source.
```

For Debian 12, if failed SSH logins appear in:

```bash
sudo journalctl -u ssh -f
```

use this in:

```bash
sudo vi /etc/fail2ban/jail.local
```

```ini
[sshd]
backend = systemd
enabled = true
port = ssh
filter = sshd
maxretry = 3
```

Then run:

```bash
sudo apt install python3-systemd
sudo systemctl restart fail2ban
sudo fail2ban-client ping
sudo fail2ban-client status sshd
```

If failed SSH logins appear in:

```bash
sudo tail -f /var/log/auth.log
```

use this instead:

```ini
[sshd]
enabled = true
logpath = /var/log/auth.log
```

The best Fail2Ban config is not the one copied from a tutorial.

The best config is the one that matches where your server is actually writing the logs.