When configuring firewall rules, SSH settings, or Fail2Ban, you can accidentally block your own access.

Common examples:
* You close the SSH port by mistake.
* You allow the wrong IP address.
* You mistype your SSH password too many times.
* Fail2Ban blocks your current IP address.
* A firewall rule prevents your terminal from reconnecting.

This is why you need an **emergency hatch**: a backup way to reach the server even when normal SSH is blocked.

The most common emergency hatch is a **web-based SSH console** inside your hosting provider’s dashboard. For example, Hetzner provides a browser console that lets you access the server even if your regular SSH connection is blocked (Hetzner -> Dashboard -> "Servers" left sidebar item -> Select your server -> Top right `>-` button)

![[Pasted image 20260516221245.png]]

----

Another escape hatch of course is to use a VPS to change your IP or go to an internet cafe with another IP, then re-attempt SSH login. There you can unban yourself with [[Fail2Ban - Unban IP]]

---


Before making firewall or Fail2Ban changes, find out whether your host provides:
* Web SSH console
* Serial console
* Rescue mode
* VNC console
* Recovery console

Then document the recovery steps in your ACC document that includes:
* Hosting provider login URL
* Account username or owner
* Where to find the server
* Where to open the web console
* Any recovery-mode instructions
* Notes on how to unblock your IP or fix firewall rules

The goal is simple: **before you harden access, make sure you know how to recover access.**