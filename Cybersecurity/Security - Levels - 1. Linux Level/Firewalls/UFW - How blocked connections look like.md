![[Pasted image 20260517040341.png]]

When UFW blocks network traffic, the log usually contains a line like this:

```txt
[UFW BLOCK] IN=eth0 OUT= MAC=... SRC=139.5.26.237 DST=31.220.18.169 PROTO=TCP SPT=49280 DPT=443 SYN
```

The most important part is:

```txt
[UFW BLOCK]
SRC=139.5.26.237
DST=31.220.18.169
PROTO=TCP
SPT=49280
DPT=443
SYN
```

This means an outside IP address tried to start a TCP connection to the server, but UFW blocked the packet.

|Field|Meaning|
|---|---|
|`[UFW BLOCK]`|UFW blocked/dropped the packet|
|`IN=eth0`|The packet came in through the `eth0` network interface|
|`SRC=139.5.26.237`|The outside IP address trying to connect|
|`DST=31.220.18.169`|The server IP being targeted|
|`PROTO=TCP`|The traffic used TCP|
|`SPT=49280`|The source port from the outside machine|
|`DPT=443`|The destination port on the server|
|`SYN`|The first packet of a TCP connection attempt|

Since `DPT=443` means HTTPS, this log shows that something tried to connect to the server’s HTTPS port and UFW dropped the attempt.

---

# How to Read UFW Logs

On Debian/Ubuntu systems, UFW block messages often appear in the kernel logs.

To watch UFW blocks live:

```bash
sudo journalctl -k -f | grep "UFW BLOCK"
```

To show UFW blocks from the last hour:

```bash
sudo journalctl -k -g "UFW BLOCK" -S -1h
```

To show UFW blocks from today:

```bash
sudo journalctl -k -g "UFW BLOCK" -S today
```

To read the traditional UFW log file, if enabled:

```bash
sudo less /var/log/ufw.log
```

To search that file for blocked packets:

```bash
sudo grep "UFW BLOCK" /var/log/ufw.log
```

If `/var/log/ufw.log` is missing or empty, check whether UFW logging is enabled:

```bash
sudo ufw status verbose
```

Enable UFW logging with:

```bash
sudo ufw logging on
```

For more detailed logs:

```bash
sudo ufw logging medium
```

---

# Firewall Blocking vs IP Banning

A UFW block log means the firewall dropped a packet. It does not automatically mean the source IP was permanently banned.

## Firewall blocking

Firewall blocking means the traffic did not match an allowed rule, so UFW rejected or dropped it.

For example, if the server has a default deny policy:

```txt
Default: deny incoming
```

Then inbound traffic is blocked unless a rule specifically allows it.

Check the current firewall policy with:

```bash
sudo ufw status verbose
```

## IP banning

IP banning is different.

A ban usually means an IP address was specifically added to a block list because it behaved suspiciously or maliciously.

That type of ban usually comes from tools such as:

```txt
fail2ban
CrowdSec
iptables/nftables custom rules
Cloudflare firewall rules
```

A plain `[UFW BLOCK]` log only proves that UFW blocked the packet. It does not prove that the IP was placed on a permanent ban list.

---

# What These Logs Are Trying to Access

Most of the entries target:

```txt
DPT=443
```

That means the outside machine tried to connect to HTTPS.

Example IPv4 entry:

```txt
SRC=139.5.26.237 DST=31.220.18.169 DPT=443
```

Example IPv6 entry:

```txt
SRC=2409:4091:8064:3c04:... DST=2a02:4780:0010:f2c7:... DPT=443
```

This means both IPv4 and IPv6 addresses are trying to reach the server over HTTPS.

That is common on public VPS and dedicated servers. Public IP addresses are constantly scanned by bots, crawlers, vulnerability scanners, and automated traffic.

---

# If the Website Is Supposed to Be Public

If the server is hosting a public website, port `443` usually needs to be allowed.

Check current UFW rules:

```bash
sudo ufw status verbose
```

If HTTPS is not allowed, add:

```bash
sudo ufw allow 443/tcp
```

For a normal website, HTTP is often allowed too:

```bash
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
```

Or, if UFW has an Nginx profile available:

```bash
sudo ufw allow 'Nginx Full'
```

Then confirm the rules:

```bash
sudo ufw status numbered
```

Also check whether Nginx is listening on HTTPS:

```bash
sudo ss -tulpn | grep ':443'
```

To check both HTTP and HTTPS:

```bash
sudo ss -tulpn | grep -E ':80|:443'
```

---

# If the Website Is Behind Cloudflare

If the site is behind Cloudflare’s proxy, blocked direct traffic can be a good sign.

The expected traffic path should be:

```txt
Visitor/Bot -> Cloudflare -> Origin server
```

In that setup, the origin server should ideally allow web traffic only from Cloudflare IP ranges.

Allowed:

```txt
Cloudflare IP -> Origin server:443
```

Blocked:

```txt
Random internet IP -> Origin server:443
```

So if random IPs are trying to reach the origin server directly, UFW blocking them helps prevent bots from bypassing Cloudflare.

---

# Why There Are So Many Source IPs

When many different `SRC=` values appear in the logs, it usually points to normal internet scanning or automated bot traffic.

Common reasons include:

```txt
Internet-wide port scanning
Bots looking for exposed HTTPS services
Direct hits to the origin IP
The origin IP being known publicly
IPv6 being exposed even if IPv4 is protected
```

The IPv6 part is especially important. A server may have both an IPv4 address and an IPv6 address. Even if IPv4 is protected, IPv6 may still be publicly reachable unless firewall rules cover it too.

Check UFW status with:

```bash
sudo ufw status verbose
```

Check listening services with:

```bash
sudo ss -tulpn
```

---

# Useful Commands

Check UFW status:

```bash
sudo ufw status verbose
```

Show numbered UFW rules:

```bash
sudo ufw status numbered
```

Watch UFW blocks live:

```bash
sudo journalctl -k -f | grep "UFW BLOCK"
```

Show UFW blocks from the last hour:

```bash
sudo journalctl -k -g "UFW BLOCK" -S -1h
```

Show UFW blocks from today:

```bash
sudo journalctl -k -g "UFW BLOCK" -S today
```

Read the UFW log file:

```bash
sudo less /var/log/ufw.log
```

Search the UFW log file:

```bash
sudo grep "UFW BLOCK" /var/log/ufw.log
```

Check whether Nginx is listening on HTTPS:

```bash
sudo ss -tulpn | grep ':443'
```

Check whether anything is listening on HTTP or HTTPS:

```bash
sudo ss -tulpn | grep -E ':80|:443'
```

---

# Bottom Line

A log entry like this:

```txt
[UFW BLOCK] ... SRC=<outside-ip> DST=<server-ip> PROTO=TCP DPT=443 SYN
```

means:

```txt
An outside IP tried to start an HTTPS connection to the server, and UFW blocked the packet.
```

This means the connection attempt was blocked. It does not necessarily mean the IP was permanently banned.

If the website should be publicly reachable, make sure port `443` is allowed.

If the website is protected behind Cloudflare, blocking random direct traffic to the origin server may be the desired behavior.