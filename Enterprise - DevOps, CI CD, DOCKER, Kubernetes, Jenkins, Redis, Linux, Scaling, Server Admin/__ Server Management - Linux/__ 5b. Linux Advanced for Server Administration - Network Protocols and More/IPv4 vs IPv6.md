IPv4 and IPv6 are the systems used to give devices an IP address on a network.

**IPv4** uses **32-bit addresses**, which is about **4.3 billion possible addresses**. Because that supply is limited and mostly used up, many networks rely on **NAT (Network Address Translation)** so multiple devices can share one public IPv4 address.

**IPv6** uses **128-bit addresses**, which allows for an extremely large number of addresses — about **340 undecillion**. This gives enough unique addresses for the growing number of internet-connected devices and reduces the need for NAT.

What NAT does cost you more often is **complexity**, not raw speed:
- it keeps a translation table of connections
- it can make inbound connections harder
- it can complicate peer-to-peer apps, VoIP, gaming, VPNs, and port forwarding
- under very heavy traffic, a weak router/firewall doing NAT can become a bottleneck

Back to IPv4 vs IPv6 - another way to think about it:
- **IPv4 = 4 bytes**
- **IPv6 = 16 bytes**

Because IPv6 is much larger, it supports far more devices and is better suited for the future growth of the internet. It also includes improvements such as more efficient routing and easier automatic address configuration.

On a small local network, IPv4 is still often enough. The biggest need for IPv6 is at the broader internet scale, where the world is running out of public IPv4 addresses.

### Examples
- **IPv4 address:** `192.168.1.10`
- **IPv6 address:** `2001:0db8:85a3:0000:0000:8a2e:0370:7334`

### DNS records

In DNS management:
- **A records** point a domain to an **IPv4** address
- **AAAA records** point a domain to an **IPv6** address