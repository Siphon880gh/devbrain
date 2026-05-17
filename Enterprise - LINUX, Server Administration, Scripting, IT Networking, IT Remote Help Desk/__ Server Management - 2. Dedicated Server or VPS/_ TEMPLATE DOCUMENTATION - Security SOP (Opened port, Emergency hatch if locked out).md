About: All things that deal with security that are unique to your web host and apps.

## UFW Open Ports

8443 PMA Php MyAdmin and CloudPanel
80
443
27017 MongoDB

## Escape Hatch

This is an **escape hatch**: a backup way to access your server if your normal SSH access gets locked out. For example, your web host may provide a browser-based SSH terminal inside the hosting control panel. This can save you if your computer’s IP address is accidentally blocked from accessing terminal SSH after too many failed login attempts, especially when tools like Fail2Ban are active.

Hetzner -> Dashboard -> Servers (left sidebar item) -> Select your server -> Top right `>-` button
![[Pasted image 20260516221245.png]]